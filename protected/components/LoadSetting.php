<?php
/**
 * GetRequest represents the data form modles.
 * 
 */
class LoadSetting extends CComponent
{	 
      public function getMaxUploadFileSize()
      {
        $maxUploadFileSize = ''; 
        $maxUploadFileSize = self::getSettingValue(Globals::SETTING_KEY_MAX_UPLOAD_FILE_SIZE);
        $fileSizeInBites = $maxUploadFileSize * 1024 * 1024;
        
         return $fileSizeInBites;
      }
      public function getSpaceQuotaAllowed()
      {
        $maxUploadFileSize = ''; 
        $maxUploadFileSize = self::getSettingValue(Globals::SETTING_KEY_SPACE_QUOTA_ALLOWED);
        $fileSizeInBites = $maxUploadFileSize * 1024 * 1024;
        
         return $fileSizeInBites;
      }
      public function getSettingValue( $settingKey )
      {
        $settingValue = '';
        try
        {
              $setting = Setting::model()->find(Globals::FLD_NAME_SETTING_KEY.'=?',array($settingKey));
              $settingValue = $setting->{Globals::FLD_NAME_SETTING_VALUE};
        }
        catch(Exception $e)
        {             
            $msg = $e->getMessage();
            CommonUtility::catchErrorMsg( $msg  );
        }
         return $settingValue;
      }
        public function serviceFees($user_id = '')
        {
            $user_id = empty($user_id) ? Yii::app()->user->id : $user_id;
            $fees = 0;
              $user = User::model()->findByPk($user_id);
              if($user)
              {
                   if($user->{Globals::FLD_NAME_IS_PREMIUMDOER_LICENSE})
                   {
                       $fees = LoadSetting::getSettingValue( Globals::SETTING_KEY_PREMIUM_MEMBER_SERVICE_FEE );
                   }
                   else
                   {
                        $fees = LoadSetting::getSettingValue( Globals::SETTING_KEY_BASIC_MEMBER_SERVICE_FEE );
                   }
              }
              return $fees;
        }
    
}