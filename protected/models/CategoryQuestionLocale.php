<?php

/**
 * This is the model class for table "{{mst_category_question_locale}}".
 *
 * The followings are the available columns in table '{{mst_category_question_locale}}':
 * @property integer $category_id
 * @property string $language_code
 * @property string $question_id
 * @property string $question_desc
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $status
 */
class CategoryQuestionLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_category_question_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, question_desc', 'required'),
                        array('question_desc','unique'),
			array('category_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('language_code', 'length', 'max'=>5),
			array('question_id', 'length', 'max'=>20),
			array('question_desc', 'length', 'max'=>200),
			array('status', 'length', 'max'=>1),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('category_id, language_code, question_id, question_desc, created_at, created_by, updated_at, updated_by, status', 'safe', 'on'=>'search'),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
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
		'categoryQuestion' => array(self::HAS_MANY, 'CategoryQuestion', Globals::FLD_NAME_QUESTION_ID),
		'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', Globals::FLD_NAME_CATEGORY_ID),
                    'taskquestion' => array(self::HAS_MANY, 'TaskQuestion', Globals::FLD_NAME_QUESTION_ID),
//                'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', array('category_id' => 'category_id'), 'through'=>'categoryQuestion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => Yii::t('label_model', 'lbl_category'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'question_id' => Yii::t('label_model', 'lbl_question_id'),
			'question_desc' => Yii::t('label_model', 'lbl_question_desc'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
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

		$criteria->compare('category_id',$this->{Globals::FLD_NAME_CATEGORY_ID});
//		$criteria->compare('language_code',$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
//		$criteria->compare('question_id',$this->question_id,true);
//		$criteria->compare('question_desc',$this->question_desc,true);
//		$criteria->compare('created_at',$this->created_at,true);
//		$criteria->compare('created_by',$this->created_by);
//		$criteria->compare('updated_at',$this->updated_at,true);
//		$criteria->compare('updated_by',$this->updated_by);
//		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryQuestionLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
