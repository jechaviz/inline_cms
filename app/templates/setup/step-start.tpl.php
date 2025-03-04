<form id="step-start" class="space-y-4">
  <h2 class="text-3xl font-bold"><?php echo $lang['welcome']; ?></h2>
  <p><?php echo $lang['welcomeText']; ?></p>
  <p class="font-medium"><?php echo $lang['selectLang']; ?>:</p>
  <ul id="languages" class="flex space-x-4">
    <?php foreach ($langs as $langId => $details) { ?>
      <?php $isCurrent = ($currentLang == $langId); ?>
      <li class="<?php echo $isCurrent ? 'bg-green-600 text-white p-2 rounded' : 'bg-gray-700 text-gray-200 p-2 rounded'; ?>">
        <a href="?lang=<?php echo $langId; ?>" class="hover:underline flex items-center space-x-1">
          <?php if ($isCurrent) { ?>
            <i class="fa fa-check"></i>
          <?php } ?>
          <span><?php echo $details['language']; ?></span>
        </a>
      </li>
    <?php } ?>
  </ul>
</form>
