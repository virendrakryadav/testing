alter table gc_dta_task 
  add column invited_cnt int (11) COMMENT 'Number of taskers inivited by the poster' default 0, 
  add column proposals_cnt int(11) COMMENT 'Number of proposal reveived for this task' default 0;

alter table gc_dta_task_tasker
  add column proposed_cost numeric(10,3) COMMENT 'Cost proposed by the tasker'  default 0,
  add column approved_cost numeric(10,3) COMMENT 'Cost approved by the poster'  default 0,
  add column approved_on datetime COMMENT 'Cost approved by the poster on';

create table gc_sum_day_log_last(
  day_log_last_id bigint(20) AUTO_INCREMENT,
  day_log_last_date date comment 'Summary upto which last date' NOT NULL ,

  country_code char(2) comment 'Task created for which country',
  region_id int(11) comment 'Task created for which region with in a country',
  category_id int (11) comment 'Task category',

  total_signup_cnt int (11) default 0 comment 'Total number of users registerd till date',
  total_signup_email_cnt int (11) default 0 comment 'Total number of users registerd using email till date',
  total_signup_phone_cnt int (11) default 0 comment 'Total number of users registerd using phone till date',
  total_signup_ref_cnt int (11) default 0 comment 'Total number of users registerd becasue of referral emails and promotions till date',

  total_signin_err int (11) default 0 comment 'Total number of users faced error on sign in till date',
  total_signin_cnt int (11) default 0 comment 'Total number of users signed in till date',
  total_signin_unique_cnt int (11) default 0 comment 'Total number of unique users signed in till date',
  total_signin_email_cnt int (11) default 0 comment 'Total number of users signedin using email till date',
  total_signin_phone_cnt int (11) default 0 comment 'Total number of users signedin using phone till date',

  total_signout_cnt int (11) default 0 comment 'Total number of users signed out till date',

  total_profile_verify_cnt int (11) default 0 comment 'Total number of profile contact ids (phone/email) are verified till date',
  total_profile_verify_pending_cnt int (11) default 0 comment 'Total number of profile contact ids verification till date',

  total_refcheck_done_cnt int (11) default 0 comment 'Total number of reference check verified till date',
  total_refcheck_pending_cnt int (11) default 0 comment 'Total number of reference check pending till date',

  total_forgot_pwd_cnt int (11) default 0 comment 'Total number of users used forgot pwd till date',
  total_forgot_pwd_unique_cnt int (11) default 0 comment 'Total number of unique users used forgot pwd till date',
  total_forgot_pwd_email_cnt int (11) default 0 comment 'Total number of users used forgot pwd using email till date',
  total_forgot_pwd_phone_cnt int (11) default 0 comment 'Total number of users used forgot pwd using email till date',

  total_task_post_duration int (11) default 0 comment 'Total duration of the tasks assigned under this category',
  total_task_post_price numeric(15,2) default 0 comment 'Total price of the tasks assigned under this category',
  total_task_post_cnt int (11) default 0 comment 'Total number of tasks done under this category',
  total_task_post_repeat_cnt int (11) default 0 comment 'Total number of tasks pasoted by old posters under this category',
  total_task_post_new_cnt int (11) default 0 comment 'Total number of tasks pasoted by a new poster under this category',
  total_task_post_cancel_cnt int (11) default 0 comment 'Total number of tasks cancelled under this category',

  total_task_invite_cnt int (11) default 0 comment 'Total number of taskers invited so far',
  total_task_invite_repeat_cnt int (11) default 0 comment 'Total number of taskers invited so far',
  total_task_invite_new_cnt int (11) default 0 comment 'Total number of taskers who were already invited so far',

  total_task_proposals_cnt int (11) default 0 comment 'Total number of taskers invited first time in the system',
  total_task_proposals_repeat_cnt int (11) default 0 comment 'Total number of proposals by tasker sucessive time',
  total_task_proposals_new_cnt int (11) default 0 comment 'Total number of proposals by a new tasker',

  total_task_assigned_cnt int (11) default 0 comment 'Total number of tasks assigned to taskers',
  total_task_assigned_repeat_cnt int (11) default 0 comment 'Total number of tasks are repeat assignment',
  total_task_assigned_new_cnt int (11) default 0 comment 'Total number of tasks are assigned to first time in the system',
  total_task_assigned_duration int (11) default 0 comment 'Total duration of the tasks assigned under this category',
  total_task_assigned_price numeric(15,2) default 0 comment 'Total price of the tasks assigned under this category',

  total_task_done_cnt int (11) default 0 comment 'Total number of tasks done under this category',
  total_task_done_duration int (11) default 0 comment 'Total duration of the tasks done under this category',
  total_task_done_price numeric(15,2) default 0 comment 'Total price of the task done under this category',
  total_task_done_price_avg numeric(15,2) default 0 comment 'Average price of the task done under this category',
  total_task_done_price_min numeric(15,2) default 0 comment 'Minimum price of the task done under this category',
  total_task_done_price_max numeric(15,2) default 0 comment 'Maximum price of the task done under this category',
  
  total_profile_view_cnt int (11) default 0 comment 'Total number of profiles viewed by others till date',
  total_profile_view_tasker_cnt int (11) default 0 comment 'Total number of profiles viewed of the taskers till date',
  total_profile_view_poster_cnt int (11) default 0 comment 'Total number of profiles viewed of the taskers till date',

  total_task_view_cnt int (11) default 0 comment 'Total number of tasks searched viewed till date',

  total_task_fwd_cnt int (11) default 0 comment 'Total number of tasks forwaded till date',

  total_email_sent int (11) default 0 comment 'Total number of email notifications sent till date',
  total_sms_sent int (11) default 0 comment 'Total number of sms notifications sent till date',
  total_pushnotification_sent int (11) default 0 comment 'Total number of push notifications to mobile apps sent till date',

  total_fb_connect_cnt bigint (20) default 0 comment 'Total number of connected users on Facebook till date',
  total_tw_connect_cnt bigint (20) default 0 comment 'Total number of connected users on Twitter till date',

  total_fb_task_share_cnt int (11) default 0 comment 'Total number of tasks shared on Facebook till date',
  total_tw_task_share_cnt int (11) default 0 comment 'Total number of tasks shared on Twitter till date',

  total_fb_profile_share_cnt int (11) default 0 comment 'Total number of profiles shared on Facebook till date',
  total_tw_profile_share_cnt int (11) default 0 comment 'Total number of profiles shared on Twitter till date',

  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP comment 'When this record was created',
  created_by bigint(20) comment 'Who created this record', 
  source_app varchar(10) comment 'From where this record was created',
  status char(1) default 'a',
  PRIMARY KEY (day_log_last_id)
 )ENGINE=MyISAM DEFAULT CHARSET=utf8 
