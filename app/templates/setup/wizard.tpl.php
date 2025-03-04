<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>InlineCMS <?php echo $lang['setupWizard']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- TailwindCSS CDN -->
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="<?php echo ROOT_URL; ?>/static/font-awesome/css/font-awesome.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
  <script src="<?php echo ROOT_URL; ?>/static/setup/setup.js"></script>
</head>
<body class="bg-gray-800 text-gray-200">
  <div id="wrapper" class="max-w-4xl mx-auto">
    <header class="bg-slate-700 p-4 text-center">
      <h1 class="text-4xl font-light">InlineCMS <span class="text-green-400"><?php echo $lang['setupWizard']; ?></span></h1>
    </header>

    <section class="p-5">
      <!-- Step Indicator -->
      <div id="steps" class="mb-6">
        <ul class="flex space-x-2">
          <?php foreach ($steps as $stepId => $stepTitle) { ?>
            <li data-step="<?php echo $stepId; ?>" class="step-item <?php echo ($stepId==$currentStep) ? 'active' : 'inactive'; ?>">
              <?php echo $stepTitle; ?>
            </li>
          <?php } ?>
        </ul>
      </div>

      <!-- Step Content -->
      <div id="content" class="mb-6">
        <?php echo $step; ?>
      </div>

      <!-- Navigation Buttons -->
      <div id="buttons" class="buttons flex justify-between">
        <button class="b-prev bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
          <i class="fa fa-caret-left"></i> <?php echo $lang['prevStep']; ?>
        </button>
        <button class="b-next bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
          <?php echo $lang['nextStep']; ?> <i class="fa fa-caret-right"></i>
        </button>
        <button class="b-finish bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
          <?php echo $lang['finishContinue']; ?> <i class="fa fa-caret-right"></i>
        </button>
      </div>

      <!-- Loading Indicator -->
      <div id="loading-indicator" class="mt-4 text-center hidden">
        <i class="fa fa-cog fa-spin text-2xl"></i>
      </div>
    </section>

    <footer class="bg-slate-700 p-4 text-center">
      <p>InlineCMS Team &copy; <?php echo date('Y'); ?></p>
    </footer>
  </div>

  <div id="steps-cache" class="hidden"></div>

  <script>
    var setup;
    $(document).ready(function(){
      setup = new SetupWizard({
        backendUrl: '<?php echo ROOT_URL . '/backend.php'; ?>',
        rootUrl: '<?php echo ROOT_URL; ?>',
        lang: '<?php echo $langId; ?>',
        title: '<?php echo $lang['setupWizard']; ?>'
      });
      setup.start();
    });
  </script>
</body>
</html>
