<?php namespace components\language; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{

  protected function language_admin()
  {
    
    return array(
      'languages_list' => $this->section('languages_list'),
      'language_edit' => $this->section('language_edit')
    );
    
  }
  
}
