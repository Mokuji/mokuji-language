<?php namespace components\language\models; if(!defined('TX')) die('No direct access.');

class Languages extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'core_languages',
    
    $relations = array(
      'LanguageInfo' => array('id' => 'LanguageInfo.language_id')
    ),

    $hierarchy = array(
      'left' => 'lft',
      'right' => 'rgt'
    );

  public function get_info()
  {

    $ret = Data();

    $this->table('LanguageInfo')
    ->where('language_id', $this->id)
    ->execute()
    ->each(function($row)use(&$ret){
      $ret[$row->in_language_id] = $row;
    });

    return $ret;

  }

}