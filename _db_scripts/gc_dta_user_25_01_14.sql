#http://aryahelp.com/greencomet/profile/edit-profile.html

#gender` m - male, f - female, o - others. 
#  Note: Desc should come from locale specific resource file
#marrital_status - ma - Married, li - Living,  wi - Widowed, se - Separated, di - Divorced, si - Single - See http://www.statcan.gc.ca/concepts/definitions/marital-matrimonial04-eng.htm
#  Note: Desc should come from locale specific resource file

#profile_info - JSON object as {"pic":"","video":"","url":"","url_ispublic":"","video_ispublic":"","pic_ispublic"}

#account_info - JSON object contains phone email, scoial network ids etc. 
#NOTE: this column is not required, if we decide to use gc_dta_user_contact table.
#E.g {"phs":"[{"p":"9178675544","type":"p","{"p":"9178675533","type":"s"}],
#    {"emails":"[{"e":"manoj@gmail.com","type":"p",{"e":"rashmi@arya@.com","type":"s"}]},
#    {"chatids"[{"id":"suppot1","type":"skype"},{"id":"suppot1","type":"yahoo"}]},
#    {"socialids"[{"id":"suppot1@arya.com","type":"fb"},{"id":"suppot1@arya.com","type":"tw"}]}
#Q: how to ask user about primary phone and email?

#about_me - JSON object comains desc, hoppies, languages know etc. {"desc":"I am ..","hobbies":"games, ...","lang_known":"English, French"}

#social_sites_auth_dtl contains social sites authentication information, used share contents on solcial sites. Its is an array of SN Auth details.
#e.g [{"sn":"fb", "id":"124356","token":"a$5h*ag!","expiry":12345,"auth_dt":1234567},{"tw"}]

#languages_known` Is search on language known required?
#prefernces_setting - JSON Object contains privacy polcies, notification preferences, working days and hrs etc. 
#E.g {"contact_by":"'c','e','p'", "ref_check_by":"'c','e','p'", 
#     "create_team":"y","tax":"{"id":"123", "form":"1099","apply":"n"}", "work_hrs":"[{"day":"mon","hrs":"9-10,16-18"},{"day":"tue","hrs":"9-10,16-18"},..]"}

#notify_by_* columns can hold 0 (Off notify), 1=when matching job is available in my city, 2=when matching job is available anywhere
#                             3 = when someone bid on my post  

#What all is required in SQL selects, should be mainatins as separate column, even available in JSON data. 
#For example, timezone, startup are part of prefereces_setting column but also maintained as separate columns

#Status column, which should be 'a' - active, 'd' deactived, and to be used accordigly
#`user_type` default value is 'g' general, 'p' means previlaged, 's' super previlaged. Menu options like Deskboad, Analytics etc can be enabled user_type based. 
#Based on user+type, Select home page list can be shown in preferenes.
#Home page list data should be picked from the locale specific file, and each menu option should have 
# attribure "for":"a" means all,"for":"p" for previlaged users etc. menus = [{"id":"db","name":"Dashboard","for":"a"},{"id":"an","name":"Analytyics","for":"p"}}]
# This information can also be used to show and hide menu options based on user_type.


