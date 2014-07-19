<?php

/**
 * This is the model class for table "{{mst_category_locale}}".
 *
 * The followings are the available columns in table '{{mst_category_locale}}':
 * @property integer $category_id
 * @property integer $parent_id
 * @property string $language_code
 * @property string $category_name
 * @property string $category_image
 * @property string $category_desc
 * @property integer $category_status
 * @property integer $category_priority
 * @property string $create_timestamp
 * @property integer $created_by
 * @property string $update_timestamp
 * @property integer $updated_by
 */
class CategoryLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

         public $title;
        public $description;
	public function tableName()
	{
		return '{{mst_category_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_name, category_status, category_priority', 'required'),
			array('category_id, parent_id, category_status, category_priority, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('language_code', 'length', 'max'=>5),
			array('category_name', 'length', 'max'=>100),
                        array('category_name', 'unique'),

                        array('category_priority', 'numerical', 'min'=>1),
                        //array('parent_id','isChildCategory'),
                    
                        array('category_name', 'filter', 'filter'=>array( $this, 'filterPostalCode' )),
			array('category_image', 'length', 'max'=>500),
			array('category_desc', 'length', 'max'=>1000),
			array('update_timestamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('category_id, parent_id, language_code, category_name, category_image, category_desc, category_status, category_priority, create_timestamp, created_by, update_timestamp, updated_by', 'safe', 'on'=>'search'),
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
                    'category' => array(self::BELONGS_TO, 'Category',Globals::FLD_NAME_CATEGORY_ID),
                    'parentName' => array(self::BELONGS_TO, 'CategoryLocale', array(Globals::FLD_NAME_CATEGORY_PARENT_ID => Globals::FLD_NAME_CATEGORY_ID)),
		);
	}
        public function filterPostalCode($stringToTrim)
	{
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return $stringToTrim;
	}
        public function isChildCategory($attribute,$params)
	{
             $category = $this->category_id;
             $parent = $this->parent_id;
//           
            $criteria = new CDbCriteria;
            $criteria->addCondition('categorylocale.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' = "'.$category.'"');
            $criteria->addCondition('categorylocale.'.Globals::FLD_NAME_CATEGORY_ID.' = "'.$parent.'"');
            $cat_arr = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            if($cat_arr)
            {
                $this->addError($attribute, 'This category is child of '.$this->{Globals::FLD_NAME_CATEGORY_NAME}.' (Not Allowed).');
            }
            
            
          

	}
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => Yii::t('label_model', 'lbl_category'),
			'parent_id' => Yii::t('label_model', 'lbl_category_parent_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'category_name' => Yii::t('label_model', 'lbl_category_name'),
			'category_image' => Yii::t('label_model', 'lbl_category_image'),
			'category_desc' => Yii::t('label_model', 'lbl_category_desc'),
			'category_status' => Yii::t('label_model', 'lbl_category_status'),
			'category_priority' => Yii::t('label_model', 'lbl_category_priority'),
			'create_timestamp' => Yii::t('label_model', 'lbl_create_timestamp'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'update_timestamp' => Yii::t('label_model', 'lbl_update_timestamp'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
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
                $criteria->with = array( 'category' );
		$criteria->compare(Globals::FLD_NAME_CATEGORY_ID,$this->{Globals::FLD_NAME_CATEGORY_ID});
		$criteria->compare(Globals::FLD_NAME_CATEGORY_PARENT_ID,$this->{Globals::FLD_NAME_CATEGORY_PARENT_ID});
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_CATEGORY_NAME,$this->{Globals::FLD_NAME_CATEGORY_NAME},true);
		$criteria->compare(Globals::FLD_NAME_CATEGORY_IMAGE,$this->{Globals::FLD_NAME_CATEGORY_IMAGE},true);
		$criteria->compare(Globals::FLD_NAME_CATEGORY_DESC,$this->{Globals::FLD_NAME_CATEGORY_DESC},true);
		$criteria->compare(Globals::FLD_NAME_CATEGORY_STATUS,$this->{Globals::FLD_NAME_CATEGORY_STATUS});
		$criteria->compare(Globals::FLD_NAME_CATEGORY_PRIORITY,$this->{Globals::FLD_NAME_CATEGORY_PRIORITY});
		$criteria->compare(Globals::FLD_NAME_CREATE_TIMESTAMP,$this->{Globals::FLD_NAME_CREATE_TIMESTAMP},true);
		$criteria->compare(Globals::FLD_NAME_CREATE_BY,$this->{Globals::FLD_NAME_CREATE_BY});
		$criteria->compare(Globals::FLD_NAME_UPDATE_TIMESTAMP,$this->{Globals::FLD_NAME_UPDATE_TIMESTAMP},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
