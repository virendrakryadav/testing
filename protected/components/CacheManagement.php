<?php
class CacheManagement{
   public static function deleteCategoryCache(){
      $lang = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
      $cacheKeys = array(
            Globals::$cacheKeys['GET_CATEGORY_LIST'].'_'.$lang, 
            Globals::$cacheKeys['GET_IN_PERSON_CATEGORY_LIST'].'_'.$lang, 
            Globals::$cacheKeys['GET_INSTANT_CATEGORY_LIST'].'_'.$lang, 
            Globals::$cacheKeys['GET_VIRTUAL_CATEGORY_LIST_PARENT_ONLY'].'_'.$lang,
            //Globals::$cacheKeys['WIDGET_VIEW_CATEGORY_INPERSON'].'_'.$lang,
            //Globals::$cacheKeys['WIDGET_VIEW_CATEGORY_INSTANT'].'_'.$lang,
            //Globals::$cacheKeys['VIEW_CATEGORY_VIRTUALTASK'].'_'.$lang,

         );

      CommonUtility::clearCache($cacheKeys);
      //CommonUtility::clearCache(array(Globals::$cacheKeys['GET_CATEGORY_LIST_'].$lang, Globals::$cacheKeys['GET_IN_PERSON_CATEGORY_LIST_'].$lang, Globals::$cacheKeys['GET_INSTANT_CATEGORY_LIST_'].$lang, Globals::$cacheKeys['GET_VIRTUAL_CATEGORY_LIST_PARENT_ONLY_'].$lang));
   }
   
   public static function deleteSkillCache(){
      $lang = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
      $cacheKeys = array(
            Globals::$cacheKeys['MST_GETSKILLS'].'_'.$lang

         );

      CommonUtility::clearCache($cacheKeys);
      //CommonUtility::clearCache(Globals::$cacheKeys['MST_GETSKILLS'].'_'.Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));
   }
   
   public static function deleteCountryCache(){
      $lang = Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE);
      $cacheKeys = array(
            Globals::$cacheKeys['GET_COUNTRY_LIST'].'_'.$lang

         );

      CommonUtility::clearCache($cacheKeys);
      //CommonUtility::clearCache(Globals::$cacheKeys['GET_COUNTRY_LIST'].'_'.Yii::app()->user->getState(Globals::FLD_NAME_LANGUAGE));
   }
}