CREATE TABLE IF NOT EXISTS `gc_dta_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_type` char(1) DEFAULT 'g',  
  `is_verified` bit(1) NOT NULL DEFAULT b'0',  
  `gender` char(1) DEFAULT NULL,
  `marrital_status` char(2) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `tagline` varchar(200) DEFAULT NULL,  
  `date_of_birth` datetime DEFAULT NULL,  
  `preferred_language_code` varchar(5) NOT NULL,
  `country_code` char(2) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `state_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `region_id` int(11) DEFAULT NULL,
  `region_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `city_id` int(11) DEFAULT NULL,
  `city_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `zipcode` varchar(20) NOT NULL DEFAULT b'1',
  `profile_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `profile_info` varchar(2000) DEFAULT NULL,
  `contact_info` varchar(2000) NOT NULL,  -- to be verified
  `billaddr_street1` varchar(100) DEFAULT NULL,
  `billaddr_street2` varchar(100) DEFAULT NULL,
  `billaddr_city_id` int(11) DEFAULT NULL,
  `billaddr_city_isprivate` bit(1) DEFAULT NULL,
  `billaddr_region_id` int(11) DEFAULT NULL,
  `billaddr_region_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `billaddr_state_id` int(11) DEFAULT NULL,
  `billaddr_state_ispublic` bit(1) DEFAULT NULL,
  `billaddr_country_code` char(2) DEFAULT NULL,
  `billaddr_zipcode` varchar(20) DEFAULT NULL,
  `geoaddr_issame` bit(1) NOT NULL DEFAULT b'1',
  `geoaddr_street1` varchar(100) DEFAULT NULL,
  `geoaddr_street2` varchar(100) DEFAULT NULL,
  `geoaddr_city_id` int(11) DEFAULT NULL,
  `geoaddr_city_isprivate` bit(1) DEFAULT NULL,
  `geoaddr_state_id` int(11) DEFAULT NULL,
  `geoaddr_state_ispublic` bit(1) DEFAULT NULL,
  `geoaddr_region_id` int(11) DEFAULT NULL,
  `geoaddr_region_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `geoaddr_zipcode` varchar(20) DEFAULT NULL,
  `geoaddr_country_code` char(2) DEFAULT NULL,
  `about_me` varchar(4000) DEFAULT NULL,
  `work_start_year` int(4) DEFAULT NULL,
  `prefereces_setting` varchar(2000) DEFAULT NULL,
  `timezone` varchar(20) NOT NULL,
  `startup_page` varchar(100) NOT NULL,
  `notify_by_sms` tinyint(4) NOT NULL DEFAULT 0,  
  `notify_by_email` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_chat` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_fb` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_tw` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_gplus` bit(1) NOT NULL DEFAULT 1,
  `credit_account_setting` varchar(2000) DEFAULT NULL,
  `task_last_post_at` datetime DEFAULT NULL,
  `task_post_cnt` int(11) DEFAULT '0',
  `task_post_total_price` int(11) DEFAULT '0',
  `task_post_total_hours` int(11) DEFAULT '0',
  `task_post_cancel_cnt` int(11) DEFAULT '0',
  `task_post_cancel_price` int(11) DEFAULT '0',
  `task_post_cancel_hours` int(11) DEFAULT '0',
  `task_post_rank` int(11) DEFAULT '0',
  `task_post_review_cnt` int(11) DEFAULT '0',
  `task_last_done_at` datetime DEFAULT NULL,
  `task_done_cnt` int(11) DEFAULT '0',
  `task_pending_cnt` int(11) DEFAULT '0',
  `task_done_total_price` int(11) DEFAULT '0',
  `task_done_total_hours` int(11) DEFAULT '0',
  `task_done_rank` int(11) DEFAULT '0',
  `task_done_review_cnt` int(11) DEFAULT '0',
  `connections_cnt` int(11) DEFAULT '0',
  `references_cnt` int(11) DEFAULT '0',
  `group_cnt` int(11) DEFAULT '0',
  `fb_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `tw_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `gplus_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `in_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `social_sites_auth_dtl` varchar(2000) NOT NULL DEFAULT b'1',    
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `last_accessed_at` timestamp NULL DEFAULT NULL,
  `status` char(1) default 'a',
  `profile_folder_name` vachar(20) NOT NULL
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_dtauser_countrycode` FOREIGN KEY (`country_code`) REFERENCES `gc_mst_country` (`country_code`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauser_stateid` FOREIGN KEY (`state_id`) REFERENCES `gc_mst_state` (`state_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauser_regionid` FOREIGN KEY (`region_id`) REFERENCES `gc_mst_region` (`region_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauser_cityid` FOREIGN KEY (`city_id`) REFERENCES `gc_mst_city` (`city_id`) ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

  CREATE INDEX gc_dta_user_contact_idx1 on gc_dta_user(state_id);
  CREATE INDEX gc_dta_user_contact_idx2 on gc_dta_user(city_id);
  CREATE INDEX gc_dta_user_contact_idx3 on gc_dta_user(region_id);
  CREATE INDEX gc_dta_user_contact_codex4 on gc_dta_user(country_code);
  
  CREATE TABLE IF NOT EXISTS `gc_dta_user_contact`(
    `contact_id` varchar(250),
    `contact_type` char(1) DEFAULT NULL,
    `user_id` bigint(20) NOT NULL,
    `is_primary` bigint(20) NOT NULL,
    `is_login_allowed` bit(1) NOT NULL DEFAULT b'1',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_updated_at` timestamp NULL DEFAULT NULL,
    `status` char(1) default 'a',
     PRIMARY KEY (`contact_id`),
     CONSTRAINT `fk_dtausercontact_userid` FOREIGN KEY (`user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  CREATE INDEX gc_dta_user_contact_idx1 on gc_dta_user_contact(user_id);
    
  #Q: Need to ckeck, how tasker and job search will be required. Region wise, city wise or all 
  #Q: Is Language is useful in search? I do not think so
  #Q: There is no need to maintain area wise specialities
  #Need to sync location data in this table on change in gc_dta_user. 
  CREATE TABLE IF NOT EXISTS `gc_dta_user_speciality` (
  `user_id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `country_code` char(2) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) default 'a',
  PRIMARY KEY (`user_id`,`category_id`),
  CONSTRAINT `fk_dtauserspeciality_userid` FOREIGN KEY (`user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauserspeciality_categoryid` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauserspeciality_countrycode` FOREIGN KEY (`country_code`) REFERENCES `gc_mst_country` (`country_code`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauserspeciality_stateid` FOREIGN KEY (`state_id`) REFERENCES `gc_mst_state` (`state_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauserspeciality_regionid` FOREIGN KEY (`region_id`) REFERENCES `gc_mst_region` (`region_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dtauserspeciality_cityid` FOREIGN KEY (`city_id`) REFERENCES `gc_mst_city` (`city_id`) ON UPDATE CASCADE
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
  CREATE INDEX gc_dta_user_speciality_idx1 on gc_dta_user_speciality(state_id);
  CREATE INDEX gc_dta_user_speciality_idx2 on gc_dta_user_speciality(city_id);
  CREATE INDEX gc_dta_user_speciality_idx3 on gc_dta_user_speciality(region_id);
  CREATE INDEX gc_dta_user_speciality_idx4 on gc_dta_user_speciality(country_code);
   
  #Note: Only additinal email and phone numbers should be added in to get verified.
  #Once record is verified, entry should be moved into gc_dta_user_contact table and record can be deleted from this table
  #To validate a contact, email and phone users can be sent a validation code, on entry that code, contact is treated validated
  CREATE TABLE IF NOT EXISTS `gc_dta_user_contact_pending` (
    `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
    `contact_id` varchar(250),
    `contact_type` char(1) DEFAULT NULL,
    `user_id` bigint(20) NOT NULL,
    `is_primary` bigint(20) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_updated_at` timestamp NULL DEFAULT NULL,
    `status` char(1) default 'a',
     PRIMARY KEY (`tran_id`),
     CONSTRAINT `fk_dtausercontactpending_userid` FOREIGN KEY (`user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  CREATE INDEX gc_dta_user_contact_pending_idx1 on gc_dta_user_contact_pending(contact_id);