<?php

/**
 * It contains all global variable , those we use in application
 */
define('uploadPath', 'media/');
define('httpThreeslash', 'http:///');
define('indexIndex', 'index/index');
define('commonAjaxgetfieldlabel', '/common/ajaxgetfieldlabel');
define('commonFrontAjaxgetfieldlabel', 'commonfront/ajaxgetfieldlabel');
define('adminurl', '/admin/');
define('baseUrl', Yii::app()->getBaseUrl()); 
define('uploadPathForCategory', 'media/category/');
define('tempImages', 'media/temp/');
define('removePath', Yii::app()->basePath . '/../media/');
define('viewImagePath', Yii::app()->baseUrl . '/media/');
define('tempRemoveImages', Yii::app()->basePath . '/../media/temp/');
define('urlMediaByRoot', '..' . Yii::app()->baseUrl . '/media/');
define('tempViewPath', Yii::app()->baseUrl . '/media/temp/');


//define('DEFAULTAvatarImage', ".." . Yii::app()->baseUrl . '/images/pro_img.png');
define('DEFAULTAvatarImage', 'pro_img.png');
define('DEFAULTCategoryimage', Yii::app()->baseUrl . '/images/no_category_img.png');
define('imageNotFound', ".." . Yii::app()->baseUrl . '/images/unavailable.png');
define('imageRemove', Yii::app()->baseUrl . '/images/remove-btn.png');


define('categoryBaseImages', Yii::app()->basePath . '/../media/category/');
define('categoryImages', Yii::app()->baseUrl . '/media/category/');
define('urlMediaCategoryByRoot', '..' . Yii::app()->baseUrl . '/media/category/');
define('collapseImg', Yii::app()->baseUrl . '/images/portlet-collapse-icon.png');
define('expandImg', Yii::app()->baseUrl . '/images/portlet-expand-icon.png');
define('fileUploaderJs', Yii::app()->baseUrl . '/protected/extensions/EAjaxUpload/assets/fileuploader.js');
define('loadingImg', Yii::app()->baseUrl . '/images/taskloading.gif');
define('statusActiveImage', Yii::app()->baseUrl . '/images/available.gif');
define('statusInactiveImage', Yii::app()->baseUrl . '/images/unavailable.png');

define('statusSuspendImage', Yii::app()->baseUrl . '/images/suspend.png');

define('passwordChangeImage', Yii::app()->baseUrl . '/images/changepassword.png');
define('baseURL', Yii::app()->baseUrl);
define('publicImageDri',  Yii::app()->baseUrl. '/images/');
define('imageDri', Yii::app()->baseUrl. '/images/');
define('DocTypeImage', imageDri. 'doc_attachment.png');


define('ExcelTypeImage', imageDri. 'excle.png');
define('PDFTypeImage', imageDri. 'pdf.png');
define('VideoTypeImage', imageDri. 'video1.png');
define('ZipTypeImage', imageDri. 'zip.png');
define('PptTypeImage', imageDri. 'zip.png');

define('absoluteURL', Yii::app()->getBaseUrl(true));
define('viewImageProfile', absoluteURL . '/pic/');
define('viewThumbnailImage', absoluteURL . '/smallpic/');
define('viewUserVideo', absoluteURL . '/video/');
define('confirmtaskURL', absoluteURL . '/confirmation/');
define('categoryImageURL', absoluteURL . '/catg/');
define('taskImageURL', absoluteURL . '/task/');
define('taskTaskerProfile', absoluteURL . '/profile/t/');
define('publisTaskURL', absoluteURL . '/public/tasks/');
define('publisMyTaskURL', absoluteURL . '/poster/mytasks/');
define('publisMyTaskURLAsDoer', absoluteURL . '/tasker/mytasks/');
define('publicImageURL', absoluteURL . '/public/media/image/');

define('ImageTypeImage', imageDri. 'img_attachment.png');
define('imageDownload', Yii::app()->baseUrl . '/images/download-ic.png');
class Globals {

    const BASE_URL = baseURL;
    const BASE_URL_IMAGE_DIR = imageDri;
    const BASE_URL_PUBLIC_IMAGE_DIR = publicImageDri;
    const RAND_PASS_GEN_STRING = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$*"; // Used in Index/index, 
    const DEFAULT_CATEGORY_IMAGE = DEFAULTCategoryimage; // Used in index/UpdateImage
    const FRONT_USER_IMAGE_VIDEO_UPLOAD_FLD_PATH = uploadPath; // Used in index/UpdateImage
    const CATEGORY_IMAGE_UPLOAD_PATH = uploadPathForCategory; // Used in admin/category/create
    const DEFAULT_INBOX_IMAGE = DEFAULTCategoryimage; // Used in inbox/UpdateImage
    const INBOX_IMAGE_UPLOAD_PATH = uploadPathForCategory; // Used in inbox/index
    const BASH_URL = baseUrl;
    const ADMIN_URL = adminurl;
    const INDEXiNDEX = indexIndex;
    const FRONT_USER_IMAGE_VIDEO_REMOVE_FLD_PATH = removePath; // Used in index/UpdateImage
    const FRONT_USER_MEDIA_BASE_PATH = removePath; // Used in index/UpdateImage       
    const FRONT_USER_VIEW_IMAGE_PATH = viewImagePath; // Used in index/UpdateImage
    const FRONT_USER_VIEW_TEMP_PATH = tempViewPath; // Used in index/UpdateImage
    const COMMON_AJAX_GET_FIELD_LABEL = commonAjaxgetfieldlabel; // Used in index/UpdateImage
    const COMMON_FRONT_AJAX_GET_FIELD_LABEL = commonFrontAjaxgetfieldlabel; // Used in index/UpdateImage
    const FRONT_USER_PORTFOLIO_TEMP_PATH = tempImages; // Used in user/UploadPortfolioImage
    const FRONT_USER_PORTFOLIO_BASE_TEMP_PATH = tempRemoveImages; // Used in user/UserAddPortfolio
    const FRONT_USER_TASK_IMAGE_NAME_SLUG = "_task_uploaded"; // Used in user/UploadPortfolioImage
    const FRONT_USER_USER_IMAGE_NAME_SLUG = "_uploaded"; // Used in index/UpdateImage
    const FRONT_USER_MEDIA_BASE_PATH_BY_ROOTDIR = urlMediaByRoot; // Used in index/UpdateImage
    const FRONT_USER_PIC_MEDIA_URL = viewImageProfile; // Used in commonUtility/getprofilePicMediaURI
    const FRONT_USER_SMALLPIC_MEDIA_URL = viewThumbnailImage;// Used in commonUtility/getThumbnailMediaURI
    const FRONT_USER_VIDEO_MEDIA_URL = viewUserVideo;// Used in commonUtility/getVideoMediaURI
    const FRONT_USER_CONFIRM_TASK_URL = confirmtaskURL;// Used in commonUtility/getVideoMediaURI
    const CATEGORY_IMAGE_URI = categoryImageURL;
    const TASK_IMAGE_URI = taskImageURL;
    const FRONT_TASKER_PROFILE_URI = taskTaskerProfile;
    const FRONT_USER_TASK_URI = publisTaskURL;
    const FRONT_MY_USER_TASK_URI = publisMyTaskURL;
    const FRONT_MY_USER_TASK_URI_AS_DOER = publisMyTaskURLAsDoer;
    const PUBLIC_IMAGE_URI = publicImageURL;
    const CATEGORY_IMAGE_BASE_PATH = categoryBaseImages;
    const CATEGORY_IMAGE_VIEW_PATH = categoryImages;
    const FRONT_USER_MEDIA_CATEGORY_BASE_PATH_BY_ROOTDIR = urlMediaCategoryByRoot;
    const FRONT_USER_FILE_UPLOADER_JS_URL = fileUploaderJs;
    // Field Names
    const FLD_NAME_FILENAME = "filename"; // Used in index/updateprofile,UpdateImage,UpdateVideoUser
    const FLD_NAME_PIC = "pic"; // Used in index/updateprofile,UpdateImage,UpdateVideoUser
    const FLD_NAME_VIDEO = "video"; // Used in index/updateprofile,UpdateImage,UpdateVideoUser,PlayVideo
    const FLD_NAME_URL = "url"; // Used in index/updateprofile,UpdateImage,CommanFront/AjaxSetUrlSession and all admin section
    const FLD_NAME_WEBURL = "weburl"; // Used in index/updateprofile,UpdateImage
    const FLD_NAME_URL_ISPUBLIC = "url_ispublic"; // Used in index/updateprofile,UpdateImage
    const FLD_NAME_WEBURL_ISPUBLIC = "weburl_ispublic"; // Used in index/updateprofile,UpdateImage
    const FLD_NAME_VIDEO_ISPUBLIC = "video_ispublic"; // Used in index/updateprofile,UpdateImage
    const FLD_NAME_PIC_ISPUBLIC = "pic_ispublic"; // Used in index/updateprofile,UpdateImage
    const FLD_NAME_USER = "User"; // Used in all index and User Controller action
    const FLD_NAME_FIRSTNAME = "firstname"; // Used in index/updateprofile,verify,updateVideoUser
    const FLD_NAME_LASTNAME = "lastname"; // Used in index/UpdateProfile
    const FLD_NAME_PROFILE_INFO = "profile_info"; // Used in index/updateimage,updatevideouser,updateprofile , commonfront/UserPic,SmallPic,UserVideo
    const FLD_NAME_CONTACT_INFO = "contact_info"; // Used in index/Register
    const FLD_NAME_CREDIT_ACCOUNT_SETTING = "credit_account_setting"; // Used in usercontroller
    const FLD_NAME_SELECTION_TYPE = "selection_type"; // Used in taskercontroller
    const FLD_NAME_ENDING_TYPE = "ending_today"; // Used in taskercontroller
    const FLD_NAME_ENDING_TODAY = "ending_today"; // Used in taskercontroller
    const FLD_NAME_FEW_PROPOSALS = "few_proposals"; // Used in taskercontroller
    const FLD_NAME_TASKER_LOCATION_LONGITUDE = "tasker_location_longitude"; // Used in taskercontroller
    const FLD_NAME_TASKER_LOCATION_LATITUDE = "tasker_location_latitude"; // Used in taskercontroller
    const FLD_NAME_BILLADDR_STREET1 = "billaddr_street1"; // Used in index/AddressInfo
    const FLD_NAME_BILLADDR_STREET2 = "billaddr_street2"; // Used in index/AddressInfo
    const FLD_NAME_BILLADDR_COUNTRY_CODE = "billaddr_country_code"; // Used in index/AddressInfo,AboutUs
    const FLD_NAME_BILLADDR_REGION_ID = "billaddr_region_id"; // Used in index/AddressInfo,AboutUs
    const FLD_NAME_BILLADDR_REGION_ISPUBLIC = "billaddr_region_ispublic"; // Used in index/AddressInfo
    const FLD_NAME_BILLADDR_STATE_ID = "billaddr_state_id"; // Used in index/AddressInfo,AboutUs
    const FLD_NAME_BILLADDR_STATE_ISPUBLIC = "billaddr_state_ispublic"; // Used in index/AddressInfo
    const FLD_NAME_BILLADDR_CITY_ID = "billaddr_city_id"; // Used in index/AddressInfo,AboutUs
    const FLD_NAME_BILLADDR_CITY_ISPRIVATE = "billaddr_city_isprivate"; // Used in index/AddressInfo
    const FLD_NAME_BILLADDR_ZIPCODE = "billaddr_zipcode"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_ISSAME = "geoaddr_issame"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_STREET1 = "geoaddr_street1"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_STREET2 = "geoaddr_street2"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_COUNTRY_CODE = "geoaddr_country_code"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_REGION_ID = "geoaddr_region_id"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_REGION_ISPUBLIC = "geoaddr_region_ispublic"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_STATE_ID = "geoaddr_state_id"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_STATE_ISPUBLIC = "geoaddr_state_ispublic"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_CITY_ID = "geoaddr_city_id"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_CITY_ISPRIVATE = "geoaddr_city_isprivate"; // Used in index/AddressInfo
    const FLD_NAME_GEOADDR_ZIPCODE = "geoaddr_zipcode"; // Used in index/AddressInfo
    const FLD_NAME_ABOUTME = "aboutme"; // Used in index/AboutUs
    const FLD_NAME_ABOUT_ME = "about_me"; // Used in index/AboutUs , partial/_sboutus
    const FLD_NAME_TOTAL_CERTF_ID = "totalCertfId"; // Used in index/AboutUs
    const FLD_NAME_CERTIFICATE = "certificate"; // Used in index/AboutUs
    const FLD_NAME_CERTIFICATE_ID_ = "certificate_id_"; // Used in index/AboutUs
    const FLD_NAME_CERTIFICATE_VAL = "certificateVal"; // Used in index/AboutUs
    const FLD_NAME_CERTIFICATE_ID_OF = "certificateidof"; // Used in index/AboutUs
    const FLD_NAME_TOTAL_SKILLS_ID = "totalSkillsId"; // Used in index/AboutUs
    const FLD_NAME_SKILLS_ID = "skills_id_"; // Used in index/AboutUs
    const FLD_NAME_SKILLS = "_skills"; // Used in index/AboutUs
    const FLD_NAME_SKILLS_SMALL = "skills"; // Used in index/AboutUs
    const FLD_NAME_SKILL_ID = "skill_id"; // Used in Poster
    const FLD_NAME_SKILL_DESC = "skill_desc";
    const FLD_NAME_QUESTION_ID = "question_id"; // Used in Poster
    const FLD_NAME_TASK_QUESTION_ID = "task_question_id"; // Used in Poster
    const FLD_NAME_TASK_QUESTION_DESC = "task_question_desc"; // Used in Poster
    const FLD_NAME_UPLOADED_BY = 'uploadedby';
    const FLD_NAME_SPACE_QUOTA_USED = 'space_quota_used';
    const FLD_NAME_SPACE_QUOTA_USED_DOER = 'space_quota_used_doer';
     const FLD_NAME_SPACE_QUOTA_DOER = 'space_quota_doer';
    
