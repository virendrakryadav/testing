<?php

/**
 * This is the model class for table "{{mst_category_skill}}".
 *
 * The followings are the available columns in table '{{mst_category_skill}}':
 * @property string $skill_id
 * @property integer $category_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class CategorySkill extends CActiveRecord
{
    public $skill_desc;
    public $category_id;
    public $language_code;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_skill}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('category_id, created_at, created_by, updated_by', 'required'),
//			array('category_id, is_answer_must, created_by, updated_by', 'numerical', 'integerOnly'=>true),
//			array('skill_type, skill_for', 'length', 'max'=>1),
//			array('updated_at', 'safe'),
//			// The following rule is used by search().
//			// @todo Please remove those attributes that should not be searched.
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
			'categoryskilllocale' => array(self::BELONGS_TO, 'CategorySkillLocale','skill_id'),
			//'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', 'category_id','through'=>'categoryskilllocale'),
                        'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', array('category_id' => 'category_id'), 'through'=>'categoryskilllocale'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
//			'skill_id' => 'Skill',
//			'category_id' => 'Category',
//			'created_at' => 'Created At',
//			'created_by' => 'Created By',
//			'updated_at' => 'Updated At',
//			'updated_by' => 'Updated By',
		);
	}
         public function getSkillsOfCategory($id)
	{  
        
            $criteria = new CDbCriteria();
            $criteria->condition = "categoryskilllocale.language_code =:language";
            $criteria->condition = "categoryskilllocale.category_id ='".$id."'";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $skills = CategorySkill::model()->with('categoryskilllocale')->findAll($criteria);
            
            return $skills;
                        
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
//                echo"<pre>";
//                print_r($_SERVER);
		$criteria=new CDbCriteria;
                $criteria->with = array('categoryskilllocale','categorylocale');
		

                if(isset($this->{Globals::FLD_NAME_LANGUAGE_CODE}))
                {
                    $criteria->compare('categoryskilllocale.language_code',$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('categorylocale.language_code',$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                }
                else
                {
                    $criteria->compare('categoryskilllocale.language_code',Yii::app()->user->getState('language'));
                    $criteria->compare('categorylocale.language_code',Yii::app()->user->getState('language'));
                }

                $criteria->compare('t.skill_id',$this->skill_id);
		$criteria->compare('categoryskilllocale.skill_desc',$this->skill_desc,true);
                $criteria->compare('categoryskilllocale.category_id',$this->category_id,true);
//		$criteria->compare('categoryskilllocale.created_at',$this->created_at,true);
//		$criteria->compare('categoryskilllocale.created_by',$this->created_by);
//		$criteria->compare('categoryskilllocale.updated_at',$this->updated_at,true);
//		$criteria->compare('categoryskilllocale.updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('categorySkillDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                    'sort'=>array(
                                    'attributes'=>array(
                                    'skill_desc'=>array(
                                                            'asc'=>'categoryskilllocale.skill_desc',
                                                            'desc'=>'categoryskilllocale.skill_desc DESC',
                                                            ),
                                                
                                                            '*',
                                            ),
                                  'defaultOrder'=>'categoryskilllocale.skill_desc ASC',
                        ),
                    
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategorySkill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
