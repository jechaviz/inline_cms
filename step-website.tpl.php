<h2 class="text-3xl font-bold mb-4"><?php echo $lang['websiteSettings']; ?></h2>

<form id="step-website" class="space-y-6">
  <!-- Website Title -->
  <div class="flex flex-col md:flex-row md:items-center">
    <label for="website_title" class="w-1/3 text-lg"><?php echo $lang['websiteTitle']; ?>:</label>
    <div class="w-2/3">
      <input type="text" name="website_title" id="website_title" 
             class="w-full p-2 rounded border border-gray-700 bg-gray-900 text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
    </div>
  </div>

  <!-- Website URL -->
  <div class="flex flex-col md:flex-row md:items-center">
    <label for="website_url" class="w-1/3 text-lg"><?php echo $lang['websiteUrl']; ?>:</label>
    <div class="w-2/3">
      <input type="text" name="website_url" id="website_url" value="<?php echo $websiteUrl; ?>"
             class="w-full p-2 rounded border border-gray-700 bg-gray-900 text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
      <p class="mt-1 text-sm text-gray-400"><?php echo $lang['websiteUrlNote']; ?></p>
    </div>
  </div>

  <!-- Languages -->
  <div class="flex flex-col md:flex-row md:items-start">
    <label class="w-1/3 text-lg"><?php echo $lang['languages']; ?>:</label>
    <div class="w-2/3 space-y-4">
      <div id="languages-list" class="space-y-2">
        <?php foreach ($langs as $langId => $langData) { ?>
          <div class="language-item flex items-center space-x-4 p-2 bg-gray-800 rounded">
            <input type="text" name="lang_title[]" value="<?php echo $langData['title']; ?>" 
                   class="flex-grow p-2 rounded border border-gray-700 bg-gray-900 text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            <input type="hidden" name="lang_id[]" value="<?php echo $langId; ?>">
            <?php if ($langId != DEFAULT_LANG) { ?>
              <button type="button" class="delete-lang text-red-400 hover:text-red-300">
                <i class="fa fa-times"></i>
              </button>
            <?php } ?>
          </div>
        <?php } ?>
      </div>

      <button type="button" id="add-language" 
              class="flex items-center space-x-2 text-blue-400 hover:text-blue-300">
        <i class="fa fa-plus"></i>
        <span><?php echo $lang['addLanguage']; ?></span>
      </button>
    </div>
  </div>

  <!-- Template Language Item (hidden) -->
  <div id="language-template" class="hidden">
    <div class="language-item flex items-center space-x-4 p-2 bg-gray-800 rounded">
      <input type="text" name="lang_title[]" value="" 
             class="flex-grow p-2 rounded border border-gray-700 bg-gray-900 text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
      <input type="hidden" name="lang_id[]" value="">
      <button type="button" class="delete-lang text-red-400 hover:text-red-300">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>
</form>

<script>
  $(document).ready(function(){
    $('#add-language').click(function(e){
      e.preventDefault();
      var template = $('#language-template .language-item').clone();
      var langId = 'lang' + Math.floor(Math.random() * 1000000);
      $('input[name="lang_id[]"]', template).val(langId);
      $('#languages-list').append(template);
    });

    $('#languages-list').on('click', '.delete-lang', function(e){
      e.preventDefault();
      $(this).closest('.language-item').remove();
    });
  });
</script>