    const FLD_NAME_PAYMENT_CUSTOMER_ID = 'payment_customer_id';
    const FLD_NAME_WORK_START_YEAR = "work_start_year"; // Used in index/AboutUs
    const FLD_NAME_PREFERECES_SETTING = "prefereces_setting"; // Used in index/Setting,DeleteSchedule,EditSchedule
    const FLD_NAME_TAGLINE = "tagline"; // Used in index/AboutUs , poster/posterprofile
    const FLD_NAME_SCHEDULE_ID = "schedule_id"; // Used in index/Setting,EditSchedule,DeleteSchedule
    const FLD_NAME_TIMEZONE = "timezone"; // Used in index/Setting
    const FLD_NAME_TIMEZONE_DISPLAY = "timezone_display";
    const FLD_NAME_STARTUP_PAGE = "startup_page"; // Used in index/Setting
    const FLD_NAME_NOTIFY_BY_SMS = "notify_by_sms"; // Used in index/Setting
    const FLD_NAME_NOTIFY_BY_EMAIL = "notify_by_email"; // Used in index/Setting
    const FLD_NAME_NOTIFY_BY_CHAT = "notify_by_chat"; // Used in index/Setting
    const FLD_NAME_NOTIFY_BY_FB = "notify_by_fb"; // Used in index/Setting
    const FLD_NAME_NOTIFY_BY_TW = "notify_by_tw"; // Used in index/Setting
    const FLD_NAME_NOTIFY_BY_GPLUS = "notify_by_gplus"; // Used in index/Setting
    const FLD_NAME_CONTACT_BY_CHAT = "contactbychat"; // Used in index/Setting
    const FLD_NAME_CONTACT_BY_EMAIL = "contactbyemail"; // Used in index/Setting
    const FLD_NAME_CONTACT_BY_PHONE = "contactbyphone"; // Used in index/Setting
    const FLD_NAME_SELECT_DAYS = "select_days"; // Used in index/Setting
    const FLD_NAME_DAYS = "day"; // Used in index/Setting
    const FLD_NAME_HRS = "hrs"; // Used in index/Setting
    const FLD_NAME_START_TIME = "start_time"; // Used in index/Setting
    const FLD_NAME_END_TIME = "end_time"; // Used in index/Setting
    const FLD_NAME_MON = "mon"; // Used in index/Setting
    const FLD_NAME_TUE = "tue"; // Used in index/Setting
    const FLD_NAME_WED = "wed"; // Used in index/Setting
    const FLD_NAME_THU = "thu"; // Used in index/Setting
    const FLD_NAME_FRI = "fri"; // Used in index/Setting
    const FLD_NAME_SAT = "sat"; // Used in index/Setting
    const FLD_NAME_SUN = "sun"; // Used in index/Setting
    const FLD_NAME_WORK_HRS = "work_hrs"; // Used in index/Setting
    const FLD_NAME_CONTACT_BY = "contact_by"; // Used in index/Setting
    const FLD_NAME_REF_CHECK_BY = "ref_check_by"; // Used in index/Setting
    const FLD_NAME_NUM = "num"; // Used in index/GetCertificatefield,GetSkillsfield,User/ContactInformation
    const FLD_NAME_NEW_PASSWORD = "newpassword"; // Used in index/ChangePassword,admin/admin/UserChangePassword
    const FLD_NAME_EMAIL = "email"; // Used in index/ChangePassword,ForgotPassword,user/ContactInformation , view/front/index/forgotpassword,register
    const FLD_NAME_PRIMARY_EMAIL = "primary_email";
    const FLD_NAME_PHONE = "phone";
    const FLD_NAME_PRIMARY_PHONE = "primary_phone";
    const FLD_NAME_REF_EMAIL = "ref_email"; // Used in index/ChangePassword,user/ContactInformation
    const FLD_NAME_COUNTRY_CODE = "country_code"; // Used in index/Register,admin/Country ALL Action
    const FLD_NAME_STATE_ID = "state_id"; // Used in index/Register
    const FLD_NAME_REGION_ID = "region_id"; // Used in index/Register,admin/city/AjaxGetCity
    const FLD_NAME_CITY_ID = "city_id"; // Used in index/Register
    const FLD_NAME_CITY_NAME = "city_name";
    const FLD_NAME_SPECIALITY_ID = "speciality_id";
    const FLD_NAME_IS_REQUIRED = "is_required";
     const FLD_NAME_IS_DELETE = "is_delete";
    const FLD_NAME_REQUIRED_RANK = "required_rank";
    const FLD_NAME_E = "e"; // Used in index/Register,User/ContactInformation
    const FLD_NAME_TYPE = "type"; // Used in index/Register,User/ContactInformation
    const FLD_NAME_EMAILS = "emails"; // Used in index/Register,user/ContactInformation
    const FLD_NAME_AJAX = "ajax"; // Used in all controller front and back
    const FLD_NAME_FRONT_LOGIN_FORM = "FrontLoginForm"; // Used in index/Login
    const FLD_NAME_PASSWORD = "password"; // Used in index/Login ,in admin site use in index all action,ChangePassword
    const FLD_NAME_REMEMBER_ME = "rememberMe"; // Used in index/Login ,in admin site use in index all action
    const FLD_NAME_IS_VERIFIED = "is_verified"; // Used in index/Login ,in admin site use in index all action
    const FLD_NAME_MESSAGE = "message"; // Used in index/Login
    const FLD_NAME_TOTAL_MOBILE_ID = "totalMobileId"; // Used in user/ContactInformation
    const FLD_NAME_TOTAL_EMAIL_ID = "totalEmailId"; // Used in user/ContactInformation
    const FLD_NAME_TOTAL_CHAT_ID = "totalChatId"; // Used in user/ContactInformation
    const FLD_NAME_TOTAL_SOCIAL_ID = "totalSocialId"; // Used in user/ContactInformation
    const FLD_NAME_MOBILE_ = "mobile_"; // Used in user/ContactInformation
    const FLD_NAME_MOBILE = "mobile"; // Used in user/ContactInformation
    const FLD_NAME_PHS = "phs"; // Used in user/ContactInformation
    const FLD_NAME_EMAIL_ = "email_"; // Used in user/ContactInformation
    const FLD_NAME_CHAT_ID_ = "chat_id_"; // Used in user/ContactInformation
    const FLD_NAME_CHAT_ID = "chat_id"; // Used in user/ContactInformation
    const FLD_NAME_CHAT_IDS = "chatids"; // Used in user/ContactInformation
    const FLD_NAME_CHAT_ID_OF = "chatidof"; // Used in user/ContactInformation
    const FLD_NAME_SOCIAL_ = "social_"; // Used in user/ContactInformation
    const FLD_NAME_SOCIAL = "social"; // Used in user/ContactInformation
    const FLD_NAME_SOCIAL_IDS = "socialids"; // Used in user/ContactInformation
    const FLD_NAME_SOCIAL_OF = "socialof"; // Used in user/ContactInformation
    const FLD_NAME_CARD_ID = "card_id"; // Used in user/ContactInformation
    const FLD_NAME_PAYPAL_ID = "paypal_id"; // Used in user/ContactInformation
    const FLD_NAME_ACCOUNT_PREFERENCE = "account_preference"; // Used in user/AccountPreference
    const FLD_NAME_CARD = "card"; // Used in user/AccountPreference
    const FLD_NAME_CARD_PREFERENCE = "card_preference";
    const FLD_NAME_REF_REMARKS = "ref_remarks";
    const FLD_NAME_CREATED_AT = "created_at";
    const FLD_NAME_UPDATED_AT = "updated_at";
    const FLD_NAME_VERIFIED_ON = "verified_on";
    const FLD_NAME_VERIFIED_BY = "verified_by";
    const FLD_NAME_PREFERENCE = "preference"; // Used in user/AccountPreference
    const FLD_NAME_PAYPAL = "paypal"; // Used in user/AccountPreference
    const FLD_NAME_CARD_ = "card_"; // Used in user/AccountPreference
    const FLD_NAME_PAYPAL_ = "paypal_"; // Used in user/AccountPreference
    const FLD_NAME_NAME = "name"; // Used in user/EditAccountUpdate
    const FLD_NAME_CARD_NAME = "card_name"; // Used in user/EditAccountUpdate
    const FLD_NAME_TOKEN = "token"; // Used in user/EditAccountUpdate
    const FLD_NAME_CVV = "cvv"; // Used in user/EditAccountUpdate
    const FLD_NAME_NUMBER = "number"; // Used in user/EditAccountUpdate
    const FLD_NAME_CARD_NUMBER = "card_number"; // Used in user/EditAccountUpdate
    const FLD_NAME_MONTH = "month"; // Used in user/EditAccountUpdate
    const FLD_NAME_CARD_EXPIRE_MONTH = "card_expire_month"; // Used in user/EditAccountUpdate
    const FLD_NAME_YEAR = "year"; // Used in user/EditAccountUpdate
    const FLD_NAME_CARD_EXPIRE_YEAR = "card_expire_year"; // Used in user/EditAccountUpdate
    const FLD_NAME_CARD_CVV = "card_cvv"; // Used in user/EditAccountUpdate
    const FLD_NAME_CARD_NUMBER_HIDDEN = "card_number_hidden"; // Used in user/EditAccountUpdate
    const FLD_NAME_CARD_PREFERENCE_HIDDEN = "card_preference_hidden"; // Used in user/EditAccountUpdate,EditPaypalAccountUpdate
    const FLD_NAME_PAYPAL_EMAIL = "paypal_email"; // Used in user/EditPaypalAccountUpdate
    const FLD_NAME_TASK = "Task"; // Used in user/AddPortfolio
    const FLD_NAME_TASKID = "taskId"; // Used in poster/SetConfirmTaskPage
    const FLD_NAME_TASKSTATUS = "taskStatus"; // Used in poster/SetConfirmTaskPage
    const FLD_NAME_TASK_ID = "task_id"; // Used in user/AddPortfolio
   
    const FLD_NAME_TASKER_USER_ID = "tasker_user_id";
    const FLD_NAME_IS_EXTERNAL = "is_external";
    const FLD_NAME_TASK_FINISHED_ON = "task_finished_on"; // Used in user/AddPortfolio
    const FLD_NAME_TASK_ASSIGNED_ON = "task_assigned_on"; 
    const FLD_NAME_TASK_START_DATE = "start_date"; // Used in user/AddPortfolio
    const FLD_NAME_TASK_END_DATE = "end_date"; // Used in user/AddPortfolio
    const FLD_NAME_TASK_BID_CLOSE_DATE = "bid_close_dt"; // Used in user/AddPortfolio
    const FLD_NAME_BID_START_DATE = "bid_start_dt"; // Used in user/AddPortfolio
    const FLD_NAME_PREFERRED_LOCATION = "preferred_location"; // Used in user/AddPortfolio
    
    const FLD_NAME_PREFERRED_LOCATION_CHECK = "preferred_location_check"; // Used in user/AddPortfolio
    const FLD_NAME_LOCATIONS = "locations"; // Used in user/AddPortfolio
    const FLD_NAME_LOCATION_TYPE = "location_type"; // Used in user/AddPortfolio
    const FLD_NAME_IS_LOGIN_ALLOWED = "is_login_allowed"; // Used in components/frontUserIdentity , index/Register
    const FLD_NAME_CONTACT_TYPE = "contact_type"; // Used in components/frontUserIdentity, index/Register
    const FLD_NAME_CONTACT_ID = "contact_id"; // Used in components/frontUserIdentity, index/Register
    const FLD_NAME_IS_PRIMARY = "is_primary"; // Used in index/Register
    const FLD_NAME_MEDIA_TYPE = "media_type";
    const FLD_NAME_SALT = "salt"; // Used in components/frontUserIdentity
    const FLD_NAME_SUPER_ADMINID = "superAdminId"; // Used in components/frontUserIdentity
    const FLD_NAME_PORTFOLIO_IMAGE = "portfolioimages"; // Used in user/AddPortfolio
    const FLD_NAME_FILE = "file"; // Used in user/AddPortfolio
    const FLD_NAME_UPLOAD_ON = "upload_on"; // Used in user/AddPortfolio
    const FLD_NAME_PORTFOLIO_VIDEO = "portfoliovideo"; // Used in user/AddPortfolio
    const FLD_NAME_DEFAULT_LANGUAGE = "DEFAULTLanguage"; // Used in user/AddPortfolio
    const FLD_NAME_TASK_REFERENCE = "TaskReference"; // Used in user/AddPortfolio
    const FLD_NAME_ID = "id"; // Used in user/ContactInformation,admin/category/Changestatus and all admin controller Changestatus Action
    const FLD_NAME_STATUS = "status"; // Used in user/AddPortfolio,admin/category/Changestatus and all admin controller Changestatus Action
    const FLD_NAME_PREFERRED_LANGUAGE_CODE = "preferred_language_code";
    const FLD_NAME_DATE_OF_BIRTH = "date_of_birth";
    const FLD_NAME_USER_TYPE = "user_type";
    const FLD_NAME_GENDER = "gender";
    const FLD_NAME_MARRITAL_STATUS = "marrital_status";
    const FLD_NAME_STATUS_IS_PUBLIC = "state_ispublic";
    const FLD_NAME_REGION_IS_PUBLIC = "region_ispublic";
    const FLD_NAME_CITY_IS_PUBLIC = "city_ispublic";
    const FLD_NAME_ZIPCODE = "zipcode";
    const FLD_NAME_PROFILE_IS_PUBLIC = "profile_ispublic";
    const FLD_NAME_TASK_LAST_POST_AT = "task_last_post_at";
    const FLD_NAME_TASK_POST_CNT = "task_post_cnt";
    const FLD_NAME_TASK_POST_TOTAL_PRICE = "task_post_total_price";
    const FLD_NAME_TASK_POST_TOTAL_HOURS = "task_post_total_hours";
    const FLD_NAME_TASK_POST_CANCEL_CNT = "task_post_cancel_cnt";
    const FLD_NAME_TASK_POST_CANCEL_PRICE = "task_post_cancel_price";
    const FLD_NAME_TASK_POST_CANCEL_HOURS = "task_post_cancel_hours";
    const FLD_NAME_TASK_POST_RANK = "task_post_rank";
    const FLD_NAME_RATING_AVG_AS_POSTER = "rating_avg_as_poster";
    const FLD_NAME_TASK_POST_REVIEW_CNT = "task_post_review_cnt";
    const FLD_NAME_TASK_LAST_DONE_AT = "task_last_done_at";
    const FLD_NAME_TASK_DONE_CNT = "task_done_cnt";
    const FLD_NAME_TASK_PENDING_CNT = "task_pending_cnt";
    const FLD_NAME_TASK_DONE_TOTAL_PRICE = "task_done_total_price";
    const FLD_NAME_TASK_DONE_AVG_PRICE = "task_done_avg_price";
    const FLD_NAME_TASK_DONE_TOTAL_HOURS = "task_done_total_hours";
    const FLD_NAME_TASK_DONE_REVIEW_CNT = "task_done_review_cnt";
    const FLD_NAME_CONNECTIONS_CNT = "connections_cnt";
    const FLD_NAME_REFERENCES_CNT = "references_cnt";
    const FLD_NAME_GROUP_CNT = "group_cnt";
    const FLD_NAME_FB_IS_CONNECTED = "fb_isconnected";
    const FLD_NAME_TW_IS_CONNECTED = "tw_isconnected";
    const FLD_NAME_GPLUS_IS_CONNECTED = "gplus_isconnected";
    const FLD_NAME_IN_IS_CONNECTED = "in_isconnected";
    const FLD_NAME_SOCIAL_SITES_AUTH_DT1 = "social_sites_auth_dtl";
    const FLD_NAME_LAST_UPDATED_AT = "last_updated_at";
    const FLD_NAME_LAST_ACCESSED_AT = "last_accessed_at";
    const FLD_NAME_RANK = "rank"; // Used in poster
    const FLD_NAME_REMARKS = "remarks"; // Used in poster
    const FLD_NAME_BID_DURATION = "bid_duration"; // Used in poster
    const FLD_NAME_PAY_WITH = "pay_with"; // Used in poster
    const FLD_NAME_PROJECT_SEARCH_DURATION = "duration"; // Used in poster
    
