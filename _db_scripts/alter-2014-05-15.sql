
CREATE TABLE IF NOT EXISTS `gc_mst_notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `applicable_for` char(1) NOT NULL COMMENT 'for t-tasker p-poster s-system type notificatios',
  `applicable_for_user_type` char(1) DEFAULT NULL COMMENT 'premium, basic',   
  `email_default` tinyint(1) DEFAULT 1 NOT NULL COMMENT 'Default value for email notification',  
  `sms_default` tinyint(1) DEFAULT 1 NOT NULL COMMENT 'Default value for SMS notification',  
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT 'Master list of notifications that can be sent for different events';

CREATE TABLE IF NOT EXISTS `gc_mst_notification_locale` (
  `notification_id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `description` varchar(200) NOT NULL COMMENT 'Notification desciption',
  `priority` int(11) DEFAULT NULL COMMENT 'Display order',
  `status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a-active d-deleted',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`language_code`,`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'Locale wise master list of notifications that can be sent for different event';

CREATE INDEX gc_mst_notification_locale_idx1 on gc_mst_notification_locale(notification_id);

CREATE TABLE IF NOT EXISTS `gc_dat_user_notification_pref` (
  `notification_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'Notification preference',  
  `send_email` tinyint(4) DEFAULT 1 COMMENT 'Send email for this type of notifocation',  
  `send_sms` tinyint(4) DEFAULT 1 COMMENT 'Send SMS for this type of notifocation',  
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`notification_id`,`user_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'User preferences about each notification';

CREATE INDEX gc_dat_user_notification_pref_idx1 on gc_dat_user_notification_pref(user_id,notification_id,send_email);
CREATE INDEX gc_dat_user_notification_pref_idx2 on gc_dat_user_notification_pref(user_id,notification_id,send_sms);
CREATE INDEX gc_dat_user_notification_pref_idx3 on gc_dat_user_notification_pref(notification_id,user_id);

CREATE TABLE `gc_dta_user_device` (
  `user_device_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `sim_serial_number` varchar(30) DEFAULT NULL,
  `device_mac_addr` varchar(200) DEFAULT NULL,
  `emei_meid_esn` varchar(20) DEFAULT NULL,
  `device_model` varchar(20) DEFAULT NULL,
  `device_density` varchar(20) DEFAULT NULL,
  `device_resolution` varchar(20) DEFAULT NULL,
  `os_type` char(1) NOT NULL COMMENT 'a-android, i-ios',
  `os_ver` varchar(20) DEFAULT NULL COMMENT 'os version like 4.2.0',
  `os_kernal_ver` varchar(20) DEFAULT NULL,
  `os_build_num` varchar(20) DEFAULT NULL,
  `sim_operator_nm` varchar(30) DEFAULT NULL COMMENT 'SIM operator name',
  `sim_operator` varchar(30) DEFAULT NULL COMMENT 'SIM operator MCCMNC',
  `sim_network_operator` varchar(30) DEFAULT NULL COMMENT 'SIM  network operator MNCMNC, where SIM is registered',
  `sim_country_iso` varchar(20) DEFAULT NULL COMMENT 'SIM  network operator MCCMNC, where SIM is registered (IN,US, UK)',
  `iv_client_ver` varchar(20) DEFAULT NULL COMMENT 'Client app version like <appname>_01.00.123',
  `country_code` char(3) DEFAULT NULL COMMENT 'SIM  country code',
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `cloud_key_to_notify` varchar(200) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  `remote_device_id` varchar(256) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Handset set device unique id',
  `last_fetched_msg_id` bigint(20) DEFAULT '0',
  `last_fetched_contact_trno` bigint(20) DEFAULT '0',
  `last_accessed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `last_fetched_msg_activity_id` bigint(20) DEFAULT '0',
  `last_fetched_profile_trno` bigint(20) DEFAULT '0',
  `is_pending_iv_join_pn` tinyint(4) DEFAULT '0',
  `first_iv_client_ver` varchar(20) DEFAULT NULL,
  `cloud_key_last_error` varchar(255) DEFAULT NULL COMMENT 'Handset app level cloud key for push notifications',
  `actions_required` varchar(500) DEFAULT NULL COMMENT 'Handset app need to executed these commands when active',
  `contact_id` varchar(200) DEFAULT NULL COMMENT 'contact id (phone/email) used for Sign In/Sign Up',
  `sim_network_operator_nm` varchar(30) DEFAULT NULL COMMENT 'SIM operator name where it is registered',
  `phone_num_edited` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`user_device_id`),
  UNIQUE KEY `user_id_1` (`user_id`,`remote_device_id`),
  KEY `iv_user_device_idx_device_id` (`remote_device_id`),
  CONSTRAINT `user_device_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `gc_dta_user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8 COMMENT 'This table hold each mobile devide details which is created on successful login from Mobile app';


