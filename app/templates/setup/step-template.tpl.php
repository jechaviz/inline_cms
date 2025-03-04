<h2 class="text-3xl font-bold mb-4"><?php echo $lang['templateLayouts']; ?></h2>

<?php if (!$layouts) { ?>
  <div class="bg-gray-800 p-4 rounded mb-4">
    <p class="mb-2"><?php printf($lang['templateNone'], $folder); ?></p>
    <p class="mb-2"><?php echo $lang['templateNoneCopy']; ?></p>
    <p>
      <a id="scan-template-again" href="#" class="text-blue-400 hover:underline"><?php echo $lang['templateScanAgain']; ?></a>
    </p>
  </div>
  <script>
    $(document).ready(function(){
      $('#scan-template-again').click(function(){
        setup.loadStep('template');
      });
    });
  </script>
  <?php return; ?>
<?php } ?>

<p class="mb-4"><?php echo $lang['templateLayoutsHint']; ?></p>

<form id="step-template">
  <table class="min-w-full bg-gray-900 text-gray-200">
    <thead>
      <tr class="border-b border-gray-700">
        <th colspan="2" class="py-2 text-lg"><?php echo $lang['templateLayoutFile']; ?></th>
        <th class="py-2 text-lg"><?php echo $lang['templateLayoutName']; ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($layouts as $file => $name) { ?>
        <tr class="layout-row checked border-b border-gray-700">
          <td class="check py-2 px-4">
            <input type="checkbox" value="<?php echo $file; ?>" checked class="mr-2">
            <i class="fa fa-check-square-o"></i>
          </td>
          <td class="file py-2 px-4"><?php echo $file; ?></td>
          <td class="name py-2 px-4">
            <input type="text" value="<?php echo $name; ?>" class="p-1 rounded border border-gray-300 bg-gray-800 text-gray-200 w-full">
          </td>
        </tr>
      <?php } ?>
      <tr class="layout-index">
        <td colspan="2" class="py-2 px-4">
          <label for="index_layout" class="text-lg"><?php echo $lang['templateLayoutFront']; ?>:</label>
        </td>
        <td class="py-2 px-4">
          <?php 
              $index = false;
              $possible = array('index', 'main', 'frontpage', 'front');
              foreach($possible as $variant){
                  if (isset($layouts[$variant.'.html'])){
                      $index = $variant.'.html';
                      break;
                  }
                  if (isset($layouts[$variant.'.htm'])){
                      $index = $variant.'.htm';
                      break;
                  }
              }
          ?>
          <select name="index_layout" id="index_layout" class="p-2 rounded border border-gray-300 bg-gray-800 text-gray-200 w-full">
            <?php foreach ($layouts as $file => $name) { ?>
              <option value="<?php echo $file; ?>"<?php if ($index==$file) { ?> selected="selected"<?php } ?>>
                <?php echo $file; ?>
              </option>
            <?php } ?>
          </select>
        </td>
      </tr>
    </tbody>
  </table>
  <input type="hidden" id="layoutFiles" name="layout_files" value="<?php echo implode("\n", array_keys($layouts)); ?>">
  <input type="hidden" id="layoutNames" name="layout_names" value="<?php echo implode("\n", $layouts); ?>">
</form>

<script>
  $(document).ready(function(){
    $('#step-template .layout-row .file, #step-template .layout-row .check').click(function(){
      var row = $(this).closest('tr');
      rowClick(row);
    });
    $('#step-template .layout-row input:text').change(function(){
      updateLayoutsLists();
    });
    function rowClick(row){
      if (row.hasClass('checked') && $('#step-template .checked').length == 1){ return; }
      row.toggleClass('checked');
      $('input:checkbox', row).prop('checked', row.hasClass('checked'));
      $('input:text', row).prop('disabled', !row.hasClass('checked'));
      $('.check i', row).toggleClass('fa-check-square-o').toggleClass('fa-square-o');
      updateLayoutsLists();
    }
    function updateLayoutsLists(){
      var files = [];
      var names = [];
      var indexSelect = $('#step-template select#index_layout');            
      $('#step-template .layout-row').each(function(){
        var row = $(this);
        var file = $('input:checkbox', row).val();
        if (!row.hasClass('checked')) { 
          $('option[value="'+file+'"]', indexSelect).remove();
          return;
        }
        files.push(file);
        names.push($('input:text', row).val());
        if ($('option[value="'+file+'"]', indexSelect).length == 0){
          indexSelect.append('<option value="'+file+'">'+file+'</option>');
        }
      });
      $('#layoutFiles').val(files.join("\n"));
      $('#layoutNames').val(names.join("\n"));
    }
  });
</script>