    const FLD_NAME_THIS_NAME = "thisname"; // Used in CommanFront/AjaxSetUrlSession,admin/Common/AjaxGetFieldLabel
    const FLD_NAME_CLASS_NAME = "classname"; // Used in CommanFront/Changestatus,Ajaxupdate,admin/Common/Changestatus
    const FLD_NAME_CLASS_NAME_N_CAP = "className"; // Used in CommanFront/Changestatus,Ajaxupdate,admin/Common/Changestatus
    const FLD_NAME_FIELD_NAME = "fieldName"; // Used in CommanFront/Changestatus,Ajaxupdate,admin/Common/Changestatus
    const FLD_NAME_ADMIN = "Admin"; // Used in CommanFront/Changestatus,Ajaxupdate,admin/admin all action,admin/common/Changestatus,Ajaxupdate
    const FLD_NAME_ADMIN_SML = "admin"; // Used in CommanFront/Changestatus,Ajaxupdate,admin/admin all action,admin/common/Changestatus,Ajaxupdate
    const FLD_NAME_ADMINUSER_SML = "adminuser"; // Used in CommanFront/Changestatus,Ajaxupdate,admin/common/Changestatus,Ajaxupdate
    const FLD_NAME_ADMIN_USER = "Admin user"; // Used in CommanFront/Changestatus,Ajaxupdate,admin/common/Changestatus,Ajaxupdate
    const FLD_NAME_ACT = "act"; // Used in CommanFront/Ajaxupdate,admin/category/Ajaxupdate, admin all controller all action Ajaxupdate
    const FLD_NAME_AUTO_ID = "autoId"; // Used in CommanFront/Ajaxupdate,admin/category/Ajaxupdate,admin all controller all action Ajaxupdate
    const FLD_NAME_DELETE = "delete"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const FLD_NAME_ROLE_ID = "role_id"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const FLD_NAME_USER_ROLE_ID = "user_roleid"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const FLD_NAME_USER_FRONT_ROLE_ID = "user_front_role_id"; // Used in roles
    const FLD_NAME_RELATION_NAME = "relationName"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const FLD_NAME_RELATION_NAME_SML_N = "relationname"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const FLD_NAME_DIMENSION = "dimension"; // Used in CommonfrontController/actionSmallPic
    const FLD_NAME_USERID = "userId"; // Used in CommonfrontController/actionSmallPic,actionUserPic,actionUserVideo
    const FLD_NAME_USER_ID = "user_id"; // Used in CommonfrontController/actionSmallPic,actionUserPic,actionUserVideo
    const FLD_NAME_CATGID = "catgId"; // Used in CommonfrontController/actionCatPic
    const FLD_NAME_PORTFOLIO_IMAGE_REMOVE = "portfolioimagestoremove";
    const FLD_NAME_PORTFOLIO_VIDEO_REMOVE = "portfoliovideoremove";
    const FLD_NAME_IS_PUBLIC = "is_public";
    const FLD_NAME_TABLE_NAME = "tablename"; //Used in posert
    const FLD_NAME_PRIMARY_KEY = "primarykey"; //Used in posert
    const FLD_NAME_PRIMARY_KEY_VALUE = "primaryvalue"; //Used in posert
    const FLD_NAME_USER_SMALL = "user"; //Used in posert
    const FLD_NAME_AUTO = "auto"; //Used in posert
    const FLD_NAME_REF_DONE_BY_NAME = "ref_done_by_name"; //Used in posert
    const FLD_NAME_REF_DONE_BY_PHONE = "ref_done_by_phone"; //Used in posert
    const FLD_NAME_REF_DONE_BY_EMAIL = "ref_done_by_email"; //Used in posert
    const FLD_NAME_HAS_FOREIGN = "hasforeign"; //Used in posert
    const FLD_NAME_CREATER_USER_ID = "creator_user_id"; //Used in posert
    const FLD_NAME_VALID_FROM_DT = "valid_from_dt"; //Used in postert
    const FLD_NAME_TASK_STATE = "state"; //Used in posert
    const FLD_NAME_CREATOR_ROLE = "creator_role"; //Used in postert
    const FLD_NAME_TASK_KIND = "task_kind"; //Used in posert
    const FLD_NAME_PROFILE_FOLDER_NAME = "profile_folder_name"; //Used in postert
    const FLD_NAME_TASK_ATTACHMENTS = "attachments"; //Used in postert
    const FLD_NAME_TASK_ATTACHMENT = "attachment"; //Used in postert
    const FLD_NAME_TASKER_RECEIPT_ATTACHMENT = "attachment"; //Used in poster
    const FLD_NAME_VERIFICATION_STATUS = "verification_status"; //Used in postert
    const FLD_NAME_REF_VERIFICATION_STATUS = "ref_verification_status"; //Used in postert
    const FLD_NAME_USER_CONTACT = "UserContact"; //Used in admin
    const FLD_NAME_USER_PHONE = "phone"; //Used in admin
    const FLD_NAME_PRICE_CURRENCY = "price_currency";
    const FLD_NAME_TASKTYPE = "taskType"; // userd in poster
    const FLD_NAME_TASKLOCATIONS = "taskLocations"; // userd in poster
    const FLD_NAME_CATEGORYNAME = "categoryName"; // userd in poster
    const FLD_NAME_TASK_SKILLS = "skills"; // userd in poster
    const FLD_NAME_INVITEDTASKERS = "invitedtaskers";
    const FLD_NAME_DISTANCE = "distance";
    
    const FLD_NAME_RATING = "rating"; // used in rating
    const FLD_NAME_USER_RATING_TRNO = "user_rating_trno"; // used in rating
    const FLD_NAME_RATING_UCFIRST = "Rating"; // used in admin/rating
    const FLD_NAME_RATING_ID = "rating_id"; // used in admin/rating id
    const FLD_NAME_RATING_PRIORITY = "rating_priority"; // used in admin/rating priority
    const FLD_NAME_RATING_LOCALE = "RatingLocale"; // Used in admin/rating ALL Action
    const FLD_NAME_RATING_DATA_SESSION = "ratingDataSession"; // Used in admin/rating ALL Action
    const FLD_NAME_RATING_FOR = "rating_for"; // Used in admin/rating for
    const FLD_NAME_RATING_DESC = "rating_desc"; // Used in admin/rating description
    const FLD_NAME_RATING_STATUS = "rating_status"; // Used in admin/rating status
    const FLD_NAME_POSTER_RATING_ALFABET = "p"; // Used in components/UtilityHtml
    const FLD_NAME_TASKER_RATING_ALFABET = "t"; // Used in components/UtilityHtml
    
    
    
    const FLD_NAME_RATING_AVG_AS_TASKER = "rating_avg_as_tasker"; // Used in poster
    
    const FLD_NAME_MAXPRICEVALUE = "maxPriceValue"; // userd in poster
    const FLD_NAME_MINPRICEVALUE = "minPriceValue"; // userd in poster
    
    
    
    const FLD_NAME_MINPRICE = "minprice"; // userd in poster
    const FLD_NAME_MAXPRICE = "maxprice"; // userd in poster
    const FLD_NAME_MAXDATE = "maxdate"; // userd in poster
    const FLD_NAME_MINDATE = "mindate"; // userd in poster
    const FLD_NAME_SORT = "sort"; // userd in poster
    const FLD_NAME_MOST_EXPERIENCED = "most_experienced"; // userd in poster
    const FLD_NAME_PROPOSAL_LOCATIONS = "proposalLocations"; // userd in poster
    const FLD_NAME_INVITED_CNT = "invited_cnt"; // userd in poster 
    const FLD_NAME_INVITED = "invited"; // userd in poster 
    const FLD_NAME_FOR_USER_ID = "for_user_id"; // userd in index
//    const FLD_NAME_BY_USER_ID = "by_user_id"; // userd in index
    const FLD_NAME_ALERT_TYPE = "alert_type"; // userd in index
    const FLD_NAME_ALERT_ID = "alert_id"; // userd in index
    const FLD_NAME_ALERT_DESC = "alert_desc"; // userd in index
    const FLD_NAME_IS_SEEN = "is_seen"; // userd in index
    const FLD_NAME_SEEN_AT = "seen_at"; // userd in index
    const FLD_NAME_VERIFICATION_CODE = "verification_code"; //Used in poster
    const FLD_NAME_BOOKMARK_TYPE = "bookmark_type"; //Used in poster
    const FLD_NAME_BOOKMARK_SUBTYPE = "bookmark_subtype"; //Used in poster
    const FLD_NAME_BOOKMARK_USER_ID = "bookmark_user_id"; //Used in poster
    const FLD_NAME_BOOKMARK_ID = "bookmark_id"; //Used in poster
    const FLD_NAME_MAX_PRICE = "maxPrice"; //Used in poster
    
    const FLD_NAME_MIN_PRICE = "minPrice"; //Used in poster
    const FLD_NAME_CURRENT_PAGE = "currentpage"; //Used in poster
    const FLD_NAME_INTEREST = "interest"; //Used in poster
    const FLD_NAME_TASKERNAME = "taskerName"; //Used in poster
    const FLD_NAME_TASKNAME = "taskName"; //Used in tasker
    const FLD_NAME_TASK_CANCEL_REASON = "task_cancel_reason"; //Used in poster
   const FLD_NAME_TASKER_COMMENTS = "tasker_comments"; //Used in poster
   
   const FLD_NAME_USER_NOTIFICATION = "notification"; //Used in poster
   const FLD_NAME_USER_NOTIFICATION_ID = "notification_id"; //Used in poster
   const FLD_NAME_USER_NOTIFICATION_LOCALE = "notificationlocale"; //Used in poster
   const FLD_NAME_USER_APPLICABLE_FOR = "applicable_for"; //Used in poster   
   const FLD_NAME_USER_SEND_EMAIL = "send_email"; //Used in poster
   const FLD_NAME_USER_SEND_SMS = "send_sms"; //Used in poster   
   
   const FLD_NAME_TASK_CREATED_BY_USER_ID = "created_by_user_id";
   
   const FLD_NAME_RECEIVE_BY = "receivedby";
   
   
   const FLD_NAME_IS_POSTER = "is_poster"; //Used in poster
  
   
   const FLD_NAME_DEFAULT_MIN_PRICE = "default_min_price"; //Used in poster
   const FLD_NAME_DEFAULT_MAX_PRICE = "default_max_price"; //Used in poster
   const FLD_NAME_DEFAULT_ESTIMATED_HOURS = "default_estimated_hours"; //Used in poster
    const FLD_NAME_HIRING_CLOSED = "hiring_closed"; //Used in poster
    const FLD_NAME_IS_INVITED = "is_invited"; //Used in poster
    const FLD_NAME_IS_POSTER_LICENSE = "is_poster_license"; //Used in poster
    const FLD_NAME_IS_PREMIUMDOER_LICENSE = "is_premiumdoer_license"; //Used in poster
    const FLD_NAME_IS_INSTANTDOER_LICENSE = "is_instantdoer_license"; //Used in poster
    const FLD_NAME_IS_INPERSONDOER_LICENSE = "is_inpersondoer_license"; //Used in poster
    const FLD_NAME_IS_VIRTUALDOER_LICENSE = "is_virtualdoer_license"; //Used in poster
    //
    //
//
    //
	// Admin Side Field Names
    const FLD_NAME_IS_ADMIN = "is_admin"; // Used in admin/admin/Update
    const FLD_NAME_IS_ACTIVE = "is_active"; // Used in admin/admin/Update
    const FLD_NAME_RETURN_URL = "returnUrl"; // Used in admin/ back end all controller acction
    const FLD_NAME_USER_DATA_SESSION = "userDataSession"; // Used in admin/admin/Admin
    const FLD_NAME_FILL_FIELDS = "fillFields"; // Used in admin/admin/Admin
    const FLD_NAME_P = "p";
    const FLD_NAME_Q = "q"; // Used in admin/admin/AutoCompletelogin_name,AutoCompleteEmail and all admin controller action  loadModel,AutoCompleteEmail
    const FLD_NAME_LIMIT = "limit"; // Used in admin/admin/AutoCompletelogin_name and all admin controller action  loadModel,AutoCompleteEmail
    const FLD_NAME_LOGIN_NAME = "login_name";
    const FLD_NAME_CATEGORY_LOCALE = "CategoryLocale"; // Used in admin/category/ all action
    const FLD_NAME_CATEGORY_LOCALE_SMALL = "categorylocale"; // Used in admin/category/ all action
    const FLD_NAME_CATEGORY_SMALL = "category"; // Used in admin/category/ all action
    const FLD_NAME_CATEGORY_PRIORITY = "category_priority"; // Used in admin/category all action
    const FLD_NAME_LANGUAGE = "language"; // Used in admin/ all Controller,
    const FLD_NAME_PK_NAME = "pkName"; // Used in admin/Common/Changestatus,Ajaxupdate
    const FLD_NAME_CATEGORY_DATA_SESSION = "categoryDataSession"; // Used in admin/category/Admin
    const FLD_NAME_CATEGORY = "Category"; // Used in admin/category/Admin
    const FLD_NAME_CATEGORY_ID = "category_id";
    const FLD_NAME_ACTIVITY_ID = "activity_id";
    const FLD_NAME_CATEGORY_NAME = "category_name";
    const FLD_NAME_CATEGORY_STATUS = "category_status";
    const FLD_NAME_QUESTION_DESC = "question_desc";
    const FLD_NAME_CATEGORY_PARENT_ID = "parent_id";
    const FLD_NAME_CITY_LOCALE = "CityLocale"; // Used in admin/city all action
    const FLD_NAME_CITY_PRIORITY = "city_priority"; // Used in admin/city all action
    const FLD_NAME_CITY = "city"; // Used in admin/city all action
    const FLD_NAME_CITY_CAP = "City"; // Used in admin/city all action
    const FLD_NAME_CATEGORY_QUESTION_CAP = "CategoryQuestionLocale"; // Used in admin/CategoryQuestion all action
    const FLD_NAME_CATEGORY_QUESTION = "CategoryQuestion"; // Used in admin/CategoryQuestion all action
    const FLD_NAME_CITY_DATA_SESSION = "cityDataSession"; // Used in admin/city all action
    const FLD_NAME_CATEGORY_QUESTION_DATA_SESSION = "categoryQuestionDataSession"; // Used in admin/CategoryQuestion all action
    const FLD_NAME_SKILL_DATA_SESSION = "skillDataSession"; // Used in admin/Skill all action
    const FLD_NAME_TASK_DATA_SESSION = "taskDataSession"; // Used in admin/Skill all action
    
    const FLD_NAME_SETTING = "Setting"; // Used in admin/Setting all action 
    const FLD_NAME_SETTING_DATA_SESSION = "settingDataSession"; // Used in admin/Setting all action
    const FLD_NAME_SETTING_ID = "setting_id"; // Used in admin/Setting all action 
    const FLD_NAME_SETTING_TYPE = "setting_type"; // Used in admin/Setting all action 
    const FLD_NAME_SETTING_KEY = "setting_key"; // Used in admin/Setting all action 
    const FLD_NAME_SETTING_VALUE = "setting_value"; // Used in admin/Setting all action
    const FLD_NAME_SETTING_LABEL = "setting_label"; // Used in admin/Setting all action 
    const FLD_NAME_POSTER_SETTING_ALFABET = "p"; // Used in components/UtilityHtml
    const FLD_NAME_TASKER_SETTING_ALFABET = "d"; // Used in components/UtilityHtml
    const FLD_NAME_ADMIN_SETTING_ALFABET = "a"; // Used in components/UtilityHtml
    const FLD_NAME_USER_SETTING_ALFABET = "u"; // Used in components/UtilityHtml
    