Comment 'This table holds overall summary from various tables upto a date. Which provides base for next day summary generation into 
gc_sum_day_log table. This table holds one record groped over category_id/country_code/resigin_id, which is created first time if not exists, then updated on daily basis';


create index gc_sum_day_log_last_idx1 on gc_sum_day_log_last(category_id,country_code, region_id);


create table gc_sum_day_log(
  day_log_id bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'record id',
  day_log_date date NOT NULL comment 'Summary of which date',

  country_code char(2) comment 'Task created for which country',
  region_id int(11) comment 'Task created for which region with in a country',
  category_id int (11) comment 'Task category',

  total_signup_cnt int (11) default 0 comment 'Total number of users registerd till date',
  total_signup_email_cnt int (11) default 0 comment 'Total number of users registerd using email till date',
  total_signup_phone_cnt int (11) default 0 comment 'Total number of users registerd using phone till date',
  total_signup_ref_cnt int (11) default 0 comment 'Total number of users registerd becasue of referral emails and promotions till date',

  total_signin_err int (11) default 0 comment 'Total number of users faced error on sign in till date',
  total_signin_cnt int (11) default 0 comment 'Total number of users signed in till date',
  total_signin_unique_cnt int (11) default 0 comment 'Total number of unique users signed in till date',
  total_signin_email_cnt int (11) default 0 comment 'Total number of users signedin using email till date',
  total_signin_phone_cnt int (11) default 0 comment 'Total number of users signedin using phone till date',

  total_signout_cnt int (11) default 0 comment 'Total number of users signed out till date',

  total_profile_verify_cnt int (11) default 0 comment 'Total number of profile contact ids (phone/email) are verified till date',
  total_profile_verify_pending_cnt int (11) default 0 comment 'Total number of profile contact ids verification till date',

  total_refcheck_done_cnt int (11) default 0 comment 'Total number of reference check verified till date',
  total_refcheck_pending_cnt int (11) default 0 comment 'Total number of reference check pending till date',

  total_forgot_pwd_cnt int (11) default 0 comment 'Total number of users used forgot pwd till date',
  total_forgot_pwd_unique_cnt int (11) default 0 comment 'Total number of unique users used forgot pwd till date',
  total_forgot_pwd_email_cnt int (11) default 0 comment 'Total number of users used forgot pwd using email till date',
  total_forgot_pwd_phone_cnt int (11) default 0 comment 'Total number of users used forgot pwd using email till date',

  total_task_post_duration int (11) default 0 comment 'Total duration of the tasks assigned under this category',
  total_task_post_price numeric(15,2) default 0 comment 'Total price of the tasks assigned under this category',
  total_task_post_cnt int (11) default 0 comment 'Total number of tasks done under this category',
  total_task_post_repeat_cnt int (11) default 0 comment 'Total number of tasks pasoted by old posters under this category',
  total_task_post_new_cnt int (11) default 0 comment 'Total number of tasks pasoted by a new poster under this category',
  total_task_post_cancel_cnt int (11) default 0 comment 'Total number of tasks cancelled under this category',

  total_task_invite_cnt int (11) default 0 comment 'Total number of taskers invited so far',
  total_task_invite_repeat_cnt int (11) default 0 comment 'Total number of taskers invited so far',
  total_task_invite_new_cnt int (11) default 0 comment 'Total number of taskers who were already invited so far',

  total_task_proposals_cnt int (11) default 0 comment 'Total number of taskers invited first time in the system',
  total_task_proposals_repeat_cnt int (11) default 0 comment 'Total number of proposals by tasker sucessive time',
  total_task_proposals_new_cnt int (11) default 0 comment 'Total number of proposals by a new tasker',

  total_task_assigned_cnt int (11) default 0 comment 'Total number of tasks assigned to taskers',
  total_task_assigned_repeat_cnt int (11) default 0 comment 'Total number of tasks are repeat assignment',
  total_task_assigned_new_cnt int (11) default 0 comment 'Total number of tasks are assigned to first time in the system',
  total_task_assigned_duration int (11) default 0 comment 'Total duration of the tasks assigned under this category',
  total_task_assigned_price numeric(15,2) default 0 comment 'Total price of the tasks assigned under this category',

  total_task_done_cnt int (11) default 0 comment 'Total number of tasks done under this category',
  total_task_done_duration int (11) default 0 comment 'Total duration of the tasks done under this category',
  total_task_done_price numeric(15,2) default 0 comment 'Total price of the task done under this category',
  total_task_done_price_avg numeric(15,2) default 0 comment 'Average price of the task done under this category',
  total_task_done_price_min numeric(15,2) default 0 comment 'Minimum price of the task done under this category',
  total_task_done_price_max numeric(15,2) default 0 comment 'Maximum price of the task done under this category',
  
  total_profile_view_cnt int (11) default 0 comment 'Total number of profiles viewed by others till date',
  total_profile_view_tasker_cnt int (11) default 0 comment 'Total number of profiles viewed of the taskers till date',
  total_profile_view_poster_cnt int (11) default 0 comment 'Total number of profiles viewed of the taskers till date',

  total_task_view_cnt int (11) default 0 comment 'Total number of tasks searched viewed till date',

  total_task_fwd_cnt int (11) default 0 comment 'Total number of tasks forwaded till date',

  total_email_sent int (11) default 0 comment 'Total number of email notifications sent till date',
  total_sms_sent int (11) default 0 comment 'Total number of sms notifications sent till date',
  total_pushnotification_sent int (11) default 0 comment 'Total number of push notifications to mobile apps sent till date',

  total_fb_connect_cnt bigint (20) default 0 comment 'Total number of connected users on Facebook till date',
  total_tw_connect_cnt bigint (20) default 0 comment 'Total number of connected users on Twitter till date',

  total_fb_task_share_cnt int (11) default 0 comment 'Total number of tasks shared on Facebook till date',
  total_tw_task_share_cnt int (11) default 0 comment 'Total number of tasks shared on Twitter till date',

  total_fb_profile_share_cnt int (11) default 0 comment 'Total number of profiles shared on Facebook till date',
  total_tw_profile_share_cnt int (11) default 0 comment 'Total number of profiles shared on Twitter till date',

  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP comment 'When this record was created',
  created_by bigint(20) comment 'Who created this record', 
  source_app varchar(10) comment 'From where this record was created',
  status char(1) default 'a',
  PRIMARY KEY (day_log_id)
 )ENGINE=MyISAM DEFAULT CHARSET=utf8
Comment 'This table holds per day summary from various tables groped over category_id/country_code/resigin_id';


create index gc_sum_day_log_idx1 on gc_sum_day_log(day_log_date desc,category_id,country_code, region_id);
create index gc_sum_day_log_idx2 on gc_sum_day_log(category_id,country_code, region_id,day_log_date desc);



