<?php namespace components\language; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{

  protected function language_select()
  {

    $ret = '<ul class="clearfix">';

    $this->helper('get_languages', array('in_language_id' => LANGUAGE))->each(function($row)use(&$ret){
      $ret .= '<li'.($row->id->get('int') == LANGUAGE ? ' class="active"' : '').'><a href="'.url('action=language/set_language&language_id='.$row->id).'" class="flag '.$row->shortcode.'">'.$row->shortcode.'</a></li>';
    });

    $ret .= '</ul>';

    return $ret;

  }
   
}