    const FLD_NAME_SKILL_LOCALE = "SkillLocale"; // Used in admin/Skill all action
    const FLD_NAME_SKILL = "Skill"; // Used in admin/Skill all action        
    const FLD_NAME_MODEL = "model"; // Used in admin/Common/AjaxGetFieldLabel,admin/Roles/AjaxGetFieldLabel
    const FLD_NAME_HAS_LOCALE = "hasLacale"; // Used in admin/Common/Ajaxupdate
    const FLD_NAME_COUNTRY = "Country"; // Used in admin/Country ALL Action
    const FLD_NAME_COUNTRY_SML = "country"; // Used in admin/Country ALL Action
    const FLD_NAME_COUNTRY_NAME = "country_name";
    const FLD_NAME_COUNTRY_LOCALE = "CountryLocale"; // Used in admin/Country ALL Action
    const FLD_NAME_COUNTRY_PRIORITY = "country_priority"; // Used in admin/Country ALL Action
    const FLD_NAME_COUNTRY_STATUS = "country_status";
    const FLD_NAME_COUNTRY_DATA_SESSION = "countryDataSession"; // Used in admin/Country ALL Action
    const FLD_NAME_LANGUAGE_CODE = "language_code"; // Used in admin/CountryLocale/loadModel
    const FLD_NAME_LOGIN_FORM = "LoginForm"; // Used in admin/index all action
    const FLD_NAME_USER_NAME = "username"; // Used in admin/index all action
    const FLD_NAME_LANGUAGE_PRIORITY = "language_priority"; // Used in admin/Language all action
    const FLD_NAME_LANGUAGE_CAP = "Language"; // Used in admin/Language all action,
    const FLD_NAME_LANGUAGE_DATE_SESSION = "languageDataSession"; // Used in admin/Language/Admin
    const FLD_NAME_LANGUAGE_NAME = "language_name"; // Used in admin/Language/AutoCompleteName
    const FLD_NAME_REGION_LOCALE = "RegionLocale"; // Used in admin/region all action
    const FLD_NAME_REGION_PRIORITY = "region_priority"; // Used in admin/region all action
    const FLD_NAME_REGION_STATUS = "region_status";
    const FLD_NAME_REGION_DATE_SESSION = "regionDataSession"; // Used in admin/region/Admin
    const FLD_NAME_REGION = "Region"; // Used in admin/region all action
    const FLD_NAME_REGION_NAME = "region_name"; // Used in admin/region all action
    const FLD_NAME_ROLES_MODELS = "rolesModels"; // Used in admin/Roles/Create,Update
    const FLD_NAME_ROLES = "Roles"; // Used in admin/Roles all action
    const FLD_NAME_ROLE_NAME = "role_name"; // Used in admin/Roles all action
    const FLD_NAME_ROLE_PERMISSION = "role_permission";
    const FLD_NAME_ROLE_PERMISSION_FRONT = "role_permission_front";
    const FLD_NAME_IS_FRONT_ROLE = "is_frontrole";
    const FLD_NAME_YT_0 = "yt0"; // Used in admin/Roles/Create,Update
    const FLD_NAME_ROLES_DATE_SESSION = "rolesDataSession"; // Used in admin/Roles/Create,Update
    const FLD_NAME_STATE_LOCALE = "StateLocale"; // Used in admin/State all action
    const FLD_NAME_STATE_PRIORITY = "state_priority"; // Used in admin/State all action
    const FLD_NAME_STATE_DATE_SESSION = "stateDataSession"; // Used in admin/State/Admin
    const FLD_NAME_STATE = "State"; // Used in admin/State/Admin
    const FLD_NAME_STATE_NAME = "state_name"; // Used in admin/State/Admin
    const FLD_NAME_STATE_STATUS = "state_status";
    const FLD_NAME_CITY_STATUS = "city_status";
    const FLD_NAME_SUB_CATEGORY = "Subcategory"; // Used in admin/Subcategory all action
    const FLD_NAME_SUB_CATEGORY_STATUS = "subcategory_status";
    const FLD_NAME_SUB_CATEGORY_CNT = "subcategory_cnt";
    const FLD_NAME_ACTIVE_WITHIN = "active_within";
    const FLD_NAME_COMPLETED_PROJECTS = "completed_projects";
    const FLD_NAME_AVERAGE_PRICE = "average_price";
    
    
    
    const FLD_NAME_SUB_CATEGORY_PRIORITY = "subcategory_priority"; // Used in admin/Subcategory all action
    const FLD_NAME_SUB_CATEGORY_LOCALE = "SubcategoryLocale"; // Used in admin/Subcategory all action
    const FLD_NAME_SUB_CATEGORY_ID = "subcategory_id"; // Used in admin/Subcategory all action
    const FLD_NAME_SUB_CATEGORY_NAME = "subcategory_name";
    const FLD_NAME_LANGUAGE_ID = "language_id"; // Used in admin/Subcategory all action
    const FLD_NAME_USER_DATE_SESSION = "userDataSession"; // Used in admin/user/Admin
    const FLD_NAME_CATEGORY_SKILL_CAP = "CategorySkillLocale"; // Used in admin/CategorySkill all action
    const FLD_NAME_CATEGORY_SKILL = "CategorySkill"; // Used in admin/CategorySkill all action
    const FLD_NAME_CATEGORY_SKILL_DATA_SESSION = "categorySkillDataSession"; // Used in admin/CategorySkill all action
    const FLD_NAME_LATITUDE = "latitude"; // Used in tasker
    const FLD_NAME_LONGITUDE = "longitude"; // Used in tasker
    const FLD_NAME_RANGE = "range"; // Used in tasker,poster
    const FLD_NAME_LOCATION_LATITUDE = "location_latitude"; // Used in tasker
    const FLD_NAME_LOCATION_LONGITUDE = "location_longitude"; // Used in tasker
    // const FLD_NAME_LOCATION_LATITUDE_ = "location_latitude"; // Used in tasker
    const FLD_NAME_TASKER_IN_RANGE = "tasker_in_range"; // Used in tasker
    const FLD_NAME_BLOGS = "Blogs"; // Used in poster
    const FLD_NAME_KEY = "key"; // Used in poster
    const FLD_NAME_PAYMENT_MODE = "payment_mode"; // Used in poster
    const FLD_NAME_TASKER_ID_SOURCE = "tasker_id_source"; // Used in poster
    const FLD_NAME_TASKER_ID = "tasker_id"; // Used in poster
    const FLD_NAME_TASKER_CREATED_AT = "created_at"; // Used in poster
    const FLD_NAME_CATEGORY_ID_VALUE = "category_id_value"; // Used in poster
    const FLD_NAME_PUBLIC = "publish"; // Used in poster
    const FLD_NAME_PRICE = "price"; // Used in poster
    const FLD_NAME_BONUS = "bonus"; // Used in poster
    const FLD_NAME_TASK_MIN_PRICE = "min_price"; // Used in poster
    const FLD_NAME_TASK_MAX_PRICE = "max_price"; // Used in poster
    const FLD_NAME_TASK_CASH_REQUIRED = "cash_required"; // Used in poster\
    const FLD_NAME_PROPOSED_DURATION = "proposed_duration"; // Used in poster
    const FLD_NAME_AGREE_FOR_EXPENSES = "agree_for_expenses"; // Used in poster
    const FLD_NAME_PROPOSED_COMPLETION_DATE = "proposed_completion_date"; // Used in poster
    
    
    const FLD_NAME_MULTISKILLS = "multiskills"; // Used in poster
    const FLD_NAME_MULTILOCATION = "multilocation";
    const FLD_NAME_TASK_LOCATION = "TaskLocation"; // Used in poster
    const FLD_NAME_USERS = "Users";
    const FLD_NAME_SELECTED_TASKTYPE = "selected_tasktype";
    const FLD_NAME_TASK_LOCATION_SML = "tasklocation"; // Used in poster
    const FLD_NAME_MULTI_CAT_QUESTION = "multicatquestion"; // Used in poster
    const FLD_NAME_IS_LOCATION_REGION = "is_location_region"; // Used in poster
    const FLD_NAME_MULTI_LOCATIONS = "multilocations"; // Used in poster
    const FLD_NAME_BID_START_TODAY = "bid_start_today"; // Used in poster
    const FLD_NAME_FORM = "form"; // Used in poster
    const FLD_NAME_FORM_TYPE = "formType"; // Used in poster
    const FLD_NAME_FORM_TYPE_SML = "formtype"; // Used in poster
    const FLD_NAME_LAT = "lat"; // Used in poster
    const FLD_NAME_LNG = "lng"; // Used in poster
    const FLD_NAME_ADDRESS = "address"; // Used in poster
    const FLD_NAME_TEMPLATEID = "templateId"; // Used in poster
    const FLD_NAME_DESCRIPTION = "description"; // Used in poster
    const FLD_NAME_LOCATION_GEO_AREA = "location_geo_area"; // Used in poster
    const FLD_NAME_TASK_CATEGORY_ID = "task_category_id"; // Used in poster
    const FLD_NAME_TASK_TEMPLATES = "task_templates"; // Used in poster
    const FLD_NAME_CATEGORY_IMAGE = "category_image"; // Used in poster
    const FLD_NAME_CATEGORY_DESC = "category_desc"; // Used in categorylocale
    const FLD_NAME_CREATE_TIMESTAMP = "create_timestamp"; // Used in categorylocale
    const FLD_NAME_UPDATE_TIMESTAMP = "update_timestamp"; // Used in categorylocale
    const FLD_NAME_CREATE_BY = "create_by"; // Used in categorylocale
    const FLD_NAME_UPDATED_BY = "updated_by"; // Used in categorylocale
    const FLD_NAME_CREATED_BY = "created_by";
    const FLD_NAME_TITLE = "title"; // Used in poster
    const FLD_NAME_FOR_SEARCH = "for_search"; // Used in poster
    const FLD_NAME_DESC = "desc"; // Used in poster
    const FLD_NAME_REPEAT_PASSWORD = "repeatpassword"; // Used in poster
    const FLD_NAME_MIN_LAT = "min_lat"; // Used in poster
    const FLD_NAME_MAX_LAT = "max_lat"; // Used in poster
    const FLD_NAME_MIN_LON = "min_lon"; // Used in poster
    const FLD_NAME_MAX_LON = "max_lon"; // Used in poster
    const FLD_NAME_PROPOSALID = "porposalId"; // Used in commoncontroller
    const FLD_NAME_COMMENTS = "comments";
    const FLD_NAME_ACTIVITY_SUBTYPE = "activity_subtype";
    const FLD_NAME_ACTIVITY_TYPE = "activity_type";
    const FLD_NAME_BY_USER_ID = "by_user_id";
    const FLD_NAME_SOURCE_APP = "source_app";
    const FLD_NAME_IS_PUBLISHED = "is_published";
    const FLD_NAME_SEEN_FROM_SOURCE_APP = "seen_from_source_app"; // index
    const FLD_NAME_TASKER_REVIEW_COMMENTS = "tasker_review_comments";
    const FLD_NAME_POSTER_REVIEW_COMMENTS = "poster_review_comments";
    const FLD_NAME_TASKER_REVIEW_DT = "tasker_review_dt";
    const FLD_NAME_POSTER_REVIEW_DT = "poster_review_dt";
    const FLD_NAME_TIMESTAMP = "timestamp"; // Used in categorylocale
    const FLD_NAME_PATH = "path"; // Used in categorylocale
    
    //field name for Blocked Ip
    const FLD_NAME_BLOCKED_IP_ID = "blocked_ip_id"; // Blocked IP Controller
    const FLD_NAME_BLOCKED_IP_ADDRESS = "ip_address"; // Blocked IP Controller
    const FLD_NAME_BLOCKED_IP = "Blockedip"; // Blocked IP Controller
    const FLD_NAME_BLOCKED_IP_START_DATE = "start_dt"; // Blocked IP Controller
    const FLD_NAME_BLOCKED_IP_END_DATE = "end_dt"; // Blocked IP Controller
    const FLD_NAME_BLOCKED_IP_REASON = "reason"; // Blocked IP Controller
    const FLD_NAME_BLOCKED_IP_STATUS = "status"; // Blocked IP Controller
    const DEFAULT_VAL_SEARCH = "search"; // Blocked IP Controller
    const BLOCKED_IP_SESSION_NAME = "blockedIpDataSession"; // Blocked IP Controller
    const BLOCKED_IP_FORM_NAME = "blocked-ip-form"; // Blocked IP Controller
        

    // Params Field Names
    const FLD_NAME_PATHSEPARATOR = "pathSeparator"; // Used in index/UpdateImage,UpdateVideoUser
    const FLD_NAME_ALLOWIMAGES = "allowImages"; // Used in index/UpdateImage
    const FLD_NAME_MAX_FILE_SIZE = "maxfileSize"; // Used in index/UpdateImage,UpdateVideoUser
    const FLD_NAME_MIX_FILE_SIZE = "minfileSize"; // Used in index/UpdateImage,UpdateVideoUser
    const FLD_NAME_MIN_FILE_SIZE = "minfileSize"; // Used in index/UpdateImage,UpdateVideoUser
    const FLD_NAME_FILESIZE = "filesize"; // Used in index/UpdateImage,UpdateVideoUser
    const FLD_NAME_ALLOW_VIDEOS = "allowVideos"; // Used in index/UpdateImage,UpdateVideoUser
    const FLD_NAME_ALLOW_DOCUMENTS = "allowDocuments"; // Used in poster/UploadTaskFiles
    const FLD_NAME_QUESTION_TYPE = "question_type"; // Used in poster/
    const FLD_NAME_QUESTION_FOR = "question_for"; // Used in poster/
    const FLD_NAME_TASKTITLE = "taskTitle"; // Used in poster/
    const FLD_NAME_PROPOSALS_CNT = "proposals_cnt"; // Used in poster/
    const FLD_NAME_TASK_DONE_RANK = "task_done_rank"; // Used in poster/
    const FLD_NAME_TASK_DONE_RANK_DETAIL = "task_done_rank_detail"; // Used in poster/
    const FLD_NAME_QUICK_FILTER = "quick_filter"; // Used in poster/
    const FLD_NAME_PROPOSALS_AVG_RATING = "proposals_avg_rating"; // Used in poster/
    const FLD_NAME_PROPOSALS_AVG_RATING_FOR_POSTER = "proposals_avg_rating_for_poster"; // Used in poster/
    const FLD_NAME_PROPOSALS_AVG_PRICE = "proposals_avg_price"; // Used in poster/
    const FLD_NAME_PROPOSALS_AVG_EXPERIENCE = "proposals_avg_experience"; // Used in poster/
    const FLD_NAME_PREVIOUSLY_WORKED = "previously_worked"; // Used in poster/
    const FLD_NAME_PROPOSALS_ACCPT_CNT = "proposals_accpt_cnt"; // Used in poster/
    const FLD_NAME_ACCOUNT_TYPE = "account_type"; // Used in tasker/
    const FLD_NAME_TO = "to"; // Used in tasker/
    const FLD_NAME_SUBJECT = "subject"; // Used in tasker/
    const FLD_NAME_BODY = "body"; // Used in tasker/
    const FLD_NAME_FROM_USER_ID = 'from_user_id'; //inbox
    const FLD_NAME_INBOX = 'Inbox'; //inbox
     const FLD_NAME_MSG_TYPE = 'msg_type'; //inbox
     const FLD_NAME_MSG_FLOW = 'msg_flow'; //inbox
     const FLD_NAME_MSG_ID = 'msg_id'; //inbox
     const FLD_NAME_IS_READ = 'is_read'; //inbox
      const FLD_NAME_TO_USER_IDS = 'to_user_ids'; //inbox
       const FLD_NAME_HIRED = 'hired'; //tasker
      const FLD_NAME_JOBS = 'jobs'; //tasker
     
