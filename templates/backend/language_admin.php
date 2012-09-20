<?php namespace components\language; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<h1><?php echo __('Languages'); ?></h1>

<div class="tabs" id="tabs-languages">

  <ul>
    <li id="tabber-languages" class="active"><a href="#tab-languages"><?php __('Languages'); ?></a></li>
    <li id="tabber-language"><a href="#tab-language"><?php __('New language'); ?></a></li>
  </ul>

  <div id="tab-languages" class="tab-content">
    <?php echo $data->languages_list; ?>
  </div>

  <div id="tab-language" class="tab-content">
    <?php echo $data->language_edit; ?>
  </div>

</div>

<script type="text/javascript">

$(function(){

  $('#tabs-languages')

    /* ---------- Create language tabs ---------- */
    .find('ul').idTabs(function(id){

      if(id != "#tab-language" || $("#tab-language").find("input[name=id]").val() == ""){
        $("#tabber-language").find("a").text("<?php __('New language'); ?>");
        $("#tab-language").find(':input:not([type=submit], [type=checkbox], [type=radio])').val('');
      }

      return true;

    }).end()

    /* ---------- Edit language form submit handler  ---------- */
    .on('submit', '.edit-language-form', function(e){

      e.preventDefault();

      $(this).ajaxSubmit(function(d){
        $('#tab-languages').html(d);
        $('#tabber-languages a').trigger('click');
      });

    })

    /* ---------- Edit/add language ---------- */
    .on('click', '.edit', function(e){

      e.preventDefault();

      $('#tabber-language')
        .show()
        .find('a')
          .trigger('click')
          .text("<?php __('Edit language'); ?>");

      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#tab-language").html(data);
      });

    })

    /* ---------- Delete language ---------- */
    .on('click', '.delete', function(e){

      e.preventDefault();

      if(confirm("<?php __('Are you sure?'); ?>")){

        $(this).closest('tr').fadeOut();

        $.ajax({
          url: $(this).attr('href')
        });
      }

    });
  
});

</script>
