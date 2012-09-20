<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

$uid = tx('Security')->random_string(20);

/*

Fun times.

$form_id =
  'language_form';

$form_columns =
  array(
    'id' => 'hidden',
    'lft' => 'hidden',
    'rgt' => 'hidden',
    'valuta_symbol' => array(
      'label' => 'Valuta symbol',
      'type'  => 'text',
      'field_attributes' => array(
        'class' => 'small'
      )
    )
  );

echo $data->language->as_form($form_id, $form_columns);
exit;

*/
?>

<form method="post" id="<?php echo $uid; ?>" action="<?php echo url('action=language/save_language/post'); ?>" class="form edit-language-form">

  <input type="hidden" name="id" value="<?php echo $data->language->id ?>" />

  <fieldset id="language-tabs">

    <div class="idTabs">
      
      <?php /*echo tx('Component')->helpers('language')->create_language_tabs(array('in_language_id'=>LANGUAGE));*/ ?>

      <div class="language-tab-content">
  
        <?php
        tx('Component')->helpers('language')->get_languages(array('in_language_id'=>LANGUAGE))
          ->each(function($lang)use($data){
          ?>
            <div id="tab-<?php echo $lang->id; ?>">
              <div class="ctrlHolder">
                <label for="l_title_<?php echo $lang->id; ?>"><?php __('Title'); ?> <?php __('IN_LANGUAGE_NAME'); ?> <?php echo $lang->title; ?></label>
                <?php if($lang->image_id->is('set')) echo '<img class="label-language-flag" src="'.url('section=media/image&resize=0/16&id='.$lang->image_id).'" />'; ?> <input class="big large" type="text" id="l_title_<?php echo $lang->id; ?>" name="info[<?php echo $lang->id; ?>][title]" value="<?php echo $data->language->info[$lang->id]->title; ?>" />
              </div>
            </div>
          <?php
        });
        ?>

      </div>

    </div><!-- /.idTabs -->

  </fieldset>

  <div class="ctrlHolder">
    <label for="l_valuta_symbol" accesskey="v"><?php __('Valuta symbol'); ?></label>
    <input class="small" type="text" id="l_valuta_symbol" name="valuta_symbol" value="<?php echo $data->language->valuta_symbol; ?>" />
  </div>

  <div class="ctrlHolder">
    <label for="l_decimal_mark" accesskey="v"><?php __('Decimal mark'); ?></label>
    <input class="small" type="text" id="l_decimal_mark" name="decimal_mark" value="<?php echo $data->language->decimal_mark; ?>" />
  </div>

  <div class="ctrlHolder">
    <label for="l_thousands_sep" accesskey="v"><?php __('Thousands seperator'); ?></label>
    <input class="small" type="text" id="l_thousands_sep" name="thousands_sep" value="<?php echo $data->language->thousands_sep; ?>" />
  </div>

  <div class="ctrlHolder">
    <label for="l_code" accesskey="v"><?php __('Language code'); ?></label>
    <input class="small" type="text" id="l_code" name="code" value="<?php echo $data->language->code; ?>" />
  </div>

  <div class="ctrlHolder">
    <label for="l_shortcode" accesskey="s"><?php __('Short code'); ?></label>
    <input class="small" type="text" id="l_shortcode" name="shortcode" value="<?php echo $data->language->shortcode; ?>" />
  </div>

  <div class="ctrlHolder">
    <label for="l_image_preview"><?php __('Image'); ?></label>
    <img id="l_image_preview" src="<?php echo url(URL_BASE.'?section=media/image&id='.$data->language->image_id.'&resize=0/128'); ?>"  />
    <input type="hidden" id="image_id" name="image_id" value="<?php echo $data->language->image_id; ?>">
  </div>

  <div class="ctrlHolder">
    <?php echo $data->image_uploader; ?>
  </div>

  <?php echo form_buttons(); ?>

</form>

<script type="text/javascript">

$(function(){
  

  var form = $('#<?php echo $uid; ?>');

  //On uploaded file.
  window.plupload_image_file_id = function(up, ids, file_id){
    
    form.find('#l_image_preview')
      .attr('src', '<?php echo url(URL_BASE."?section=media/image&resize=0/128&id=", true); ?>'+file_id);
    
    form.find('#image_id')
      .val(file_id);
    
  };

});

</script>

<style>
.plupload-container .header,
.drag-here{
  display:none;
}
</style>