    const FLD_NAME_VERIFICATIONCODE = "verificationcode"; // Used in tasker/
    const FLD_NAME_ONLYFORM = "onlyform"; // Used in tasker/
    const FLD_NAME_FILTER_TYPE = "filter_type"; // Used in tasker/
    const FLD_NAME_FILTER_ARRAY = "filterArray"; // Used in tasker/
    const FLD_NAME_CATID = "catId"; // Used in tasker/
    const FLD_NAME_SUBCATEGORYNAME = "subCategoryName"; // Used in tasker/
    const FLD_NAME_IS_HIGHLIGHTED = "is_highlighted"; // Used in tasker
    const FLD_NAME_IS_PREMIUM_TASK = "is_premium"; // Used in tasker
    
    const FLD_NAME_QUESTION = "question";
    const FLD_NAME_PROPOSALS = "proposals";
    const FLD_NAME_CURRENTUSER = "currentUser";
    
    const FLD_NAME_PROJECT_COMPLATE_RECEIPT_IDS = "receiptsIds";
    const FLD_NAME_PROJECT_COMPLATE_OVER_RT = "over_rt";
    const FLD_NAME_PROJECT_COMPLATE_RATING_1 = "ratings148";
    const FLD_NAME_PROJECT_COMPLATE_RATING_2 = "ratings151";
    const FLD_NAME_PROJECT_COMPLATE_MIN_RATING = "min_rating";
    const FLD_NAME_PROJECT_COMPLATE_MAX_RATING = "max_rating";
    const FLD_NAME_PROJECT_COMPLATE_TOTAL_PAYMENT = "total_payment";
    const FLD_NAME_PROJECT_COMPLATE_PROJECT_PRICE = "project_price";
    const FLD_NAME_PROJECT_COMPLATE_BONUS_VALUE = "bonusval";
    const FLD_NAME_TASKER_TOTAL_AMOUNT_RECEIVED = "total_amount_received";
    const FLD_NAME_TASKER_RATING_MIN_AS_TASKER = "rating_min_as_tasker";
    const FLD_NAME_TASKER_RATING_MAX_AS_TASKER = "rating_max_as_tasker";
    const FLD_NAME_TASKER_RATING_TOTAL_AS_TASKER = "rating_total_as_tasker";
    const FLD_NAME_TASKER_RATING_COUNT_AS_TASKER = "rating_cnt_as_tasker";
    
    const FLD_NAME_TASKER_RATING_MIN_AS_POSTER = "rating_min_as_poster";
    const FLD_NAME_TASKER_RATING_MAX_AS_POSTER = "rating_max_as_poster";
    const FLD_NAME_TASKER_RATING_TOTAL_AS_POSTER = "rating_total_as_poster";
    const FLD_NAME_TASKER_RATING_COUNT_AS_POSTER = "rating_cnt_as_poster";
    const FLD_NAME_TASKER_RATING_AVG_AS_POSTER = "rating_avg_as_poster";
    
    const FLD_NAME_TASKER_RECEIPT_STATUS = "status";
    const FLD_NAME_TASKER_RECEIPT_APPROVED_AMOUNT = "approved_amount";
    const FLD_NAME_TASKER_RECEIPT_APPROVED_ON = "approved_on";
    const FLD_NAME_PROJECT_COMPLATE_POSTER_ID = "poster_id";
    const FLD_NAME_PROJECT_COMPLATE_RECEIPT_COUNT = "receiptCount";
    const FLD_NAME_PROJECT_COMPLATE_IMAGE_NAME = "imageName";
    const FLD_NAME_PROJECT_COMPLATE_EXPENSE_COUNT = "expenseCount";
    const FLD_NAME_PROJECT_COMPLATE_EXPENSE_AMOUNT = "expense_amount";
    const FLD_NAME_PROJECT_COMPLATE_EXPENSE_LABEL = "expense_label";
    const FLD_NAME_AGREE_FOR_TERMS = 'agree_for_terms';
    
    ////// User Attrib
    const FLD_NAME_ATTRIB_TYPE = "attrib_type"; // Used in tasker/
    const FLD_NAME_ATTRIB_DESC = "attrib_desc"; // Used in tasker/
    const FLD_NAME_VAL_BIGINT = "val_bigint"; // Used in tasker/
    const FLD_NAME_VAL_INT = "val_int"; // Used in tasker/
    const FLD_NAME_VAL_REAL = "val_real"; // Used in tasker/
    const FLD_NAME_VAL_STR = "val_str"; // Used in tasker/
    const FLD_NAME_VAL_DT = "val_dt"; // Used in tasker/
    const FLD_NAME_USER_ATTRIB = "UserAttrib"; // Used in tasker/
    const FLD_NAME_FILE_ID = "file_id"; // Used in tasker/
    
    const DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK = "filter_task"; // Used in tasker/
    const DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASK_PROPOSALS = "filter_task_proposals"; // Used in tasker/
    const DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER = "filter_tasker"; // Used in tasker/
    const DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTER = "filter_poster"; // Used in tasker/
    const DEFAULT_VAL_ATTRIB_TYPE_FILTER_POSTED_MYTASKS = "filter_posted_mytasks"; // Used in tasker/
    const DEFAULT_VAL_ATTRIB_TYPE_FILTER_TASKER_MYTASKS = "filter_tasker_mytasks"; // Used in tasker/
    const DEFAULT_DISPLAY_TOTAL_NOTIFICATION_COUNT = "5"; // Used in tasker/
    
    const DEFAULT_VAL_RANDOM_STRING= "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Used in tasker/
    const DEFAULT_VAL_EMAIL= "email"; // Used in tasker/
    const DEFAULT_VAL_PRIMARY_EMAIL= "primaryemail"; // Used in tasker/
    const DEFAULT_VAL_PRIMARY_PHONE= "primaryphone"; // Used in tasker/
    const DEFAULT_VAL_CHANGE= "Change"; // Used in tasker/
    const DEFAULT_VAL_SAVE= "Save"; // Used in tasker/
    const FILTERS_TASK_LIMIT = '5';// Used in tasker/
    
    
    
    //
   //
	// Session Field Names
    const FLD_NAME_USER_IMAGE = "userimage"; // Used in index/UpdateImage
    const FLD_NAME_USER_FULLNAME = "fullname"; // Used in index/UpdateImage
    const FLD_NAME_SUPER = "super"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const FLD_NAME_PERMISSION = "permission"; // Used in CommanFront/Ajaxupdate,admin/category/admin
    const FLD_NAME_PAGE_URL = "pageUrl"; // Used in CommanFront/AjaxSetUrlSession,admin/category/admin,admin/city/admin
    // Cookie Field Names
    const FLD_NAME_FRONT_USER_NAME = "usernameFront"; // Used in index/Login
    const FLD_NAME_FRONT_USER_PASSWORD = "passwordFront"; // Used in index/Login
    const FLD_NAME_FRONT_USER_REMEMBER_ME = "rememberMeFront"; // Used in index/Login
    // Scenario Names
    const UPDATE_PROFILE = "updateprofile"; // Used in index/UpdateProfile
    const ABOUT_US = "aboutus"; // Used in index/AboutUs
    const SETTING = "setting"; // Used in index/Setting
    const CHANGE_PASSWORD = "changepassword"; // Used in index/Changepassword
    const REGISTER = "register"; // Used in index/Register
    const FORGOT_PASSWORD = "forgotpassword"; // Used in index/forgotpassword
    const CONTACT_INFORMATION = "contactinformation"; // Used in user/ContactInformation
    const ACCOUNT_DETAIL = "accountdetail"; // Used in user/EditAccount
    const PAYPAL_ACCOUNT_DETAIL = "paypalaccountdetail"; // Used in user/PaypalAccount
    const INSERT_NOTO = "insert"; // Used in user/AddPortfolio,admin/roles/Create
    const HAS_ROLE_INSERT = "hasRoleInsert"; // Used in admin/admin/Create        
    const INSTANT_TASK = "instantTask"; // Used in admin/admin/Create
    const INPERSON_TASK_ON_PRICE = "inpersonTaskOnPrice"; // Used in poster
    const INPERSON_TASK = "inpersonTask"; // Used in poster
    const CONFIRM_TASK = "confirmTask"; // Used in poster
    const VIRTUAL_TASK = "virtualTask"; // Used in poster
    const ADD_PORTFOLIO = "addportfolio"; // Used in poster 
    const HAS_ROLE_UPDATE = "hasRoleUpdate"; // Used in admin/admin/Update
    const UPDATE_ACCOUNT = "updateaccount"; // Used in admin/admin/UpdateAccount
    const USER_CHANGE_PASSWORD = "userchangepassword"; // Used in admin/admin/UserChangePassword,admin/user/UserChangePassword
    const SCENARIO_TASKER_SAVE_PROPOSAL = "sendProposal"; // Used in admin/admin/UserChangePassword,admin/user/UserChangePassword
    const SCENARIO_NOTIFICATION_SEENTRUE = "seentrue"; // Used in admin/admin/UserChangePassword,admin/user/UserChangePassword
  
    const SCENARIO_DATE_VALIDATION = "datevalidete"; // Used in admin/admin/UserChangePassword,admin/user/UserChangePassword
    const SCENARIO_DATE_VALIDATION_ON_UPDATE = "datevalideteonupdate"; // Used in admin/admin/UserChangePassword,admin/user/UserChangePassword
//
    //Defult value of field
    const DEFAULT_VAL_TASK_TITLE_LENGTH = "40"; // Used in tasker/
    const DEFAULT_VAL_MIN_PRICE = '0'; // Used in poster
    const DEFAULT_VAL_WORK_HRS = '5'; // Used in poster
    const DEFAULT_VAL_MIN_WORK_HRS = '1'; // Used in poster
    const DEFAULT_VAL_MAX_WORK_HRS = '168'; // Used in poster
    const DEFAULT_VAL_ALL = 'all'; // Used in index/Setting
    const DEFAULT_VAL_DAYS = 'days'; // Used in index/Setting
    const DEFAULT_VAL_MON = 'mon'; // Used in index/Setting
    const DEFAULT_VAL_TUE = 'tue'; // Used in index/Setting
    const DEFAULT_VAL_WED = 'wed'; // Used in index/Setting
    const DEFAULT_VAL_THU = 'thu'; // Used in index/Setting
    const DEFAULT_VAL_FRI = 'fri'; // Used in index/Setting
    const DEFAULT_VAL_SAT = 'sat'; // Used in index/Setting
    const DEFAULT_VAL_SUN = 'sun'; // Used in index/Setting
    const DEFAULT_VAL_C = 'c'; // Used in index/Setting
    const DEFAULT_VAL_E = 'e'; // Used in index/Setting
    const DEFAULT_VAL_E_CAP = 'E'; // Used in index/Setting
    const DEFAULT_VAL_P = 'p'; // Used in index/Setting,user/ContactInformation
    const DEFAULT_VAL_DASH = '-'; // Used in index/Setting
    const DEFAULT_VAL_1 = '1'; // Used in Index All Action
    const DEFAULT_VAL_A = 'a'; // Used in Index All Action
    const DEFAULT_VAL_D = 'd'; // Used in Index All Action
    const DEFAULT_VAL_USER_STATUS = 'a'; // Used in Index All Action
    const DEFAULT_VAL_USER_TYPE_ADMIN = 'a'; // Used in Index All Action
    const DEFAULT_VAL_USER_TYPE_GENERAL = 'g'; // Used in Index All Action
    const DEFAULT_VAL_B = 'b'; // Used in Paster
    const DEFAULT_VAL_N = 'n'; // Used in Index All Action
    const DEFAULT_VAL_2 = '2'; // Used in Index All Action
    const DEFAULT_VAL_START_RAND = '1000'; // Used in index/Register
    const DEFAULT_VAL_END_RAND = '9999'; // Used in index/Register
    const DEFAULT_VAL_3600 = '3600'; // Used in index/Login
    const DEFAULT_VAL_24 = '24'; // Used in index/Login
    const DEFAULT_VAL_30 = '30'; // Used in index/Login
    const DEFAULT_VAL_0 = '0'; // Used in user/ContactInformation
    const DEFAULT_VAL_S = 's'; // Used in user/ContactInformation
    const DEFAULT_VAL_NUMBER_ROUND = '2'; 
//	const DEFAULT_VAL_F = 'f'; // Used in user/AddPortfolio
    const DEFAULT_VAL_IMAGE_DIMENSION_SEPRATOR = 'x'; // Used in CommonUtility/getUrlFromJson
    const DEFAULT_VAL_NULL = ''; // Used in all Controller
    const DEFAULT_VAL_NULL_ARRAY = '[]'; // Used in all Controller
    const DEFAULT_VAL_UNDERSCORE = "_"; // Used in all Controller
//    const DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH = "yy-mm-dd"; // Used in User/AddPortfolio
      const DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH = "d-m-Y"; 
    const DEFAULT_VAL_DATE_FORMATE_M_D_Y_SLASH = "m/d/y"; // Used in User/AddPortfolio
    const DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH = "Y-m-d"; // Used in User/AddPortfolio
    const DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH = "YYYY-MM-DD"; // Used in Tasker
    const DEFAULT_VAL_DATE_FORMATE_YYYY_MM_DD_DASH_SMALL = "yyyy-mm-dd"; // Used in Tasker
    const DEFAULT_VAL_DATE_FORMATE_DD_MM_YYYY_SLASH = "MM/dd/yyyy"; // Used in Tasker
     const DEFAULT_VAL_TASK_END_TIME = "12:00"; // Used in Tasker
    const DEFAULT_VAL_DATE_FORMATE_YMD = "Ymd"; // Used in poster
    const DEFAULT_VAL_DATE_FORMATE_D_MMM_Y = "MMM d, y"; // Used in poster
	const DEFAULT_VAL_DATE_FORMATE_D_M = "d M"; // Used in poster
    const DEFAULT_VAL_DATE_FORMATE_Y = "Y"; // Used in UTILITYHTML
    const DEFAULT_VAL_DATE_FORMATE_M = "m"; // Used in CommonYtility
    const DEFAULT_VAL_DATE_FORMATE_D = "d"; // Used in CommonYtility
    const DEFAULT_VAL_DATE_FORMATE_H = "h"; // Used in CommonYtility
    const DEFAULT_VAL_DATE_FORMATE_S = "s"; // Used in CommonYtility
    const DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME = "Y-m-d H:i:s"; // Used in User/AddPortfolio
    const DEFAULT_VAL_END_TIME_FORMATE = "H:i"; // Used in User/AddPortfolio
    const DEFAULT_VAL_END_TIME_FORMATE_TO_VIEW = "h:mm a"; // Used in User/AddPortfolio
    const DEFAULT_VAL_TIME_FORMATE_TIMEPICKER = "h:mm"; // Used in Poster
    const DEFAULT_VAL_DATE_MIN_DATE_TIME = 'Y,m-1,d,H,i'; // Used in Poster
    const DEFAULT_VAL_DATE_MAX_DATE_TIME = '+48 hours'; // Used in Poster
    const DEFAULT_VAL_TIME_FORMATE = "H:i"; // Used in Poster
    const DEFAULT_VAL_DATE_TIME_FORMATE_INSTANT_TASK_END = "MM dd, yy gg:ii a"; // Used in Poster
    
    
    const DEFAULT_VAL_DATE_START_FROM = '-0d'; // Used in Poster
      
      
    const DEFAULT_VAL_DATE_YEAR_RANGE = "2000:2099"; // Used in User/AddPortfolio
    const DEFAULT_VAL_IMAGE_TYPE = "image"; // Used in User/AddPortfolio
    const DEFAULT_VAL_VIDEO_TYPE = "video"; // Used in User/AddPortfolio
    const DEFAULT_VAL_DOC_TYPE = "doc"; // Used in User/AddPortfolio
    const DEFAULT_VAL_EXCEL_TYPE = "excel"; // Used in User/AddPortfolio
    const DEFAULT_VAL_PDF_TYPE = "pdf"; // Used in User/AddPortfolio
    const DEFAULT_VAL_ZIP_TYPE = "zip"; // Used in User/AddPortfolio
    const DEFAULT_VAL_PPT_TYPE = "ppt"; // Used in User/AddPortfolio
    
