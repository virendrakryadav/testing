<?php

/**
 * This is the model class for table "{{mst_skill_locale}}".
 *
 * The followings are the available columns in table '{{mst_skill_locale}}':
 * @property integer $skill_id
 * @property string $language_code
 * @property string $skill_desc
 */
class SkillLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $category_id;
        public $current;
	public function tableName()
	{
		return '{{mst_skill_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('skill_desc', 'required'),
			array('skill_id', 'numerical', 'integerOnly'=>true),
//                        array('skill_desc', 'UniqueAttributesValidator','with'=>'skill.category_id','through'=>'skill'),
//                        array('skill_desc', 'UniqueAttributesValidator', 'with'=>'category_id'),
//                        array('skill_desc, category_id', 'unique'),
//                        array('skill_desc', 'unique', 'criteria'=>array(
//                            'condition'=>'skill.category_id=skill.category_id',
//                            'params'=>array(
//                                ':category_id'=>$this->category_id
//                        ))),
         array('category_id', 'numerical', 'integerOnly'=>true),
         //array('skill_desc', 'UniqueAttributesValidator', 'with'=>'category_id'),
//         array('skill_desc', 'isDuplicateSkillInCategory'),
			array('language_code', 'length', 'max'=>5),
			array('skill_desc', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('skill_id, language_code, skill_desc', 'safe', 'on'=>'search'),
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
                                        
		);
	}
   
   
   public function isDuplicateSkillInCategory($attribute, $params){
       $catId = $_POST["Skill"]["category_id"];
       
       if(isset($_POST["SkillLocale"]["current"])){
         $current = $_POST["SkillLocale"]["current"];  
       }else{
         $current = null;
       }
       
      //echo $this->current;
      $criteria = new CDbCriteria();
      $criteria->select = 't.skill_desc';
      $criteria->condition = 'skill.category_id = "' . $catId . '"';
      $skillDesc = $this->skill_desc;
      
      $catIds = SkillLocale::model()->with("skill")->findAll($criteria);
      //$catIds = array(24);
      //print_r($catIds);
      //$catName = 'css-3';
      foreach($catIds as $val){
         //print_r();
         if(strtolower($current) != strtolower($skillDesc) && strtolower($skillDesc) === strtolower($val->skill_desc)){
            $labels = $this->attributeLabels();
            $this->addError($attribute, 'Duplicate Skill name under same category');
            break;
         }
      }
      
      //$skillId = $this->skill_id;
      
      //$a = array($catId, $skillId, $skillDesc);
      //print_r($attribute);
      //print_r($params);
      //print_r($a);
      
      //echo Skill::model()->category_id;
   }
   
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skill_id' => Yii::t('label_model', 'lbl_skill_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'skill_desc' => Yii::t('label_model', 'lbl_skill_desc'),
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

		$criteria->compare(Globals::FLD_NAME_SKILL_ID,$this->{Globals::FLD_NAME_SKILL_ID});
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_SKILL_DESC,$this->{Globals::FLD_NAME_SKILL_DESC},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SkillLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
