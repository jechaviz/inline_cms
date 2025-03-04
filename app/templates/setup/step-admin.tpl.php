<h2 class="text-3xl font-bold mb-4"><?php echo $lang['adminCreate']; ?></h2>

<form id="step-admin" class="space-y-4">
  <!-- Administrator Email -->
  <div class="flex flex-col md:flex-row md:items-center">
    <label for="admin_email" class="w-1/3 text-lg"><?php echo $lang['adminEmail']; ?>:</label>
    <div class="w-2/3">
      <input type="text" name="admin_email" id="admin_email" class="p-2 rounded border border-gray-300 bg-gray-900 text-gray-200 w-full">
    </div>
  </div>

  <!-- Auto-generated Password Block -->
  <div class="auto flex flex-col md:flex-row md:items-center">
    <label for="admin_pass" class="w-1/3 text-lg"><?php echo $lang['adminPassword']; ?>:</label>
    <div class="w-2/3">
      <div class="auto-password">
        <!-- Added an ID for ClipboardJS target -->
        <span id="admin_pass_value" class="value block text-lg"><?php echo $password; ?></span>
        <span class="copied text-sm text-green-400 hidden"><?php echo $lang['adminPasswordCopied']; ?></span>
        <div class="links flex space-x-4 mt-2">
          <span class="link pass-copy flex items-center space-x-1">
            <i class="fa fa-copy"></i>
            <a href="#" data-clipboard-target="#admin_pass_value" class="hover:underline"><?php echo $lang['adminPasswordCopy']; ?></a>
          </span>
          <span class="link pass-regen flex items-center space-x-1">
            <i class="fa fa-refresh"></i>
            <a href="#" class="pass-regen-link hover:underline"><?php echo $lang['adminPasswordRegen']; ?></a>
          </span>
          <span class="link pass-edit flex items-center space-x-1">
            <i class="fa fa-pencil"></i>
            <a href="#" class="pass-edit-link hover:underline"><?php echo $lang['adminPasswordManual']; ?></a>
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Manual Password Input (initially hidden) -->
  <div class="manual hidden flex flex-col md:flex-row md:items-center">
    <label for="admin_pass" class="w-1/3 text-lg"><?php echo $lang['adminPassword']; ?>:</label>
    <div class="w-2/3">
      <input type="password" name="admin_password" id="admin_pass" value="<?php echo $password; ?>" class="p-2 rounded border border-gray-300 bg-gray-900 text-gray-200 w-full">
    </div>
  </div>
  <div class="manual hidden flex flex-col md:flex-row md:items-center">
    <label for="admin_pass2" class="w-1/3 text-lg"><?php echo $lang['adminPasswordRepeat']; ?>:</label>
    <div class="w-2/3">
      <input type="password" name="admin_password2" id="admin_pass2" value="<?php echo $password; ?>" class="p-2 rounded border border-gray-300 bg-gray-900 text-gray-200 w-full">
    </div>
  </div>
  <div class="manual hidden">
    <a href="#" class="pass-auto text-blue-400 hover:underline"><?php echo $lang['adminPasswordAuto']; ?></a>
  </div>
</form>

<script>
  $(document).ready(function(){
      // Initialize ClipboardJS (loaded from CDN in wizard.tpl.php)
      var clipboard = new ClipboardJS('.pass-copy a', {
          text: function(trigger) {
              var hint = $('#step-admin .copied');
              hint.fadeIn(100, function(){
                  setTimeout(function(){
                      hint.fadeOut();
                  }, 800);
              });
              return $('#admin_pass_value').text();
          }
      });

      $('.pass-edit-link').click(function(e){
          e.preventDefault();
          $('#admin_pass').val('');
          $('#admin_pass2').val('');
          $('.auto').hide();
          $('.manual').show();
          $('#admin_pass').focus();
      });
      
      $('.pass-auto').click(function(e){
          e.preventDefault();          
          $('.manual').hide();
          createAutoPassword();
          $('.auto').show();            
      });
      
      $('.pass-regen-link').click(function(e){
          e.preventDefault();          
          createAutoPassword();
      });
      
      function createAutoPassword(){
          var pass = generatePassword(10);
          var field = $('#admin_pass_value');
          field.fadeOut(100, function(){
              field.text(pass);
              $('#admin_pass').val(pass);
              $('#admin_pass2').val(pass);                
              field.fadeIn(100);
          });            
      }
      
      function generatePassword(length){        
          var chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789<>_^%&$#+@?';
          var result = '';
          for (var i = 0; i < length; i++) {
              var index = Math.floor(Math.random() * chars.length);
              result += chars.charAt(index);
          }
          return result;
      }
  });
</script>
