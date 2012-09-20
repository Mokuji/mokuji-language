<?php namespace components\language; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected function language_edit()
  {

    return array(
      'language' => $this
        ->table('Languages')
        ->join('LanguageInfo', $info)
        ->select("$info.in_language_id", 'in_language_id')
        ->select("$info.title", 'title')
        ->pk(tx('Data')->get->language_id)
        ->execute_single(),
      
      'image_uploader' => tx('Component')->modules('media')->get_html('image_uploader', array(
        'insert_html' => array(
          'header' => '',
          'drop' => 'Sleep de afbeelding.',
          'upload' => 'Uploaden',
          'browse' => 'Bladeren'
        ),
        'auto_upload' => true,
        'callbacks' => array(
          'ServerFileIdReport' => 'plupload_image_file_id'
        )))

    );
    
  }
  
  protected function languages_list()
  {

    return $this
      ->table('Languages')
      ->join('LanguageInfo', $info)
      ->select("$info.title", 'title')
      ->where("$info.in_language_id", LANGUAGE)
      ->order("$info.title", 'ASC')
      ->execute();
    
  }
  
}
