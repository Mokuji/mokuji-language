<?php namespace components\language; if(!defined('MK')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected
    $permissions = array(
      'get_languages' => 0
    );

  protected function get_languages($options, $sub_routes)
  {
    return mk('Sql')->table('language', 'Languages')->execute();
  }

}
