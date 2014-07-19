CREATE TABLE IF NOT EXISTS `gc_dta_blocked_ip` (
`blocked_ip_id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`ip_address` varchar( 40 ) NOT NULL COMMENT 'Blocked IP4 and IPv6 address, which can include wild char like 202.120.*',
`start_dt` timestamp COMMENT 'Blocking start period, null value means as soon record is created',
`end_dt` timestamp COMMENT 'Blocking end period, null value means for ever',
`reason` varchar( 2000 ) COMMENT 'Reason for blocking',
`status` char( 1 ) DEFAULT 'a' COMMENT 'a means in blocked state, d means unblocked/deleted, in case record cannot be deleted',
`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`created_by` bigint( 20 ) DEFAULT NULL ,
`update_at` timestamp NULL DEFAULT NULL ,
`updated_by` bigint( 20 ) DEFAULT NULL ,
PRIMARY KEY ( `blocked_ip_id` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 COMMENT 'List of blocked IP addresses. Read on this table is more frequent.'

CREATE INDEX gc_dta_blocked_ip_idx1 on gc_dta_blocked_ip(ip_address);

CREATE TABLE IF NOT EXISTS `gc_dat_user_notification_pref_catg` (
`notification_id` int( 11 ) NOT NULL ,
`category_id` int( 11 ) NOT NULL COMMENT 'Preferred category under that if any task is posted then notify. In case user selects top category only then all sub category items are added in this table',
`user_id` bigint( 20 ) NOT NULL COMMENT 'Notification preference',
`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`created_by` bigint( 20 ) DEFAULT NULL ,
`update_at` timestamp NULL DEFAULT NULL ,
`updated_by` bigint( 20 ) DEFAULT NULL ,
PRIMARY KEY ( `notification_id` , `category_id` , `user_id` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT 'User preferences about each task category level preference';

CREATE INDEX gc_dat_user_notification_pref_catg_idx1 on gc_dat_user_notification_pref_catg(user_id,notification_id, category_id);

CREATE TABLE IF NOT EXISTS `gc_dat_user_notification_pref_skill` (
`notification_id` int( 11 ) NOT NULL ,
`skill_id` int( 11 ) NOT NULL COMMENT 'Preferred skill under that if any task is posted then notify',
`user_id` bigint( 20 ) NOT NULL COMMENT 'Notification preference',
`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`created_by` bigint( 20 ) DEFAULT NULL ,
`update_at` timestamp NULL DEFAULT NULL ,
`updated_by` bigint( 20 ) DEFAULT NULL ,
PRIMARY KEY ( `notification_id` , `skill_id` , `user_id` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT 'User preferences about each task category level preference';

CREATE INDEX gc_dat_user_notification_pref_skill_idx1 on gc_dat_user_notification_pref_skill(user_id,notification_id,skill_id);
