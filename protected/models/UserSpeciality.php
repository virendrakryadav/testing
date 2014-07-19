<?php

/**
 * This is the model class for table "{{dta_user_speciality}}".
 *
 * The followings are the available columns in table '{{dta_user_speciality}}':
 * @property string $user_id
 * @property integer $skill_id
 * @property string $country_code
 * @property integer $state_id
 * @property integer $region_id
 * @property integer $city_id
 * @property string $created_at
 * @property string $status
 */
class UserSpeciality extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_speciality}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('user_id, category_id, created_at', 'required'),
			array('category_id, state_id, region_id, city_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			array('country_code', 'length', 'max'=>2),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, category_id, country_code, state_id, region_id, city_id, created_at, status', 'safe', 'on'=>'search'),*/
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
                    'skill' => array(self::BELONGS_TO, 'Skill', Globals::FLD_NAME_SKILL_ID),
                    'skilllocale' => array(self::BELONGS_TO, 'SkillLocale', array(Globals::FLD_NAME_SKILL_ID => Globals::FLD_NAME_SKILL_ID), 'through'=>'skill'),
		);
	}
    /*    public function getSkills($id)
	{
                $skillsArray = "";
                $criteria=new CDbCriteria;
                $criteria->compare('t.user_id',$id);
                $skills = self::model()->with("category","categorylocale")->findAll($criteria);
                if(!empty($skills))
                {
                    foreach ($skills  as $skill)
                    {
                        $skillsArray[] = $skill->categorylocale['category_name'];
                    }                                        
                }
                    return $skillsArray;
        }
   */
   public function getSkills($id)
	{
                $skillsArray = "";
                $criteria=new CDbCriteria;
                $criteria->compare('skilllocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                $criteria->compare('t.user_id',$id);
                $skills = self::model()->with("skill","skilllocale")->findAll($criteria);
                if(!empty($skills))
                {
                    foreach ($skills  as $skill)
                    {
                        $skillsArray[] = $skill->skilllocale['skill_desc'];
                    }                                        
                }
                return $skillsArray;
        }
      
        public function getUserSkills($user_id)
	{  
        
            $criteria = new CDbCriteria();
             $criteria->compare("skilllocale.".Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
            $criteria->compare("t.".Globals::FLD_NAME_USER_ID,$user_id);
           $criteria->order = " skilllocale.".Globals::FLD_NAME_SKILL_DESC." ASC"; 
            $skills = UserSpeciality::model()->with('skilllocale')->findAll($criteria);
//            echo '<pre>';
//            print_r($skills);exit;
            return $skills;
                        
        }
		
        public function getUsersBySkills($task_skills)
        {
            $criteria=new CDbCriteria;

            foreach($task_skills as $taskSkill)
            {
             
                    $criteria->compare('t.'.Globals::FLD_NAME_SKILL_ID,$taskSkill->{Globals::FLD_NAME_SKILL_ID},false,'OR');
            }

            //print_r($criteria);exit;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        public function getTaskersBySkils($skills)
        {
            $criteria=new CDbCriteria;
            $criteria->addInCondition('t.'.Globals::FLD_NAME_SKILL_ID,$skills);
            
            $users = UserSpeciality::model()->findAll($criteria);
            return $users ;
           
        }
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('label_model', 'lbl_user_id'),
			'skill_id' => Yii::t('label_model', 'lbl_skill_id'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'state_id' => Yii::t('label_model', 'lbl_state_id'),
			'region_id' => Yii::t('label_model', 'lbl_region_id'),
			'city_id' => Yii::t('label_model', 'lbl_city_id'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'status' => Yii::t('label_model', 'lbl_status'),
		);
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

		$criteria->compare(Globals::FLD_NAME_USER_ID,$this->{Globals::FLD_NAME_USER_ID},true);
		$criteria->compare(Globals::FLD_NAME_SKILL_ID,$this->{Globals::FLD_NAME_SKILL_ID});
		$criteria->compare(Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE},true);
		$criteria->compare(Globals::FLD_NAME_STATE_ID,$this->{Globals::FLD_NAME_STATE_ID});
		$criteria->compare(Globals::FLD_NAME_REGION_ID,$this->{Globals::FLD_NAME_REGION_ID});
		$criteria->compare(Globals::FLD_NAME_CITY_ID,$this->{Globals::FLD_NAME_CITY_ID});
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserSpeciality the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
