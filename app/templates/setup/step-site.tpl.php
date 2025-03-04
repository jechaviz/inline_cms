<h2 class="text-3xl font-bold mb-4"><?php echo $lang['siteSettings']; ?></h2>

<form action="" class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center">
    <label for="site_name" class="w-1/3 text-lg"><?php echo $lang['siteName']; ?>:</label>
    <div class="w-2/3">
      <input type="text" name="site_name" id="site_name" value="" class="p-2 rounded border border-gray-300 bg-gray-900 text-gray-200 w-full">
    </div>
  </div>
  <div class="flex flex-col md:flex-row md:items-start">
    <label for="site_desc" class="w-1/3 text-lg"><?php echo $lang['siteDescription']; ?>:</label>
    <div class="w-2/3">
      <textarea name="site_desc" id="site_desc" class="p-2 rounded border border-gray-300 bg-gray-900 text-gray-200 w-full h-24"></textarea>
    </div>
  </div>
  <div class="flex flex-col md:flex-row md:items-start">
    <label class="w-1/3 text-lg"><?php echo $lang['siteLangs']; ?>:</label>
    <div class="w-2/3">
      <div id="site-languages">
        <ul class="space-y-2">
          <li data-lang="<?php echo $currentLang; ?>" class="lang-<?php echo $currentLang; ?> flex items-center justify-between bg-gray-800 p-2 rounded">
            <span class="code font-bold"><?php echo $currentLang; ?></span>
            <span class="name"><?php echo $currentName; ?></span>
            <span class="actions">
              <a href="#remove" class="text-red-400 hover:underline"><i class="fa fa-times"></i></a>
            </span>
          </li>
        </ul>
        <a id="add-language" href="#add-language" class="text-blue-400 hover:underline mt-2 inline-block"><?php echo $lang['siteLangAdd']; ?></a>
        <div id="add-language-form" class="mt-2 hidden">
          <label class="flex items-center space-x-2">
            <span><?php echo $lang['siteLangHint']; ?>:</span>
            <input type="text" id="language-code" maxlength="2" class="p-1 rounded border border-gray-300 bg-gray-900 text-gray-200 w-16">
            <span class="actions flex space-x-2">
              <a href="#save" class="save text-green-400 hover:underline"><i class="fa fa-check"></i></a>
              <a href="#cancel" class="cancel text-red-400 hover:underline"><i class="fa fa-times"></i></a>
            </span>
          </label>
        </div>
      </div>
      <input type="hidden" id="site_langs" name="site_langs" value="<?php echo $currentLang; ?>">
    </div>
  </div>
</form>

<script>
  $(document).ready(function(){
    $('#add-language').click(function(e){
      e.preventDefault();
      $(this).hide();
      $('#add-language-form').show();
      $('#language-code').focus();
    });
    $('#add-language-form .actions .save').click(function(e){
      e.preventDefault();
      var code = $('#language-code').val();
      if (code.length < 2) { cancelLangAdding(); return; }
      if ($('#site-languages ul li.lang-' + code).length > 0){ cancelLangAdding(); return; }
      var li = $('#site-languages ul li').eq(0).clone();
      li.removeClass().addClass('lang-' + code + ' flex items-center justify-between bg-gray-800 p-2 rounded');
      li.data('lang', code);
      li.attr('data-lang', code);
      $('.code', li).html(code);
      $('.name', li).html('<i class="fa fa-spinner fa-spin"></i>');
      li.hide().appendTo('#site-languages ul').fadeIn();
      toggleLangActions();
      cancelLangAdding();
      setup.runModule('setup', 'loadLangName', {code: code}, function(result){
          $('#site-languages ul li.lang-' + code + ' .name').html(result.name);
      });
      buildLangsString();
    });
    $('#add-language-form input').keyup(function(e){
      if (e.which == 13){
        $('#add-language-form .actions .save').click();
      }
    });
    $('#add-language-form .actions .cancel').click(function(e){
      e.preventDefault();
      cancelLangAdding();
    });
    $('#site-languages ul').on('click', 'li .actions a', function(e){
      e.preventDefault();
      var li = $(this).closest('li');
      li.remove();
      buildLangsString();
      toggleLangActions();
    });
    function buildLangsString(){
      var langs = [];
      $('#site-languages ul li').each(function(){
          langs.push($(this).data('lang'));
      });
      $('#site_langs').val(langs.join(','));
    }
    function cancelLangAdding(){
      $('#add-language').show();
      $('#add-language-form').hide();
      $('#language-code').val('');
    }
    function toggleLangActions(){
      var count = $('#site-languages > ul li').length;
      $('#site-languages > ul li .actions').toggle(count > 1);
    }
  });
</script>
