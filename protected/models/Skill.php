<?php

/**
 * This is the model class for table "{{mst_skill}}".
 *
 * The followings are the available columns in table '{{mst_skill}}':
 * @property integer $skill_id
 * @property integer $category_id
 */
class Skill extends CActiveRecord
{	
        public $skill_desc;
        public $category_id;
	public function tableName()
	{
		return '{{mst_skill_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id,skill_id', 'required'),
//                        array('category_id,skill_id', 'unique'),
                        array('category_id', 'UniqueAttributesValidator', 'with'=>'skill_id','message'=>'Category and skill already taken.'),
			//array('category_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('skill_desc', 'safe', 'on'=>'search'),
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
                    'categorylocale'=> array(self::BELONGS_TO, 'CategoryLocale', Globals::FLD_NAME_CATEGORY_ID),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skill_id' => Yii::t('label_model', 'lbl_skill_id'),
			'category_id' => Yii::t('label_model', 'lbl_category'),
		);
	}

   public static function getSkillsOfCategory($id)
	{  
        
         $criteria = new CDbCriteria();
         $criteria->condition = "skilllocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         $criteria->condition = "t.".Globals::FLD_NAME_CATEGORY_ID." ='".$id."'";
         $criteria->params = array(':language' => Yii::app()->user->getState('language') );
         $skills = Skill::model()->with('skilllocale')->findAll($criteria);
         //print_r($skill);
         if(!empty($skills))
         {
            return $skills;
         }else{
            return false;
         }            
   }
    
    
    public static function getSkills($options = null, $defaultLang = null)
    {
      $criteria = new CDbCriteria();
      
        if(!empty($options) && isset($options['id']))
        {
            $criteria->condition = "t.".Globals::FLD_NAME_SKILL_ID." ='".$id."'";
            $criteria->condition = "skilllocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->params = array(':language' => Yii::app()->user->getState('language'));
            $skills = Skill::model()->with('skilllocale')->findAll($criteria);
            return $skills;
        }
        else
        {
            if(CommonUtility::IsProfilingEnabled())
            {
                Yii::beginProfile('Skill.getSkills','Skill.getSkills');
            }
            $userLang = Yii::app()->user->getState('language');
            $skills = Yii::app()->cache->get(Globals::$cacheKeys['MST_GETSKILLS'].'_'.$userLang);     
        
            if($skills === false)
            {
                $criteria = new CDbCriteria();
                $criteria->condition = "skilllocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
                if(!empty($defaultLang))
                {
                $criteria->params = array(':language' => $defaultLang );
                }
                else
                {
                $criteria->params = array(':language' => Yii::app()->user->getState('language'));
                }


                $skills = Skill::model()->with('skilllocale')->findAll($criteria);
                Yii::app()->cache->set(Globals::$cacheKeys['MST_GETSKILLS'].'_'.$userLang, $skills);
            }
         
            if(empty($skills))
            {
                $defaultLang = GLOBALS::DEFAULT_LANGUAGE;
                $criteria = new CDbCriteria();
                $criteria->condition = "skilllocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
                $criteria->params = array(':language' => $defaultLang );
                $skills = Skill::model()->with('skilllocale')->findAll($criteria);
                Yii::app()->cache->set(Globals::$cacheKeys['MST_GETSKILLS'].'_'.$defaultLang, $skills);
            }
         
         if(CommonUtility::IsProfilingEnabled())
         {
            Yii::endProfile('Skill.getSkills');
         }
         return $skills;
      }
      
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

//		$criteria->compare('skill_id',$this->skill_id);
                $criteria->with = array('skilllocale','categorylocale');
		$criteria->compare('skilllocale.'.Globals::FLD_NAME_SKILL_DESC,$this->{Globals::FLD_NAME_SKILL_DESC},true);
                $criteria->compare('skilllocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>Yii::app()->user->getState('skillDataSession',Yii::app()->params['defaultPageSize'])
                            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Skill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
