<?php

/**
 * This is the model class for table "{{dat_task_category}}".
 *
 * The followings are the available columns in table '{{dat_task_category}}':
 * @property string $task_id
 * @property string $language_code
 * @property integer $category_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $status
 */
class TaskCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('task_id, language_code, category_id, created_at, created_by, updated_at, updated_by', 'required'),
			array('category_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('task_id', 'length', 'max'=>20),
			array('language_code', 'length', 'max'=>5),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('task_id, language_code, category_id, created_at, created_by, updated_at, updated_by, status', 'safe', 'on'=>'search'),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()')),
                        array('updated_by','default', 'value'=>Yii::app()->user->id)
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
                    'task' => array(self::BELONGS_TO, 'Task', Globals::FLD_NAME_TASK_ID),
                    'category' => array(self::BELONGS_TO, 'Category', array(Globals::FLD_NAME_CATEGORY_ID => Globals::FLD_NAME_CATEGORY_ID)),
                    'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', array(Globals::FLD_NAME_CATEGORY_ID => Globals::FLD_NAME_CATEGORY_ID), 'through'=>'category'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_id' => Yii::t('label_model', 'lbl_task_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'category_id' => Yii::t('label_model', 'lbl_category'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
			'status' => Yii::t('label_model', 'lbl_status'),
		);
	}
        public function getTaskCategoryName($id)
	{
		$criteria=new CDbCriteria;
                //$criteria->select = "categorylocale.category_name,category.parent_id";
		$criteria->compare(Globals::FLD_NAME_TASK_ID,$id);
		$criteria->compare('categorylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
		$categoryName = TaskCategory::model()->with('category','categorylocale')->findAll($criteria);
        //      print_r($categoryName);
        //      exit;
                return $categoryName;
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

		$criteria->compare(Globals::FLD_NAME_TASK_ID,$this->{Globals::FLD_NAME_TASK_ID},true);
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_CATEGORY_ID,$this->{Globals::FLD_NAME_CATEGORY_ID});
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_BY,$this->{Globals::FLD_NAME_CREATED_BY});
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
