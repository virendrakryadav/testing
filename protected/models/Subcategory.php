<?php

/**
 * This is the model class for table "{{subcategory}}".
 *
 * The followings are the available columns in table '{{subcategory}}':
 * @property integer $subcategory_id
 * @property string $subcategory_name
 * @property integer $category_id
 * @property integer $subcategory_priority
 * @property integer $subcategory_status
 * @property integer $subcategory_addedby
 * @property string $subcategory_addedon
 * @property string $subcategory_updateon
 * @property integer $subcategory_updatedby
 */
class Subcategory extends CActiveRecord
{
	public $maxPriority;
        public $subcategory_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_subcategory}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			array('category_id, subcategory_priority', 'required','on'=>'insert, update'),
			array('category_id, subcategory_priority, subcategory_status', 'numerical', 'integerOnly'=>true),
			array('subcategory_status', 'length', 'max'=>1),
			array('subcategory_priority', 'length', 'max'=>3),
			
			//array('subcategory_name', 'unique'),
//			array('subcategory_name', 'unique', 'criteria'=>array('condition'=>'category_id=:category_id','params'=>array(':category_id'=>$this->category_id))),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('subcategory_id, subcategory_name, category_id, subcategory_priority, subcategory_status, subcategory_addedon, subcategory_updateon', 'safe', 'on'=>'search'),

                        
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
                    'category' => array(self::BELONGS_TO, 'Category', Globals::FLD_NAME_CATEGORY_ID),
                    'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', Globals::FLD_NAME_CATEGORY_ID),
                    'subcategorylocale' => array(self::BELONGS_TO, 'SubcategoryLocale', Globals::FLD_NAME_SUB_CATEGORY_ID),
		);
	}

	
	
	public function beforeValidate()
	{
		if (parent::beforeValidate()) {
	
			$validator = CValidator::createValidator('unique', $this, Globals::FLD_NAME_SUB_CATEGORY_NAME, array(
				'criteria' => array(
					'condition'=>'category_id=:category_id',
					'params'=>array(
						':category_id'=>$this->{Globals::FLD_NAME_CATEGORY_ID}
					)
				)
			));
			$this->getValidatorList()->insertAt(0, $validator); 
	
			return true;
		}
		return false;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subcategory_id' => Yii::t('label_model', 'lbl_subcategory_id'),
			'subcategory_name' => Yii::t('label_model', 'lbl_subcategory_name'),
			'category_id' => Yii::t('label_model', 'lbl_category_id'),
			'subcategory_priority' => Yii::t('label_model', 'lbl_subcategory_priority'),
			'subcategory_status' => Yii::t('label_model', 'lbl_subcategory_status'),
			
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
                $criteria->with = array( 'category' , 'categorylocale' , 'subcategorylocale' );
                 
                $criteria->compare('subcategorylocale.'.Globals::FLD_NAME_LANGUAGE_ID,Yii::app()->user->getState('language'));
                $criteria->compare('categorylocale.'.Globals::FLD_NAME_LANGUAGE_ID,Yii::app()->user->getState('language'));
                
		$criteria->compare(Globals::FLD_NAME_SUB_CATEGORY_PRIORITY,$this->{Globals::FLD_NAME_SUB_CATEGORY_PRIORITY});
		$criteria->compare(Globals::FLD_NAME_SUB_CATEGORY_STATUS,$this->{Globals::FLD_NAME_SUB_CATEGORY_STATUS});
                $criteria->compare('subcategorylocale.'.Globals::FLD_NAME_SUB_CATEGORY_NAME,$this->{Globals::FLD_NAME_SUB_CATEGORY_NAME},true);
		$criteria->compare('t.'.Globals::FLD_NAME_CATEGORY_ID,$this->{Globals::FLD_NAME_CATEGORY_ID});
		

		return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>  array(
                                            'pageSize'=>Yii::app()->user->getState('subcategoryDataSession',Yii::app()->params['defaultPageSize'])
                                            ),
                            'sort'=>array(
                                            'attributes'=>array(
                                            'category_name'=>array(
                                                            'asc'=>'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME,
                                                            'desc'=>'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME.' DESC',
                                                            ),
                                            'subcategory_name'=>array(
                                                            'asc'=>'subcategorylocale.'.Globals::FLD_NAME_SUB_CATEGORY_NAME,
                                                            'desc'=>'subcategorylocale.'.Globals::FLD_NAME_SUB_CATEGORY_NAME.' DESC',
                                                            ),
                                                            '*',
                                            ),
                                
                             
                                
                                
                            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subcategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
