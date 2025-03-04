<h2 class="text-3xl font-bold mb-4"><?php echo $lang['serverCheck']; ?></h2>

<table class="min-w-full bg-gray-900 text-gray-200">
  <tbody>
    <?php foreach ($reqs as $row) { ?>
      <tr class="border-b border-gray-700">
        <td class="<?php echo (!empty($row['nested'])) ? 'pl-8' : 'pl-4'; ?> py-2 text-lg">
          <?php echo $row['title']; ?>
        </td>
        <td class="py-2 text-lg">
          <?php if ($row['isValid']) { ?>
            <span class="text-green-400">
              <i class="fa fa-check"></i> <?php echo $lang['checkYes']; ?>
            </span>
          <?php } else { ?>
            <span class="text-red-400">
              <i class="fa fa-times"></i> <?php echo $lang['checkNo']; ?>
            </span>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
    <?php if ($errors){ ?>
      <tr>
        <td colspan="2" class="py-2 text-center" style="text-align:center">
          <div class="bg-red-900/50 text-red-200 p-4 rounded mt-4">
            <h3 class="text-xl font-bold mb-2"><?php echo $lang['checkErrors']; ?>:</h3>
            <ul class="list-disc list-inside space-y-1">
              <?php foreach ($errors as $error) { ?>
                <li><?php echo $error; ?></li>
              <?php } ?>
            </ul>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<script>
    $(document).ready(function(){
        $('a.b-recheck').click(function(){
            setup.loadStep('check', true);
        });
    });
</script>
