<?php

/**
 * This is the model class for table "{{dta_task_skill}}".
 *
 * The followings are the available columns in table '{{dta_task_skill}}':
 * @property integer $skill_id
 * @property string $task_id
 */
class TaskSkill extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_skill}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task_id', 'required'),
			array('task_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('skill_id, task_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                     'skilllocale' => array(self::BELONGS_TO, 'SkillLocale', Globals::FLD_NAME_SKILL_ID),
                    'task' => array(self::BELONGS_TO, 'Task', Globals::FLD_NAME_TASK_ID),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skill_id' => Yii::t('label_model', 'lbl_skill_id'),
			'task_id' => Yii::t('label_model', 'lbl_task_id'),
		);
	}
        public function getTaskSkills($task_id , $select = '' )
	{  
        
            $criteria = new CDbCriteria();
            if( $select )
            {
                   $criteria->select = $select;
            }
         
            $criteria->condition = "skilllocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->condition = "t.".Globals::FLD_NAME_TASK_ID." ='".$task_id."'";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $skills = TaskSkill::model()->with('skilllocale')->findAll($criteria);
            //print_r($skills);
            return $skills;
                        
        }
        public function getTaskIdsBySkills($skills , $user_id = '' )
	{  
            $criteria = new CDbCriteria();
            $criteria->addInCondition( "t.".Globals::FLD_NAME_SKILL_ID , $skills );
            if($user_id)
            {
                $criteria->compare( "task.".Globals::FLD_NAME_CREATER_USER_ID, $user_id );
            }
            $skillsArr = TaskSkill::model()->with('task')->findAll($criteria);
            return $skillsArr;
        }
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare(Globals::FLD_NAME_SKILL_ID,$this->{Globals::FLD_NAME_SKILL_ID});
		$criteria->compare(Globals::FLD_NAME_TASK_ID,$this->{Globals::FLD_NAME_TASK_ID},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskSkill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
