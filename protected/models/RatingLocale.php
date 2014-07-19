<?php

/**
 * This is the model class for table "{{mst_rating}}".
 *
 * The followings are the available columns in table '{{mst_rating}}':
 * @property integer $rating_id
 * @property integer $language_code
 * @property string $rating_desc
 * @property string $rating_priority
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 * @property string $source_app
 * @property string $status
 *
 * The followings are the available model relations:
 * @property MstRatingLocale[] $mstRatingLocales
 */
class RatingLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $rating_for;
        public $expense;
        public $expense_reason;
        
	public function tableName()
	{
		return '{{mst_rating_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rating_desc, rating_priority ,expense , expense_reason', 'required'),
                        //array('rating_desc, rating_priority', 'required', 'on'=>'update'),
                        array('rating_priority,expense', 'numerical', 'min'=>1),
                        array('rating_desc', 'checkUniqueRating'),
                        //array('rating_desc', 'checkUniqueRating', 'with'=>'rating_for'),
			array('status', 'length', 'max'=>1),
			array('created_by, updated_by', 'length', 'max'=>20),
			array('source_app', 'length', 'max'=>10),
			array('updated_at', 'safe'),                        
                        array('rating_desc', 'filter', 'filter'=>'trim'),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rating_id, rating_for, created_at, created_by, updated_at, updated_by, source_app, status', 'safe', 'on'=>'search'),
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
			'rating' => array(self::BELONGS_TO, 'Rating', Globals::FLD_NAME_RATING_ID),
			'language_code' => array(self::BELONGS_TO, 'Language', Globals::FLD_NAME_LANGUAGE_CODE),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rating_id' => Yii::t('label_model', 'lbl_rating_id'),
                        'language_code' => Yii::t('label_model', 'lbl_language_code'),
                        'rating_desc' => Yii::t('label_model', 'lbl_rating_desc'),
                        'rating_priority' => Yii::t('label_model', 'lbl_rating_priority'),
			'rating_for' => Yii::t('label_model', 'lbl_rating_for'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
			'source_app' => Yii::t('label_model', 'lbl_source_app'),
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
                $criteria->compare(Globals::FLD_NAME_RATING_ID,$this->{Globals::FLD_NAME_RATING_ID});
                $criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
		$criteria->compare(Globals::FLD_NAME_RATING_DESC,$this->{Globals::FLD_NAME_RATING_DESC},true);
                $criteria->compare(Globals::FLD_NAME_RATING_PRIORITY,$this->{Globals::FLD_NAME_RATING_PRIORITY},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_CREATE_BY,$this->{Globals::FLD_NAME_CREATE_BY},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY},true);
		$criteria->compare(Globals::FLD_NAME_SOURCE_APP,$this->{Globals::FLD_NAME_SOURCE_APP},true);
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function checkUniqueRating($attribute,$params)
	{                
            if(isset($_POST['Rating']['rating_for']) && isset($_POST['RatingLocale']['rating_desc']))
            {
                $criteria = new CDbCriteria();
                $criteria->with = array('rating');
//                $criteria->condition='rating.rating_for = "'.$_POST['Rating']['rating_for'].'"'; 
//                $criteria->condition='t.rating_desc = "'.$_POST['RatingLocale']['rating_desc'].'"';  
                $criteria->addCondition('rating.rating_for ="'.$_POST['Rating']['rating_for'].'"');
                $criteria->addCondition('t.rating_desc ="'.$_POST['RatingLocale']['rating_desc'].'"');
                $questions = RatingLocale::model()->findAll($criteria);                
                $ratingcount = count($questions);                
                if($ratingcount>0)
                {
                    $this->addError($attribute, 'Rating Description "'.$_POST['RatingLocale']['rating_desc'].'" has already been taken.');
                }
            }
         }
        
         public function getRatingForPoster()
         {
            $criteria = new CDbCriteria();
            $criteria->with = array('rating');
            $criteria->addCondition('rating.'.Globals::FLD_NAME_RATING_FOR.' = "'.Globals::FLD_NAME_POSTER_RATING_ALFABET.'"');
            $criteria->addCondition('t.'.Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
                ));
         }
         
         public function getRatingForDoer()
         {
            $criteria = new CDbCriteria();
            $criteria->with = array('rating');
            $criteria->addCondition('rating.'.Globals::FLD_NAME_RATING_FOR.' = "'.Globals::FLD_NAME_TASKER_RATING_ALFABET.'"');
            $criteria->addCondition('t.'.Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
                ));
         }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rating the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