    const DEFAULT_VAL_404 = "404"; // Used in User/AddPortfolio
    const DEFAULT_CURRENCY = "$";
    const DEFULT_FIXED_PRICE = "25";
    const CATEGORY_LIMIT = "5"; // User in Category Models
    const TASK_LIMIT = 5; // User in Task Models
     const TASK_LIST_PAGE_SIZE = 10; // User in Task Models
     const DEFAULT_VAL_READ_MORE_OPEN_SPEED = 10; // User in Task Models
     
    const DEFAULT_VAL_PROPOSALS_PAGE_SIZE = '5'; // User in Task Models
    const DEFAULT_VAL_LIMIT = '-1'; // User in Task Models
    const DEFAULT_VAL_MAX_YEAR_RANGE = "5";
    const DEFAULT_VAL_SKILLS_DISPLAY_IN_COLUMN = "4";
    const DEFAULT_VAL_URL_BREAK = "urlBreak"; // Used in CommanFront/AjaxSetUrlSession
    const DEFAULT_VAL_AND = "&"; // Used in CommanFront/AjaxSetUrlSession
    const DEFAULT_VAL_DO_DELETE = "doDelete"; // Used in CommanFront/Ajaxupdate,admin/category/Ajaxupdate,,admin/Common/Ajaxupdate
    const DEFAULT_VAL_LOCALE = "Locale"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const DEFAULT_VAL_DO_ACTION = "doActive"; // Used in CommanFront/Ajaxupdate,admin/ ALL Controller Action Ajaxupdate
    const DEFAULT_VAL_DO_IN_ACTION = "doInactive"; // Used in CommanFront/Ajaxupdate,admin/category/Ajaxupdate,admin/Common/Ajaxupdate
    const DEFAULT_VAL_ROLES = "Roles"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const DEFAULT_VAL_ROLE = "Role"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const DEFAULT_VAL_INVITE = "inv"; // Used in CommanFront/Ajaxupdate,admin/Common/Ajaxupdate
    const DEFAULT_VAL_LATITUDE = "0";
    const DEFAULT_VAL_LONGUTUDE = "0";
    const DEFAULT_VAL_MAP_ZOOM = "8";
    const DEFAULT_VAL_F = "f"; // Used in poster
    const DEFAULT_VAL_USER = "user"; // Used in poster
    const DEFAULT_VAL_AUTO = "auto"; // Used in poster
    const DEFAULT_VAL_BID = "bid"; // Used in poster
    const DEFAULT_VAL_O = "o"; // Used in poster
    const DEFAULT_VAL_V = "v"; // Used in poster
    const DEFAULT_VAL_I = "i"; // Used in poster
    const DEFAULT_VAL_SIDEBAR_TASKER_FOUND = "3"; // Used in poster map
    const DEFAULT_VAL_R = "r"; // Used in poster
    const DEFAULT_VAL_INSTANT = "instant"; // Used in poster
    const DEFAULT_VAL_INPERSON = "inperson"; // Used in poster
    const DEFAULT_VAL_IN_PERSON = "in-person"; // Used in poster
    const DEFAULT_VAL_VIRTUAL = "virtual"; // Used in poster
    const DEFAULT_VAL_OTHER = "other"; // Used in poster
    const DEFAULT_VAL_TASK_DESCRIPTION_LENGTH = "1000"; // Used in poster
    const DEFAULT_VAL_VALID_FROM_DT = ""; // Used in poster
    const DEFAULT_VAL_NUMBERS_AFTER_DOT_MILES_AWAY = "1"; // Used in poster
    const DEFAULT_VAL_PRIORITY = "1000"; // Used in poster
    const DEFAULT_VAL_ADD = "add"; // Used in poster
    const DEFAULT_VAL_EDIT = "edit"; // Used in poster
    const DEFAULT_VAL_YEAR = "year"; // Used in poster
    const DEFAULT_VAL_MONTH = "month"; // Used in poster
    const DEFAULT_VAL_WEEK = "week"; // Used in poster
    const DEFAULT_VAL_DAY = "day"; // Used in poster
    const DEFAULT_VAL_HOUR = "hour"; // Used in poster
    const DEFAULT_VAL_MINUTE = "minute"; // Used in poster
    const DEFAULT_VAL_SECOND = "second"; // Used in poster
    const DEFAULT_VAL_40 = "40"; // Used in poster
    const DEFAULT_VAL_RADIUS = "3958"; // Used in poster
    const DEFAULT_VAL_PI = "3.1415926"; // Used in poster
    const DEFAULT_VAL_DEG_PER_RAD = "57.29578"; // Used in poster
    const DEFAULT_VAL_EARTH_RADIUS = "3958"; // Used in poster
    const DEFAULT_VAL_TASK_KIND_VIRTUAL = "v"; // Used in poster
    const DEFAULT_VAL_TASK_KIND_INPERSON = "p"; // Used in poster
    const DEFAULT_VAL_TASK_KIND_INSTANT = "i"; // Used in poster
    const DEFAULT_VAL_CREATOR_ROLE_POSTER = "p"; // Used in poster
    const DEFAULT_VAL_CREATOR_ROLE_TASKER = "t"; // Used in poster
    //Form Name
    const DEFAULT_VAL_LOGIN_FORM = 'login-form'; // Used in index/Login
    const DEFAULT_VAL_REGISTER_FORM = 'register-form'; // Used in index/Login
    const DEFAULT_VAL_UPDATEFROFILE_FORM = 'updatefrofile-form'; // Used in index/Login
    const DEFAULT_VAL_FORGOT_PASSWORD_FORM = 'forgotpassword-form'; // Used in index/Login
    const DEFAULT_VAL_UPDATE_PROFILE_FORM = 'updateprofile-form'; // Used in index/Login
    const DEFAULT_VAL_CHANGE_PASSWORD_FORM = 'changepassword-form'; // Used in index/Login
    const DEFAULT_VAL_UPLOAD_VIDEO_FORM = 'uploadvideo-form'; // Used in index/Login
    const DEFAULT_VAL_ADDRESSINFO_FORM = 'addressinfo-form'; // Used in index/Login
    const DEFAULT_VAL_ABOUTUS_FORM = 'aboutus-form'; // Used in index/Login
    const DEFAULT_VAL_UPLOAD_FORM = 'upload-form'; // Used in index/Login
    const DEFAULT_VAL_CONTACT_INFORMATION_FORM = 'contactinformation-form'; // Used in index/Login
    const DEFAULT_VAL_ADMIN_FORM = 'admin-form'; // Used in admin/admin/Admin
    const DEFAULT_VAL_CATEGORY_FORM = 'category-form'; // Used in admin/category/performAjaxValidation
    const DEFAULT_VAL_CITY_FORM = 'city-form'; // Used in admin/city/performAjaxValidation
    const DEFAULT_VAL_COUNTRY_FORM = 'country-form'; // Used in admin/country/performAjaxValidation
    const DEFAULT_VAL_LANGUAGE_FORM = 'language-form'; // Used in admin/language/performAjaxValidation
    const DEFAULT_VAL_REGION_FORM = 'region-form'; // Used in admin/language/performAjaxValidation
    const DEFAULT_VAL_ROLES_FORM = 'roles-form'; // Used in admin/roles/performAjaxValidation
    const DEFAULT_VAL_STATE_FORM = 'state-form'; // Used in admin/roles/performAjaxValidation
    const DEFAULT_VAL_USER_FORM = 'user-form'; // Used in admin/roles/performAjaxValidation
    const DEFAULT_VAL_MILES = "5"; // Used in poster/createtask
    const DEFAULT_VAL_COUNTRY_CODE = "US"; // Used in poster/createtask
    const DEFAULT_VAL_BROWSE_TEMPLATE_DESCRIPTION_LIMIT_TO = "500"; // Used in poster/createtask
    const DEFAULT_VAL_BROWSE_TEMPLATE_DESCRIPTION_LIMIT_FROM = "0"; // Used in poster/createtask
    const DEFAULT_VAL_IS_LOGIN_ALLOWED = "1"; // Used in components/frontUserIdentity
    const DEFAULT_VAL_IS_VERIFIED = "1"; // Used in components/frontUserIdentity
    const DEFAULT_VAL_CONTACT_TYPE = "E"; // Used in components/frontUserIdentity
    const DEFAULT_VAL_ACTIVE_STATUS_NUMBER = 1; // Used in components/UtilityHtml
    const DEFAULT_VAL_DEACTIVE_STATUS_NUMBER = 0; // Used in components/UtilityHtml
    const DEFAULT_VAL_ACTIVE_STATUS_YES = "yes"; // Used in components/UtilityHtml
    const DEFAULT_VAL_ACTIVE_STATUS_ALFABET = "a"; // Used in components/UtilityHtml
    const DEFAULT_VAL_SUSPEND_STATUS_ALFABET = "s"; // Used in components/UtilityHtml
    const DEFAULT_VAL_DEACTIVE_STATUS_ALFABET = "n"; // Used in components/UtilityHtml
    const DEFAULT_VAL_ACTIVE_STATUS_ALFABET_FOR_URL = 'a'; // Used in components/UtilityHtml
    const DEFAULT_VAL_DEACTIVE_STATUS_ALFABET_FOR_URL = 'n'; // Used in components/UtilityHtml
    const DEFAULT_VAL_PAYMENT_MODE = 'f'; // Used in components/UtilityHtml
    const DEFAULT_VAL_PAYMENT_MODE_HOURLY = 'h'; // Used in components/UtilityHtml
    const DEFAULT_VAL_QUESTION_TYPE_LODICAL = 'l'; // Used in components/UtilityHtml 
    const DEFAULT_VAL_QUESTION_TYPE_ONLINE = 'v'; // Used in components/UtilityHtml 
    const DEFAULT_VAL_TASK_STATUS_OPEN = 'o'; // Used in components/UtilityHtml 
    const DEFAULT_VAL_USER_GENDER_MALE = 'M'; // Used in components/UtilityHtml 
    const DEFAULT_VAL_USER_GENDER_FEMALE = 'F'; // Used in components/UtilityHtml 
    const DEFAULT_VAL_SLACE_N = "\n"; // Used in components/UtilityHtml 
    const DEFAULT_VAL_CALENDER_START_YEAR = 1940; // Used in components/UtilityHtml 
    const DEFAULT_VAL_EXPERIANCE_YEAR_PLUS = 20; // Used in components/UtilityHtml 
    const DEFAULT_VAL_CATEGORY_DROPDOWN_IMAGE_PADDING = 20; // Used in components/UtilityHtml 
    const DEFAULT_VAL_CATEGORY_DROPDOWN_DATA_PADDING = 45; // Used in components/UtilityHtml 
    const DEFAULT_VAL_CONTACT_IS_PRIMARY = "1"; // Used in index/Register
    const DEFAULT_VAL_CONTACT_EMAILTYPE = "E"; // Used in index/Register
    const DEFAULT_VAL_CONTACT_PHONETYPE = "P"; // Used in index/Register
    
    const DEFAULT_VAL_TASK_IMAGE_WIDTH = "200"; 
    const DEFAULT_VAL_TASK_IMAGE_HEIGHT = "200"; 
    const DEFAULT_VAL_NOTIFICATION_DESCRIPTION_LIMIT = "200"; 
    const DEFAULT_VAL_TASK_LIST_DESCRIPTION_LIMIT = "40";
    
    const DEFAULT_VAL_MY_TASK_DESCRIPTION_LIMIT = "200"; 
    const DEFAULT_VAL_MY_TASK_DETAIL_PROPOSAL_LIMIT = "55"; 
    const DEFAULT_VAL_MY_PROPOSAL_LIST_DESCRIPTION_LIMIT = "200"; 
    const DEFAULT_VAL_TASK_DETAIL_PORPOSAL_SIDE_BAR_LIMIT = "3";
    const DEFAULT_VAL_HIGHLY_RATED_FILTER_LIMIT = "10";
    
    const DEFAULT_VAL_MOST_VALUED_FILTER_LIMIT = "10";
    const DEFAULT_VAL_TASK_FILTER_NEARBY_RANGE = "20";
     
    const DEFAULT_VAL_NOTIFICATION_NOTSEEN = "0"; //index
    const DEFAULT_VAL_NOTIFICATION_SEEN = "1"; //index
    const DEFAULT_VAL_IS_LOCATION_REGION_COUNTRY = 'c'; // Used in poster
    const DEFAULT_VAL_IS_LOCATION_REGION_ANYWHERE = 'a'; // Used in poster
    const DEFAULT_VAL_IS_LOCATION_REGION_REGION = 'r'; // Used in poster
    
    const DEFAULT_VAL_TASK_STATE_ASSIGNED = "a"; // Used in poster
    const DEFAULT_VAL_TASK_STATE_FINISHED = "f"; // Used in poster
    const DEFAULT_VAL_TASK_STATE_OPEN = "o"; // Used in poster
    const DEFAULT_VAL_TASK_STATE_CANCELED = "c"; // Used in poster
    const DEFAULT_VAL_TASK_STATE_UNDER_DISPUTE = "d"; // Used in poster
    const DEFAULT_VAL_TASK_STATE_UNDER_SUSPENDED = "s"; // Used in poster
    const DEFAULT_VAL_IS_EXTERNAL = "1"; // Used in user
    const DEFAULT_VAL_IS_EXTERNAL_NOT = "0"; // Used in user
    const DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM = "p"; // Used in tasker
    const DEFAULT_VAL_ACCOUNT_TYPE_SUPER_PREMIUM = "sp"; // Used in tasker
    const DEFAULT_VAL_ACCOUNT_TYPE_REGULAR = "r"; // Used in tasker
    
