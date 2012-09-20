<?php namespace components\language; if(!defined('TX')) die('No direct access.');

class Actions extends \dependencies\BaseComponent
{
  
  protected function set_language($data)
  {

    tx('Setting the application language', function()use($data){

      tx('Sql')->table('language', 'Languages')->pk($data->language_id)->execute_single()->is('empty')
        ->success(function(){
          throw new \exception\EmptyResult('Could not retrieve the language you were trying to set as application language. This could be because the given ID was invalid.');
        })
        ->failure(function($language){
          tx('Data')->session->tx->language->set($language->id);
        });

      });

  }
  protected function save_language($data)
  {

    tx('Saving a language', function()use($data){

      $data->image_id = $data->image_id->otherwise(0);

      //Save language.
      tx('Sql')->table('language', 'Languages')->pk($data->id)->execute_single()->is('empty')
        ->success(function()use($data, &$language_id){
          tx('Sql')->model('language', 'Languages')->set($data->having('valuta_symbol', 'decimal_mark', 'thousands_sep', 'code', 'shortcode', 'image_id'))->save();
          $language_id = mysql_insert_id();
        })
        ->failure(function($language)use($data, &$language_id){
          $language->merge($data->having('valuta_symbol', 'decimal_mark', 'thousands_sep', 'code', 'shortcode', 'image_id'))->save();
          $language_id = $language->id->get('int');
        });

      //Delete existing language info.
      tx('Sql')->table('language', 'LanguageInfo')->where('language_id', $language_id)->execute()->each(function($row){
        $row->delete();
      });

      //Save language info.
      $data->info->each(function($info)use($data, $language_id){

        $in_language_id = $info->key();
        $info->each(function($val)use($info, $language_id, $in_language_id){
          tx('Sql')->model('language', 'LanguageInfo')->set($info->having('title'))->merge(array('language_id' => $language_id, 'in_language_id' => $in_language_id))->save();
        });

      });

    })->failure(function($info){
      throw $info->exception;
    });

    tx('Url')->redirect('section=language/languages_list&language_id=NULL');

  }

  protected function delete_language($data)
  {

    tx('Deleting language.', function()use($data){

      tx('Sql')->table('language', 'Languages')->pk($data->language_id)->execute_single()->not('set', function(){
        throw new \exception\EmptyResult('Could not retrieve the language you were trying to delete. This could be because the ID was invalid.');
      })
      ->delete();

      tx('Sql')->table('language', 'LanguageInfo')->where('language_id', $data->language_id)->execute()->each(function($row){
        $row->delete();
      });

    })

    ->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

    //It's useless to redirect, so exit here.
    exit;

  }


}
