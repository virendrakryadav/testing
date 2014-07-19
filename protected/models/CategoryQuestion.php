<?php

/**
 * This is the model class for table "{{mst_category_question}}".
 *
 * The followings are the available columns in table '{{mst_category_question}}':
 * @property string $question_id
 * @property integer $category_id
 * @property string $question_type
 * @property string $question_for
 * @property integer $is_answer_must
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class CategoryQuestion extends CActiveRecord
{
    public $question_desc;
    public $category_id;
    public $question_type;
    public $question_for;
    public $language_code;
    public $category_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_category_question}}';
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
//			array('question_type, question_for', 'length', 'max'=>1),
//			array('updated_at', 'safe'),
//			// The following rule is used by search().
//			// @todo Please remove those attributes that should not be searched.
			array('question_desc', 'safe', 'on'=>'search'),
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
			'categoryquestionlocale' => array(self::HAS_ONE, 'CategoryQuestionLocale',Globals::FLD_NAME_QUESTION_ID),
			//'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', 'category_id','through'=>'categoryquestionlocale'),
                        'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', array(Globals::FLD_NAME_CATEGORY_ID => Globals::FLD_NAME_CATEGORY_ID), 'through'=>'categoryquestionlocale'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
//			'question_id' => 'Question',
//			'category_id' => 'Category',
//			'question_type' => 'Question Type',
//			'question_for' => 'Question For',
//			'is_answer_must' => 'Is Answer Must',
//			'created_at' => 'Created At',
//			'created_by' => 'Created By',
//			'updated_at' => 'Updated At',
//			'updated_by' => 'Updated By',
		);
	}
         public function getQuestionsOfCategory($id)
	{  
        
            $criteria = new CDbCriteria();
//            $criteria->condition = "categoryquestionlocale.language_code =:language";
            $criteria->condition = "categoryquestionlocale.".Globals::FLD_NAME_CATEGORY_ID." ='".$id."'";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $questions = CategoryQuestion::model()->with('categoryquestionlocale')->findAll($criteria);
            
            return $questions;
                        
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
                $criteria->with = array('categoryquestionlocale','categorylocale');
		

                if(isset($this->{Globals::FLD_NAME_LANGUAGE_CODE}))
                {
                    $criteria->compare('categoryquestionlocale.language_code',$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('categorylocale.language_code',$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                }
                else
                {
                    $criteria->compare('categoryquestionlocale.language_code',Yii::app()->user->getState('language'));
                    $criteria->compare('categorylocale.language_code',Yii::app()->user->getState('language'));
                }

                $criteria->compare('t.question_id',$this->{Globals::FLD_NAME_QUESTION_ID});
		$criteria->compare('categoryquestionlocale.question_desc',$this->{Globals::FLD_NAME_QUESTION_DESC},true);
                $criteria->compare('categoryquestionlocale.category_id',$this->{Globals::FLD_NAME_CATEGORY_ID},true);
		$criteria->compare('categoryquestionlocale.question_type',$this->{Globals::FLD_NAME_QUESTION_TYPE},true);
		$criteria->compare('categoryquestionlocale.question_for',$this->{Globals::FLD_NAME_QUESTION_FOR},true);
//		$criteria->compare('categoryquestionlocale.is_answer_must',$this->is_answer_must);
//		$criteria->compare('categoryquestionlocale.created_at',$this->created_at,true);
//		$criteria->compare('categoryquestionlocale.created_by',$this->created_by);
//		$criteria->compare('categoryquestionlocale.updated_at',$this->updated_at,true);
//		$criteria->compare('categoryquestionlocale.updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('categoryQuestionDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                    'sort'=>array(
                                    'attributes'=>array(
                                    'question_desc'=>array(
                                                            'asc'=>'categoryquestionlocale.'.Globals::FLD_NAME_QUESTION_DESC,
                                                            'desc'=>'categoryquestionlocale.'.Globals::FLD_NAME_QUESTION_DESC.' DESC',
                                                            ),
                                    'category_name'=>array(
                                                            'asc'=>'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME,
                                                            'desc'=>'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME.' DESC',
                                                            ),            
                                                            '*',
                                            ),
                                  //'defaultOrder'=>'categoryquestionlocale.'.Globals::FLD_NAME_QUESTION_DESC.' ASC',
                                  'defaultOrder'=>'categorylocale.'.Globals::FLD_NAME_CATEGORY_NAME.' ASC',
                        ),
                    
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
