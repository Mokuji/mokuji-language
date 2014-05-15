<?php namespace components\language; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{

  protected
    $permissions = array(
      'language_select' => 0
    );

  protected function language_select($options = null)
  {

    $title_column = $options->title_column->otherwise('title');

    $ret = '<ul class="language-select">';

    $this->helper('get_languages', array('in_language_id' => tx('Language')->get_language_id()))->each(function($row)use(&$ret, $title_column){
      $ret .= '<li'.($row->id->get('int') == tx('Language')->get_language_id() ? ' class="active"' : '').'><a href="'.url('action=language/set_language&language_id='.$row->id).'" class="flag '.$row->shortcode.'">'.$row->{$title_column}.'</a></li>';
    });

    $ret .= '</ul>';

    return $ret;

  }
   
}
