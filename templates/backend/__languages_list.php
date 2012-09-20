<?php namespace components\languages; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

echo $data->as_table(array(
  __('Title', 1) => 'title',
  __('Actions', 1) => array(
    function($row){return '<a class="edit" href="'.url('section=language/language_edit&language_id='.$row->id).'">'.__('edit', 1).'</a>';},
    function($row){return '<a class="delete" href="'.url('action=language/delete_language&language_id='.$row->id).'">delete</a>';}
  )
));
