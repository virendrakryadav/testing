<?php

/**
 * This is the model class for table "{{mst_rating}}".
 *
 * The followings are the available columns in table '{{mst_rating}}':
 * @property integer $rating_id
 * @property string $rating_for
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
class Rating extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
//        public $maxPriority;
//        public $rating_priority;
    public $rating_desc;
    public $rating_for;
    
	public function tableName()
	{
		return '{{mst_rating}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rating_for', 'required'),
			array('rating_for, status', 'length', 'max'=>1),
			array('created_by, updated_by', 'length', 'max'=>20),
			array('source_app', 'length', 'max'=>10),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
			array('updated_at', 'safe'),
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
			'ratinglocale' => array(self::BELONGS_TO, 'RatingLocale', Globals::FLD_NAME_RATING_ID),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rating_id' => Yii::t('label_model', 'lbl_rating_id'),
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
                $criteria->with = array( 'ratinglocale' );
                $criteria->compare('t.'.Globals::FLD_NAME_RATING_ID,$this->{Globals::FLD_NAME_RATING_ID},true);
                if(isset($_GET[Globals::FLD_NAME_RATING_UCFIRST][Globals::FLD_NAME_RATING_FOR]))
                {
                    $criteria->compare('t.'.Globals::FLD_NAME_RATING_FOR,$_GET[Globals::FLD_NAME_RATING_UCFIRST][Globals::FLD_NAME_RATING_FOR]);
                }
                if(isset($_GET[Globals::FLD_NAME_RATING_UCFIRST][Globals::FLD_NAME_STATUS]))
                {
                    $criteria->compare('ratinglocale.'.Globals::FLD_NAME_STATUS,$_GET[Globals::FLD_NAME_RATING_UCFIRST][Globals::FLD_NAME_STATUS]);
                }
//		$criteria->compare('t'.Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
//		$criteria->compare('t'.Globals::FLD_NAME_CREATED_BY,$this->{Globals::FLD_NAME_CREATED_BY},true);
//		$criteria->compare('t'.Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);
//		$criteria->compare('t'.Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY},true);
                if(isset($_GET[Globals::FLD_NAME_RATING_UCFIRST][Globals::FLD_NAME_RATING_DESC]))
                {
                    $criteria->compare('ratinglocale.'.Globals::FLD_NAME_RATING_DESC,$_GET[Globals::FLD_NAME_RATING_UCFIRST][Globals::FLD_NAME_RATING_DESC]);
                }
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=> array(
                                        'pageSize'=>Yii::app()->user->getState('ratingDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                        'sort'=>array(
                                            'attributes'=>array(
                                            'rating_desc'=>array(
                                                            'asc'=>'ratinglocale.'.Globals::FLD_NAME_RATING_DESC,
                                                            'desc'=>'ratinglocale.'.Globals::FLD_NAME_RATING_DESC.' DESC',
                                                            ),
                                            'rating_priority'=>array(
                                                            'asc'=>'ratinglocale.'.Globals::FLD_NAME_RATING_PRIORITY,
                                                            'desc'=>'ratinglocale.'.Globals::FLD_NAME_RATING_PRIORITY.' DESC',
                                                            ),
                                                            '*',
                                            ),
                            ),                     
		));
	}
        public function getRatingList()
	{  
            $criteria = new CDbCriteria();
            $criteria->order = "t.rating_for";
            $rating = Rating::model()->findAll($criteria);
            
            return $rating;        
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
//        public function beforeValidate()
//	{
//		if (parent::beforeValidate()) {
//	
//			$validator = CValidator::createValidator('unique', $this, Globals::FLD_NAME_RATING_DESC, array(
//				'criteria' => array(
//					'condition'=>'rating_for=:rating_for',
//					'params'=>array(
//						':rating_for'=>$this->{Globals::FLD_NAME_RATING_FOR}
//					)
//				)
//			));
//			$this->getValidatorList()->insertAt(0, $validator); 
//			return true;
//		}
//		return false;
//	}
        
}
