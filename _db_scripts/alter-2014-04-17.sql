#should inbox message be against task_id only? Or Admin can send message to any user without task_id?
CREATE TABLE `gc_dta_inbox` (
   msg_id bigint(20) AUTO_INCREMENT NOT NULL,
  `msg_type` varchar(30) COMMENT 'key for message classification such as proposal, payment, terms, feedback etc., if required',
   task_id bigint(20) COMMENT 'Task for which this message is?',
  `from_user_id` bigint(20) DEFAULT NULL COMMENT 'inbox of which user?',
  `to_user_ids` varchar(2000) COMMENT 'Who all users should receive it? comma separated',
  `subject` varchar(200) COMMENT 'Message short desc',
  `body` text COMMENT 'Message details',
  `attachments` varchar(200) COMMENT 'comma separated list of upload files.',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a' COMMENT ' a= sent, s= saved as draft, d= means deleted, r= archived',
  PRIMARY KEY (`msg_id`),
  FULLTEXT (subject,body)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds task related messages exchanged between tasker and poster';

create index gc_dta_inbox_from_user_id_idx1 on gc_dta_inbox(from_user_id,task_id,status);
create index gc_dta_inbox_task_id_idx1 on gc_dta_inbox(task_id,status);

#Minimum two records are created in this table. One for sender and one for recipient
#Need to define Foriegn Key contraint with on DELETE casecade on msg_id, if required.
CREATE TABLE `gc_dta_inbox_user` (
  `user_id` bigint(20) DEFAULT NULL COMMENT 'inbox of which user?',
  `msg_flow` char(1) NOT NULL COMMENT 's= means sent r= means received',
  `msg_id` bigint(20) COMMENT 'reference to gc_dta_inbox.msg_id',
  `is_read` tinyint(4) DEFAULT 0 COMMENT 'Is message read by the user. Set default value 1 for msg_flow=s',  
  PRIMARY KEY (`user_id`,`msg_flow`,`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds sent and received messages related to a msg_id';

create index gc_dta_inbox_user_msg_id_idx1 on gc_dta_inbox_user(msg_id,user_id,msg_flow);


##database table doesnot support fulltext
`ALTER TABLE gc_dta_inbox DROP INDEX subject;`