function SetupWizard(options) {
    this.steps = [];
    this.currentStep = null;
    this.options = options;
    this.data = { lang: options.lang };

    this.showMessageDialog = function(message) {
        if (typeof message === 'object') {
            message = Object.values(message).join("\n");
        }
        alert(message);
    };

    this.showLoadingIndicator = function() {
        $('#loading-indicator').show();
        $('#content').addClass('faded');
    };

    this.hideLoadingIndicator = function() {
        $('#loading-indicator').hide();
        $('#content').removeClass('faded');
    };

    this.runModule = function(module, action, params, callback) {
        params._module = module;
        params._action = action;
        $.post(this.options.backendUrl, params, function(result) {
            if (typeof callback === 'function') {
                callback(result);
            }
        }, 'json');
    };

    this.validateStep = function(callback) {
        this.showLoadingIndicator();
        var params = {};
        $('#content form *[name]').each(function() {
            params[$(this).attr('name')] = $(this).val();
        });
        this.data = $.extend(this.data, params);
        params.step = this.currentStep;
        params.lang = this.options.lang;
        var self = this;
        this.runModule('setup', 'validateStep', params, function(result) {
            if (result.success) {
                callback();
            } else {
                self.hideLoadingIndicator();
                self.showMessageDialog(result.error);
            }
        });
    };

    this.onStepChanged = function(oldStep, step) {
        this.currentStep = step;
        $('#steps li').removeClass('active passed');
        var index = $('#steps li[data-step="'+step+'"]').addClass('active').index();
        $('#steps li:lt('+index+')').addClass('passed');
        $('.buttons .b-prev').toggle(step !== this.steps[0]);
        $('.buttons .b-next').toggle(step !== 'finish');
        $('.buttons .b-finish').toggle(step === 'finish');
        $('#content input:text').eq(0).focus();
    };

    this.loadStep = function(step) {
        var oldStep = this.currentStep;
        if ($('#steps-cache .step-' + step).length > 0 && oldStep !== step) {
            this.hideLoadingIndicator();
            $('#content').html($('#steps-cache .step-' + step).html());
            this.onStepChanged(oldStep, step);
            return;
        }
        this.showLoadingIndicator();
        var self = this;
        this.runModule('setup', 'loadStep', { step: step, lang: this.options.lang }, function(result) {
            $('#content').html(result.html);
            self.onStepChanged(oldStep, step);
            self.hideLoadingIndicator();
        });
    };

    this.unloadStep = function() {
        $('form input:text, form input:password, form textarea', $('#content')).each(function() {
            $(this).attr('value', $(this).val());
        });
        var cache = $('#content').clone().removeAttr('id').removeClass('faded');
        cache.addClass('step-' + this.currentStep).appendTo('#steps-cache');
    };

    this.nextStep = function() {
        var currentIndex = this.steps.indexOf(this.currentStep);
        var nextStepIndex = currentIndex + 1;
        if (nextStepIndex < this.steps.length) {
            var nextStep = this.steps[nextStepIndex];
            var self = this;
            this.validateStep(function() {
                self.unloadStep();
                self.loadStep(nextStep);
            });
        }
    };

    this.prevStep = function() {
        var currentIndex = this.steps.indexOf(this.currentStep);
        var prevStepIndex = currentIndex - 1;
        if (prevStepIndex >= 0) {
            var prevStep = this.steps[prevStepIndex];
            this.unloadStep();
            this.loadStep(prevStep);
        }
    };

    this.finish = function() {
        this.showLoadingIndicator();
        this.runModule('setup', 'save', this.data, function(result) {
            if (result.success) {
                window.location.href = result.next_url;
            }
        });
    };

    this.start = function() {
        $('#steps li').each(function() {
            var stepId = $(this).data('step');
            setup.steps.push(stepId);
            if ($(this).hasClass('active')) { setup.currentStep = stepId; }
        });
        $('.buttons .b-next').click(() => this.nextStep());
        $('.buttons .b-prev').click(() => this.prevStep());
        $('.buttons .b-finish').click(() => this.finish());
    };
}