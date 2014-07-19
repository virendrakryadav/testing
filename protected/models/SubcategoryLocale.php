<?php

/**
 * This is the model class for table "{{mst_subcategory_locale}}".
 *
 * The followings are the available columns in table '{{mst_subcategory_locale}}':
 * @property integer $subcategory_id
 * @property integer $language_id
 * @property string $subcategory_name
 * @property string $create_timestamp
 * @property integer $created_by
 * @property string $update_timestamp
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property MstSubcategory $subcategory
 */
class SubcategoryLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_subcategory_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subcategory_name', 'required','on'=>'insert, update'),
                        array('subcategory_name', 'filter', 'filter'=>array( $this, 'filterPostalCode' )),
			array('subcategory_id, language_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
                        array('subcategory_name', 'length', 'max'=>100,  'min'=>2),
                        array('subcategory_name', 'uniquesubcategory','on'=>'insert, update'),
			array('update_timestamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('subcategory_id, language_id, subcategory_name, create_timestamp, created_by, update_timestamp, updated_by', 'safe', 'on'=>'search'),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_timestamp','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
                        array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update')
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
			'subcategory' => array(self::BELONGS_TO, 'Subcategory', Globals::FLD_NAME_SUB_CATEGORY_ID),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subcategory_id' => Yii::t('label_model', 'lbl_subcategory_id'),
			'language_id' => Yii::t('label_model', 'lbl_language_id'),
			'subcategory_name' => Yii::t('label_model', 'lbl_subcategory_name'),
			'create_timestamp' => Yii::t('label_model', 'lbl_create_timestamp'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'update_timestamp' => Yii::t('label_model', 'lbl_update_timestamp'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
		);
	}
        public function uniquesubcategory($attribute,$params)
	{
            $is_validate=1;
            if(!$this->isNewRecord)
            {
                $is_validate=0;
                $criteria = new CDbCriteria();
                        $criteria->addCondition('subcategorylocale.'.Globals::FLD_NAME_LANGUAGE_ID.'="'.Yii::app()->user->getState('language').'" ');
                        $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_ID.' ="'.$_REQUEST['Subcategory']["category_id"].'"');

                        $criteria->addCondition('subcategorylocale.'.Globals::FLD_NAME_SUB_CATEGORY_NAME.'  ="'.$this->{Globals::FLD_NAME_SUB_CATEGORY_NAME}.'"');
                          $criteria->addCondition('t.'.Globals::FLD_NAME_SUB_CATEGORY_ID.'  ="'. $_REQUEST['Subcategory']["subcategory_id"].'"');
                        $subCategoryValidate = Subcategory::model()->with('subcategorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_SUB_CATEGORY_PRIORITY));
              
                if (!$subCategoryValidate)
                {
                   $is_validate=1;
                } 
               
            }
            if ($is_validate==1)
                {
                    if(isset($_REQUEST['Subcategory']["category_id"]) && isset($this->{Globals::FLD_NAME_SUB_CATEGORY_NAME}))
                    {
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('subcategorylocale.'.Globals::FLD_NAME_LANGUAGE_ID.'="'.Yii::app()->user->getState('language').'" ');
                        $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_ID.' ="'.$_REQUEST['Subcategory']["category_id"].'"');

                        $criteria->addCondition('subcategorylocale.'.Globals::FLD_NAME_SUB_CATEGORY_NAME.'  ="'.$this->subcategory_name.'"');
                        $subCategory = Subcategory::model()->with('subcategorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_SUB_CATEGORY_PRIORITY));
                         if ($subCategory)
                        {
                            $this->addError($attribute, "Sub-Category Name ".$this->{Globals::FLD_NAME_SUB_CATEGORY_NAME}." already exist");
                        } 


                    }
            }
            return true;
	}
        //Validate after Trim
	public function filterPostalCode($stringToTrim)
	{
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return $stringToTrim;
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

		$criteria->compare(Globals::FLD_NAME_SUB_CATEGORY_ID,$this->{Globals::FLD_NAME_SUB_CATEGORY_ID});
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_ID,$this->{Globals::FLD_NAME_LANGUAGE_ID});
		$criteria->compare(Globals::FLD_NAME_SUB_CATEGORY_NAME,$this->{Globals::FLD_NAME_SUB_CATEGORY_NAME},true);
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
	 * @return SubcategoryLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