    const DEFAULT_VAL_NO_ACCOUNT_TYPE = "No Account Type"; // Used in tasker
    
    
    const DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM_VAL = "Premium"; // Used in tasker
    const DEFAULT_VAL_ACCOUNT_TYPE_SUPER_PREMIUM_VAL = "Super Premium"; // Used in tasker
    const DEFAULT_VAL_ACCOUNT_TYPE_REGULAR_VAL = "Regular"; // Used in tasker
    
    
    const DEFAULT_VAL_MY_TASK_LIST_LIMIT = "5"; // Used in poster
    const DEFAULT_VAL_RATING_MULITIPLY = "2"; // Used in commonutility
    const DEFAULT_VAL_RATING_MULITIPLY_1 = "1"; // Used in commonutility
    const DEFAULT_VAL_STAR_RATING_TYPE = "5"; // Used in commonutility
    
    const DEFAULT_VAL_BOOKMARK_TYPE_TASK = "task"; // Used in tasker
    const DEFAULT_VAL_BOOKMARK_TYPE_TASKER = "tasker"; // Used in tasker
    const DEFAULT_VAL_BOOKMARK_TYPE_POSTER = "poster"; // Used in poster
    
    const DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE = "f"; // Used in tasker
    const DEFAULT_VAL_BOOKMARK_SUBTYPE_MARK_READ = "r"; // Used in tasker
    const DEFAULT_VAL_BOOKMARK_SUBTYPE_MARK_SAVED = "s"; // Used in tasker
    const DEFAULT_VAL_TASK_TYPE = "a"; // Used in commonutility
    const DEFAULT_USER_LOGIN_NAME_LENGTH = "10"; // Used in commonutility
    const DEFAULT_TASK_TITLE_LENGTH = "25"; // Used in doer profile
    const DEFAULT_VAL_PRICE_RANGE= "0"; // Used in poster
    const DEFAULT_VAL_FRONT_ROLE_ACCESS= "1"; // Used in roles
    const DEFAULT_VAL_FRONT_ROLE= "0"; // Used in roles
    const DEFAULT_VAL_TASK_FEW_PROPOSALS_CNT_ON_PUBLIC_SEARCH = "5"; // Used in roles
    const DEFAULT_VAL_MIN_APPROVED_COST = "15"; // Used in poster
    
    const DEFAULT_HOURS_FOR_RESETPASSWORD_MAIL = "48 hours"; // Used in commonutility
    
    const DEFAULT_VAL_USER_ROLE_POSTER = "poster"; // Used in poster
    const DEFAULT_VAL_USER_ROLE_TASKER = "tasker"; // Used in poster
    const DEFAULT_VAL_USER_NOTIFICATION = "notification"; // Used in user notification
    
    
    const DEFAULT_VAL_MSG_TYPR_PROPOSAL = "proposal"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_PAYMENT = "payment"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_TERMS = "terms"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_FEEDBACK = "feedback"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_MESSAGES = "messages"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_INVITES = "invites"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_DRAFTS = "drafts"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_HIRING = "hiring"; // Used in user notification
    const DEFAULT_VAL_MSG_TYPR_CONFIRM_HIRING = "confirm_hiring"; // Used in user notification
    
     const DEFAULT_VAL_MSG_SUBJECT_PROPOSAL = "New message on task"; // Used in user inbox
     const DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE = "1"; // Used in user inbox
     const DEFAULT_VAL_MSG_IS_PUBLIC_INACTIVE = "0"; // Used in user inbox
     const DEFAULT_VAL_IS_DELETE_INACTIVE = "0"; // Used in user inbox
     const DEFAULT_VAL_IS_DELETE_ACTIVE = "1"; // Used in user inbox
    const DEFAULT_VAL_MSG_FLOW_SENT = "s"; // Used in user inbox 
     const DEFAULT_VAL_MSG_FLOW_RECEIVED = "r"; // Used in user inbox  
     const DEFAULT_VAL_MSG_IS_READ = "1"; // Used in user inbox  
     const DEFAULT_VAL_MSG_IS_NOT_READ = "0"; // Used in user inbox  
     const DEFAULT_VAL_HIRING_CLOSED_ACTIVE = "1"; // Poster
     const DEFAULT_VAL_HIRING_CLOSED_INACTIVE = "0"; // Poster
     const DEFAULT_VAL_IS_INVITED_INACTIVE = "0"; // Poster
     const DEFAULT_VAL_IS_INVITED_ACTIVE = "1"; // Poster
    const DEFAULT_VAL_IS_POSTER_ACTIVE = "1"; // Poster
    const DEFAULT_VAL_IS_POSTER_INACTIVE = "0"; // Poster
     //
     //
    ///Alerts///
    const ALERT_TYPE_INSTANT = "instant"; // Used in poster
    const ALERT_TYPE_INPERSON = "inperson"; // Used in poster
    const ALERT_TYPE_VIRTUAL = "virtual"; // Used in poster
    const ALERT_TYPE_OTHER = "other"; // Used in poster
    const ALERT_TYPE_CREATE_PROPOSAL = "proposal"; // Used in poster
    const ALERT_DESC_CREATE_PROPOSAL = "proposal_created"; // Used in poster
    const ALERT_TYPE_ACCEPT_PROPOSAL = "proposalAccept"; // Used in poster
    const ALERT_DESC_ACCEPT_PROPOSAL = "proposal_accepted"; // Used in poster
    const ALERT_DESC_HIRING_OFFER_ACCEPT = "hiring_offer_accepted"; // Used in poster
    const ALERT_DESC_HIRING_OFFER_REJECT = "hiring_offer_rejected"; // Used in poster
    const ALERT_TYPE_REJECT_PROPOSAL = "proposalReject"; // Used in poster
    const ALERT_DESC_REJECT_PROPOSAL = "proposal_rejected"; // Used in poster
    const ALERT_DESC_SHOW_INTEREST_PROPOSAL = "proposal_show_interest"; // Used in poster
    const ALERT_DESC_TASKER_INVITED = "tasker_invited"; // Used in poster
    const ALERT_DESC_REJECT_PROPOSAL_BY_USER = "proposal_rejected_by_tasker"; // Used in index
    const ALERT_DESC_TASK_EDITED = "task_edited"; // Used in poster
    const ALERT_DESC_TASK_CANCELED = "task_canceled"; // Used in poster
    //const ALERT_DESC_TASKER_INVITED = "tasker_invited"; // Used in poster
    
    const EXTERNAL_TASK_TYPE = "e"; // Used in commonutility
    
    const ERROR_EMAIL_INVALID = 'ERROR_EMAIL_INVALID'; // Used in index/login
    const ERROR_PASSWORD_INVALID = 'ERROR_PASSWORD_INVALID'; // Used in index/login
    const ERROR_STATUS_DEACTIVE = 'ERROR_STATUS_DEACTIVE'; // Used in index/login
    const ERROR_NONE = 'ERROR_NONE'; // Used in index/login
    const EMAIL_INVALID_MSG = '[Invalid email id]'; // Used in index/login
    const PASSWORD_INVALID_MSG = '[Invalid password]'; // Used in index/login
    const STATUS_DEACTIVE_MSG = '[User status is deactive]'; // Used in index/login
    //Images Dimensions
   
  
    
    
    
     //
    //const IMAGE_THUMBNAIL_PROFILE_PIC_DEFAULT_ARRAY = array('80x80','35x35','180x180'); // Used in poster/confirmtask
    const IMAGE_AVATAR = DEFAULTAvatarImage; // User in CommonfrontController/actionUserPic,actionSmallPic
    const IMAGE_NOT_FOUND = imageNotFound; // User in CommonfrontController/actionUserPic,actionSmallPic
    const IMAGE_REMOVE = imageRemove;
    const IMAGE_DOWNLOAD = imageDownload;
    const IMAGE_COLLAPSE = collapseImg;
    const IMAGE_EXPAND = expandImg;
    const IMAGE_CATEGORY_AVATAR = "avatar.png";
    const IMAGE_AJAX_LOADING = loadingImg;
    const IMAGE_STATUS_ACTIVE = statusActiveImage;
    const IMAGE_EDIT_ACTIVE = "update.png";
    
    const IMAGE_EDIT_INACTIVE = "unavailable.png";
    const IMAGE_STATUS_INACTIVE = statusInactiveImage;
    
    const IMAGE_STATUS_SUSPEND = statusSuspendImage;
    
    const IMAGE_PASSWORD_CHANGE = passwordChangeImage;
    const IMAGE_DELETE_ACTIVE = "delete.png";
    
    const SHARE_IMAGE_MIN_WIDTH = "250";
    const SHARE_IMAGE_MIN_HEIGHT = "250";
    const DEFUALT_TASK_SHARE_IMAGE = "taskshare.jpg";
    const SHARE_SUMMERY_LIMIT = "100";
    const SHARE_SITE_NAME = "Green Comet";
     
     
    //folder
    const FOLDER_BACK_PATH = ".."; // User in CommonfrontController/actionUserPic,actionSmallPic
    //headers
    const HEADER_CONTENT_TYPE_IMAGE_JPEG = 'Content-Type: image/jpeg';    // All
    const HEADER_CONTENT_LENGTH = 'Content-Length: '; // All
    const HEADER_CONTENT_TYPE_VIDEO_MPEG = 'Content-Type: video/mpeg'; // All
    const HEADER_CONTENT_TYPE_VIDEO_MP4 = 'Content-Type: video/mp4'; // All
    const HEADER_ACCEPT_RANGES_BYTES = 'Accept-Ranges: bytes'; // All
    const HTTP_HOST = 'HTTP_HOST'; // All
    const HTTP_REFERER = 'HTTP_REFERER'; // All
    const REMOTE_ADDR = 'REMOTE_ADDR'; // All
    const HTTP_THREE_SLASH = httpThreeslash; // All
    const QUESTION_MARK_FOR_URL = "?"; // All
    const AUTO_COMPLETE_SIZE = "40"; // All
    const AUTO_COMPLETE_MAX_LENGTH = "50"; // All
    const DEFAULT_VAL_ATTHERATE = "@"; // All
    const DEFAULT_VAL_SHA_256 = "sha256"; // All
    const DEFAULT_VAL_TASK_SMALL_IMAGE_URL_SLUG = "s"; // All
    const DEFAULT_VAL_TASK_PROPOSAL_SMALL_IMAGE_URL_SLUG = "s"; // All
    const DEFAULT_VAL_TASK_PROPOSAL_IMAGE_URL_SLUG = "proposal"; // All
    //dates
    //encrypion
    const ENCRYPTION_KEY = '!@#$'; // All 
    //////urls
    //
   //
   const URL_COMMON_CHANGESTATUS = 'common/changestatus'; // utilityhtml
   const URL_DELETE_SKILL = 'skill/delete'; // utilityhtml
    const URL_CATEGORY_TYPE_SLUG = 'cat-'; // commonutility
    const URL_SUBCATEGORY_TYPE_SLUG = 'scat-'; // commonutility
    //  Field Names TASK TASKER
    const FLD_NAME_APPROVED_COST = 'approved_cost';// Used in tasker
    const FLD_NAME_TASKER_PROPOSED_COST = "proposed_cost"; // Used in poster
    const FLD_NAME_TASKER_POSTER_COMMENTS = "tasker_comments"; // Used in poster
    const FLD_NAME_POSTER_COMMENTS = "poster_comments"; // Used in poster
    const FLD_NAME_TASKER_LOCATION_GEO_AREA = "tasker_location_geo_area";
    const FLD_NAME_TASKER_ATTACHMENTS = "attachments"; // Used in poster
    const FLD_NAME_TASK_TASKER = "TaskTasker"; // Used in poster
    const FLD_NAME_TASKTASKER = "taskTasker"; // Used in poster
    const FLD_NAME_TASK_TASKER_RECEIPT_ID = "task_tasker_receipt_id"; // Used in poster
    const FLD_NAME_RECEIPT_AMOUNT = "receipt_amount"; // Used in poster
    const FLD_NAME_EXPENSE = "expense"; // Used in poster
    const FLD_NAME_EXPENSE_REASON = "expense_reason"; // Used in poster
    const FLD_NAME_RECEIPT_REASON = "receipt_reason"; // Used in poster
    const FLD_NAME_RECEIPT_ID = "receipt_id"; // Used in poster
    const FLD_NAME_TASK_TASKER_ID = "task_tasker_id"; // Used in postersource_app
    const FLD_NAME_PROPOSALATTACHMENTS = "proposalAttachments"; // Used in poster
    const FLD_NAME_TASK_QUESTION_REPLY = "TaskQuestionReply"; // Used in poster
    const FLD_NAME_REPLY_YESNO = "reply_yesno"; // Used in poster
    const FLD_NAME_TASKER_STATUS = "status"; // Used in poster
    const DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH = "3000"; // Used in poster
 //   const DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH = "1000"; // Used in poster
    const DEFAULT_VAL_TASKER_SOURCE_APP_WEB = "web"; // Used in poster
    const DEFAULT_VAL_TASKER_SELECTION_TYPE_BID = "bid"; // Used in poster
    const DEFAULT_VAL_ANSWERE_YES = "y"; // Used in poster
    const DEFAULT_VAL_ANSWERE_NO = "n"; // Used in poster
    const DEFAULT_VAL_TASK_STATUS_DRAFT = "d"; // Used in poster
    const DEFAULT_VAL_TASK_STATUS_ACTIVE = "a"; // Used in poster
    const DEFAULT_VAL_TASK_STATUS_SELECTED = "s"; // Used in poster
    const DEFAULT_VAL_TASK_STATUS_HIRING = "h"; // Used in poster
    const DEFAULT_VAL_TASK_STATUS_REJECTED = "r"; // Used in poster
    const DEFAULT_VAL_TASK_STATUS_FINISHED = "f"; // Used in poster
    const DEFAULT_VAL_TASK_STATUS_CANCELED = "c"; // Used in poster
    
    const DEFAULT_VAL_PAGER_TRIGGERPAGETRESHOLD = "2"; // Used in tasker
    const DEFAULT_VAL_LIMIT_IN_POPOVER = "3"; // common
    
    const DEFAULT_APP_NAME_ERANDOO = 'erandoo';
    
     const ATTACHMENT_TYPE_IMAGE = ImageTypeImage;
    const ATTACHMENT_TYPE_DOC_IMAGE = DocTypeImage;
    const ATTACHMENT_TYPE_EXCEL_IMAGE = ExcelTypeImage;
    const ATTACHMENT_TYPE_PDF_IMAGE = PDFTypeImage;
    const ATTACHMENT_TYPE_VIDEO_IMAGE = VideoTypeImage;
    const ATTACHMENT_TYPE_ZIP_IMAGE = ZipTypeImage;
    const ATTACHMENT_TYPE_PPT_IMAGE = PptTypeImage;
    
    
    const FLD_NAME_CATEGORY_TEMPLATE_TOTAL = "totalCatTmplId"; //Used in admin Category Update
    //
  //Activity
    
    
    const TASK_ACTIVITY_SUBTYPE_TASK_VIRTUAL = 'virtual';
    const TASK_ACTIVITY_SUBTYPE_TASK_INPERSON = 'inperson';
    const TASK_ACTIVITY_SUBTYPE_TASK_INSTANT = 'instant';
    const TASK_ACTIVITY_SUBTYPE_OTHER = 'other';
    const TASK_ACTIVITY_TYPE_TASK_CREATE = 'task_create';
    const TASK_ACTIVITY_TYPE_TASK_UPDATE = 'task_update';
    const TASK_ACTIVITY_TYPE_TASK_CANCEL = 'task_cancel';
    const TASK_ACTIVITY_TYPE_TASK_PUBLISH = 'task_publish';
    const TASK_ACTIVITY_TYPE_PROPOSAL_CREATE = 'proposal_create';
    const TASK_ACTIVITY_TYPE_PROPOSAL_UPDATE = 'proposal_update';
    const TASK_ACTIVITY_TYPE_PROPOSAL_PUBLISH = 'proposal_publish';
    const TASK_ACTIVITY_TYPE_PROPOSAL_ACCEPT = 'proposal_accept';
    const TASK_ACTIVITY_TYPE_HIRING_OFFER_ACCEPT = 'hiring_offer_accepted';
    const TASK_ACTIVITY_TYPE_PROPOSAL_REJECT = 'proposal_reject';
    const TASK_ACTIVITY_TYPE_PROPOSAL_SHOW_INTEREST = 'proposal_show_interest';
  //User Ativity
    const USER_ACTIVITY_TYPE_PROFILE_UPDATE = 'profile_update';
    const USER_ACTIVITY_TYPE_PROFILE_CREATE = 'profile_create';
    const USER_ACTIVITY_SUBTYPE_BOOKMARK = 'bookmark';
    const USER_ACTIVITY_SUBTYPE_BOOKMARK_TASK = 'bookmark_task';
    const USER_ACTIVITY_TYPE_LOGIN = 'login';
    const USER_ACTIVITY_TYPE_LOGOUT = 'logout';
    
