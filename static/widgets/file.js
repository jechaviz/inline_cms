cms.registerWidgetHandler("file",new function(){InlineWidget.apply(this,arguments);this.getName=function(){return"file"};this.getIcon=function(){return"fa-download"};this.getToolbarButtons=function(){var a=this;return{options:{click:function(c,b){a.openOptionsForm(c,b)}}}};this.getOptionsFormSettings=function(){var a=this;return{onCreate:function(e){var f=$(".f-upload",e);var b=$(".f-title input",e);var g=$(".f-url input",e);var c=$(".f-name input",e);var d=$(".f-size input",e);$(".f-uploaded .filename a",e).click(function(){$(".f-uploaded",e).hide();$(".f-upload",e).show();b.val("");g.val("");c.val("");d.val("");a.runBackend("delete",{url:g.val()})});$("input",f).fileupload({url:cms.getModuleUrl("uploader","upload"),dataType:"json",submit:function(){$("input",f).hide();$("<div/>").addClass("inlinecms-uploading").html('<i class="fa fa-spinner fa-spin"></i> '+cms.lang("uploading")).insertAfter($("input",f))},always:function(j,h){$("input",f).show();$(".inlinecms-uploading").remove();if(!h.result.success){if(h.result.error){cms.showMessageDialog(h.result.error,cms.lang("error"))}return}var i=h.result.name+" ("+h.result.size_formatted+")";$(".f-uploaded",e).find("span").html(i).end().show();$(".f-upload",e).hide();if(!b.val()){b.val(h.result.name)}g.val(h.result.url);c.val(h.result.name);d.val(h.result.size_formatted)}})},onShow:function(c,b){if(b&&b.name){$(".f-uploaded",c).find("span").html(b.name).end().show();$(".f-upload",c).hide()}else{$(".f-uploaded",c).hide();$(".f-upload",c).show()}}}};this.onCreateWidget=function(a,b){this.openOptionsForm(b,a.id);return a};this.applyOptions=function(b,a){var c=this.dom(b);c.empty();if(!a.url){return}$("<a/>").html(a.title).attr("href",a.url).appendTo(c);if(a.is_size){$("<span/>").html(a.size).appendTo(c)}}});