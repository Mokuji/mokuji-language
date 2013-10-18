<?php namespace components\language; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected
    $permissions = array(
      'get_languages' => 0
    );

  public function create_language_tabs($options = null)
  {
    
    $options = Data($options);
    
    $ret = '<ul class="language-tabs clearfix">';
    
    $languages = $this->helper('get_languages', $options);
    
    if($languages->size() > 1){
      $languages->each(function($row)use($options, &$ret){
        
        $ret .=
          '<li id="tabber-'.$row->id.'"><a href="#tab-'.$row->id.'">'.
          ($row->image_id->is_set() ? '<img class="label-language-flag" src="'.url('section=media/image&resize=0/16&id='.$row->image_id).'" />' : '').
          ($options->display_as->check('empty') ? $row->{$options->display_as} : $row->title).
          '</a></li>';
        
      });
    }
    
    $ret .= '</ul>';
    
    return $ret;
    
  }
  
  public function get_languages($options = null)
  {
    $options =
      Data($options);
    
    return
      $this
      ->table('Languages')
      ->join('LanguageInfo', $info)
      ->select("$info.title", 'title')
      ->is($options->in_language_id->is('set')->and_not('empty'), function($q)use($options, $info){
        $q->where("$info.in_language_id", $options->in_language_id);
      })
      ->order('sort', 'ASC')
      ->execute();
    
  }
  
}