    const USER_ACTIVITY_SUBTYPE_PROFILE_IMAGE_CHANGE = 'profile_image_change';
    const USER_ACTIVITY_SUBTYPE_PROFILE_VIDEO_CHANGE = 'profile_video_change';
    const USER_ACTIVITY_SUBTYPE_PROFILE_PROFILE_CHANGE = 'profile_update';
    const USER_ACTIVITY_SUBTYPE_PROFILE_ADDRESS = 'profile_addressinfo';
    const USER_ACTIVITY_SUBTYPE_PROFILE_ABOUTUS = 'profile_aboutus';
    const USER_ACTIVITY_SUBTYPE_PROFILE_SETTING = 'profile_setting';
    const USER_ACTIVITY_SUBTYPE_PROFILE_DELETE_SCHEDULE = 'profile_delete_schedule';
    const USER_ACTIVITY_SUBTYPE_PROFILE_CHANGE_PASSWORD = 'profile_change_password';
    const USER_ACTIVITY_SUBTYPE_REGISTER = 'register';
    const USER_ACTIVITY_SUBTYPE_PROFILE_CONTACTINFO = 'profile_contactinfo';
    const USER_ACTIVITY_SUBTYPE_PROFILE_ACCOUNT_PREFERENCE = 'profile_account_preference';
    const USER_ACTIVITY_SUBTYPE_PROFILE_DELETE_PAYAPL_ACCOUNT = 'profile_delete_paypal_account';
    const USER_ACTIVITY_SUBTYPE_PROFILE_UPDATE_PAYAPL_ACCOUNT = 'profile_update_paypal_account';
    const USER_ACTIVITY_SUBTYPE_PROFILE_ACCOUNT_UPDATE = 'profile_account_update';
    const USER_ACTIVITY_SUBTYPE_PROFILE_DELETE_ACCOUNT = 'profile_delete_account'; 
  
  
     //  Field Names TASK Question reply
    const FLD_NAME_TASKER_QUESTION_REPLY_DESC = "reply_desc"; // Used in poster

   const DEFAULT_LANGUAGE = "en_us";
   const DEFAULT_VAL_AUTO_INVATATION_BY_SYSTEM = "10";
   const DEFAULT_VAL_PROPOSAL_DESCRIPTION_LENGTH = "300";
   const DEFAULT_VAL_INVITE_LASK_LIST_LIMIT = 3;
   
    //   arrays
    const IMAGE_THUMBNAIL_PROFILE_PIC_35 = '35x35'; // Used in commonUtility/getThumbnailMediaURI
    const IMAGE_THUMBNAIL_PROFILE_PIC_50 = '50x50'; // Used in commonUtility/getThumbnailMediaURI
    const IMAGE_THUMBNAIL_PROFILE_PIC_60 = '60x60'; // Used in commonUtility/getThumbnailMediaURI
    const IMAGE_THUMBNAIL_PROFILE_PIC_71_52 = '71x52';
    const IMAGE_THUMBNAIL_PROFILE_PIC_80_80 = '80x80';
    const IMAGE_THUMBNAIL_DEFAULT = self::IMAGE_THUMBNAIL_PROFILE_PIC_80_80; // Used in commonUtility/getThumbnailMediaURI
    const IMAGE_THUMBNAIL_PROFILE_PIC_100 ='100x100'; // Used in commonUtility/getThumbnailMediaURI
    const IMAGE_THUMBNAIL_PROFILE_PIC_180 = '180x180'; // Used in poster/confirmtask
    const IMAGE_THUMBNAIL_PROFILE_PIC_200 ='200x200'; // Used in commonUtility/getThumbnailMediaURI
    const IMAGE_THUMBNAIL_PROFILE_PIC_241_251 = '241x251';
    const IMAGE_THUMBNAIL_PROFILE_PIC_300 ='300x300'; // Used in commonUtility/getThumbnailMediaURI
    
    
    
    private static $thumbnailImageSizes = array(
        self::IMAGE_THUMBNAIL_PROFILE_PIC_35,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_50,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_60,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_71_52,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_80_80,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_100,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_180,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_200,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_241_251,
        self::IMAGE_THUMBNAIL_PROFILE_PIC_300
         ); /// must be sort accending
    
    public function getThumbnailImageSizes() 
    {
        return self::$thumbnailImageSizes;
    }
    
    
    
   const DEFAULT_CATEGORY_CACHE_DURATION = "60";
   
    
    public static $cacheKeys =  array(
      'GET_COUNTRY_LIST' => 'getCountryList',
      'MST_GETSKILLS' => 'mst_getSkills',
      'GET_CATEGORY_LIST' => 'getCategoryList',
      'GET_IN_PERSON_CATEGORY_LIST' => 'getInpersonCategoryList',
      'GET_INSTANT_CATEGORY_LIST' => 'getInstantCategoryList',
      'GET_VIRTUAL_CATEGORY_LIST_PARENT_ONLY' => 'getVirtualCategoryListParentOnly',
      'GET_LANGUAGE_LIST' => 'getLanguageList',
      'WIDGET_VIEW_CATEGORY_INPERSON' => 'inpersontaskCatgWidgetView',
      'WIDGET_VIEW_CATEGORY_INSTANT' => 'instanttaskCatgWidgetView',
      'VIEW_CATEGORY_VIRTUALTASK' => 'virtualtaskCatgView',
      
      );
     private static $bidDurationArray = array('1 day' => '1 day', '1 week' => '1 week', '15 days' => '15 days', '1 month' => '1 month');
     private static $bidDurationArray_Day = array('1 day' => '1 day');
     private static $bidDurationArray_Week= array('1 day' => '1 day', '1 week' => '1 week');
     private static $bidDurationArray_HMonth = array('1 day' => '1 day', '1 week' => '1 week', '15 days' => '15 days');

     private static $bidDurationArray_AfterDay = array('1 week' => '1 week', '15 days' => '15 days', '1 month' => '1 month');
     private static $bidDurationArray_AfterWeek = array('15 days' => '15 days', '1 month' => '1 month');
     private static $bidDurationArray_AfterHMonth = array('1 month' => '1 month');
  
     
     
    public function getbidDurationArray($type = '') 
    {
        if($type == 'day')
        {
            return self::$bidDurationArray_Day;
        }
        elseif($type == 'week')
        {
            return self::$bidDurationArray_Week;
        }
        elseif($type == 'hmonth')
        {
            return self::$bidDurationArray_HMonth;
        }
        elseif($type == 'afterDay')
        {
            return self::$bidDurationArray_AfterDay;
        }
        elseif($type == 'afterWeek')
        {
            return self::$bidDurationArray_AfterWeek;
        }
        elseif($type == 'afterHmonth')
        {
            return self::$bidDurationArray_AfterHMonth;
        }
        
        return self::$bidDurationArray;
    }
    
    private static $searchProjectDurationOption = array('' => 'All','1day' => '1 day', '1week' => '1 week', '15days' => '15 days', '1month' => '1 month');
    
    public function getProjectSearchArray() 
    {        
        return self::$searchProjectDurationOption;
    }
    
    private static $taskSearchSortingAttributesArray = array(
                                                                '' => "Sort By",
                                                                't.task_id ASC' => "Most Recent ASC",
                                                                't.task_id DESC' => "Most Recent DESC",
                                                                't.proposals_avg_price ASC' => 'Price(Low->High)',
                                                                't.proposals_avg_price DESC' => 'Price(High->Low)',
                                                            );
    private static $taskSearchSortingForDoerAttributesArray = array(
                                                                '' => "Sort By",
                                                                'taskTasker.created_at ASC' => "Most Recent ASC",
                                                                'taskTasker.created_at DESC' => "Most Recent DESC",
                                                                't.proposals_avg_price ASC' => 'Price(Low->High)',
                                                                't.proposals_avg_price DESC' => 'Price(High->Low)',
                                                            );
    private static $doerSearchSortingAttributesArray = array(
                                                                '' => "Sort By",
                                                                't.task_done_cnt ASC' => 'Experienced(Low->High)',
                                                                't.task_done_cnt DESC' => 'Experienced(High->Low)',
                                                                't.rating_avg_as_tasker ASC' => 'Rating(Low->High)',
                                                                't.rating_avg_as_tasker DESC' => 'Rating(High->Low)',
                                                            );
    public function getTaskSearchSortingAttributes() 
    {
        return self::$taskSearchSortingAttributesArray;
    }
    public function getTaskSearchSortingForDoerAttributes() 
    {
        return self::$taskSearchSortingForDoerAttributesArray;
    }
    public function getDoerSearchSortingAttributes() 
    {
        return self::$doerSearchSortingAttributesArray;
    }
     private static $getProposalSearchSortingAttributesArray = array(
                                                                't.created_at' => "Sort By",
                                                                't.created_at ASC' => "Most Recent ASC",
                                                                't.created_at DESC' => "Most Recent DESC",
                                                                't.proposed_cost ASC' => 'Price(Low->High)',
                                                                't.proposed_cost DESC' => 'Price(High->Low)',
//                                                                't.tasker_in_range ASC' => 'Location(Low->High)',
//                                                                't.tasker_in_range DESC' => 'Location(High->Low)'
                                                            );
    public function getProposalSearchSortingAttributes() 
    {
        return self::$getProposalSearchSortingAttributesArray;
    }
    
    private static $getNotificationSearchSortingAttributesArray = array(
                                                                '' => "Sort By",
                                                                't.created_at ASC' => "Most Recent ASC",
                                                                't.created_at DESC' => "Most Recent DESC",
                                                            );
    public function getNotificationSearchSortingAttributes() 
    {
        return self::$getNotificationSearchSortingAttributesArray;
    }
    
    private static $gettaskCompleteHoursAttributesArray = array(
                                                                '1' => "In 1 Hour",
                                                                '2' => "In 2 Hours",
                                                                '3' => "In 3 Hours",
                                                                '4' => "In 4 Hours",
                                                                '5' => "In 5 Hours",
                                                                '6' => "In 6 Hours",
                                                                '7' => "In 7 Hours",
                                                                '8' => "In 8 Hours",
                                                                '9' => "In 9 Hours",
                                                                '10' => "In 10 Hours",
                                                                '11' => "In 11 Hours",
                                                                '12' => "In 12 Hours",
                                                            );
    public function taskCompleteHours() 
    {
        return self::$gettaskCompleteHoursAttributesArray;
    }
    
    private static $taskTypeAttributesArray = array(
                                                        "a" => 'All', 
                                                        "v" => 'Virtual' , 
                                                        "p" => 'Inperson',
                                                        "i" => 'Instant',
                                                    );
    public function gettaskTypeAttributes() 
    {
        return self::$taskTypeAttributesArray;
    }
    
    private static $payWithAttributesArray = array(
                                                        "boa" => 'BOA Debit', 
                                                        "ib" => 'Internet Banking' , 
                                                        "c" => 'Credit Card',
                                                    );
    public function getPayWithAttributes() 
    {
        return self::$payWithAttributesArray;
    }
    
    private static $userActiveWithInSelectAttributesArray = array(
                                                        "1" => 'Last Day', 
                                                        "7" => 'Last Week' , 
                                                        "15" => 'Last 15 Days',
                                                        "30" => 'Last Month',
                                                    );
    public function userActiveWithInSelectArray() 
    {
        return self::$userActiveWithInSelectAttributesArray;
    }
    
     private static $userCompletedProjectSelectAttributesArray = array(
                                                        "5" => '5 Projects', 
                                                        "10" => '10 Projects' , 
                                                        "25" => '25 Projects',
                                                        "50" => '50 Projects',
                                                        "100" => '100 Projects',
                                                    );
    public function userCompletedProjectsSelectArray() 
    {
        return self::$userCompletedProjectSelectAttributesArray;
    }
    
    private static $userAveragePriceWorkDoneAttributesArray = array(
                                                        "10" => '$10', 
                                                        "50" => '$50' , 
                                                        "100" => '$100',
                                                        "500" => '$500',
                                                        "1000" => '$1000',
                                                       
                                                    );
    public function userAveragePriceWorkDoneSelectArray() 
    {
        return self::$userAveragePriceWorkDoneAttributesArray;
    }
    
    
    private static $timeToCompleteAttributesArray = array('1 week' => '1 week', '15 days' => '15 days', '1 month' => '1 month');
    public function timeToCompleteArray() 
    {
        return self::$timeToCompleteAttributesArray;
    }
    // mail constatnts
    const MAIL_NAME_GREEN_COMET = "Green Comet";
    const MAIL_FROM = "virendra.yadav@aryavratinfotech.com";  //"no-reply@aryamobi.com";
    const MAIL_SMTP_SECURE = "ssl";
    const MAIL_HOST = "mail.aryamobi.com";
    const MAIL_PORT = "465";
    const MAIL_SMTP_AUTH = "true";
    const MAIL_USER_NAME = "no-reply@aryamobi.com";
    const MAIL_PASSWORD = "aryamail@2014";
    const MAIL_RESET_PASSWORD = "Reset your Password";
    const MAIL_REGISTER_CONFIRMATION = "Registration Confirmation Mail";
   // const MAIL_PORT = "465";

    
    //permissions
    const PERMISSION_ACTION_USER_CONTROLLER = 'User';
    const PERMISSION_ACTION_USER_ACTION = 'frontaccess';
    
    
    //slider
     const SLIDER_SUBCATEGORY_SCROLL_LIMIT = '5';
     
     
     
     
     /// setting keys
     const SETTING_KEY_MAX_UPLOAD_FILE_SIZE = 'max_upload_file_size';
     const SETTING_KEY_MIN_UPLOAD_FILE_SIZE = 'min_upload_file_size';
     const SETTING_KEY_SPACE_QUOTA_ALLOWED = 'space_quota_allowed';
     const SETTING_KEY_BASIC_MEMBER_SERVICE_FEE = 'basic_member_service_fee';
      const SETTING_KEY_PREMIUM_MEMBER_SERVICE_FEE = 'premium_member_service_fee';
     /// pagesize
     const PAGE_SIZE_REVIEW_PROPOSAL_DETAIL = '5';

     
}
