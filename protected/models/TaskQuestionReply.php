<?php

/**
 * This is the model class for table "{{dta_task_question_reply}}".
 *
 * The followings are the available columns in table '{{dta_task_question_reply}}':
 * @property string $task_id
 * @property string $tasker_id
 * @property string $question_id
 * @property string $reply_desc
 * @property string $reply_yesno
 * @property string $created_at
 * @property string $updated_at
 * @property string $source_app
 */
class TaskQuestionReply extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_question_reply}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reply_desc', 'checkAllAnswers','on'=>'sendProposal'),
//                        array('reply_desc','type','type'=>'array','allowEmpty'=>false ,'on'=>'sendProposal'),
                      //  array('reply_desc[0],reply_desc[1],...,reply_desc[k]','required','on'=>'sendProposal'),
//			array('task_id, tasker_id, question_id', 'length', 'max'=>20),
//			array('reply_desc', 'length', 'max'=>2000),
//			array('reply_yesno', 'length', 'max'=>1),
//			array('source_app', 'length', 'max'=>10),
//			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('task_id, tasker_id, reply_desc, reply_yesno, created_at, updated_at, source_app', 'safe', 'on'=>'search'),
                  //  array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert,sendProposal'),
            array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update,sendProposal'),
                      //  array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update,sendProposal')
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_id' => Yii::t('label_model', 'lbl_task_id'),
			'tasker_id' => Yii::t('label_model', 'lbl_tasker_id'),
			//'question_id' => Yii::t('label_model', 'lbl_question_id'),
			'reply_desc' => Yii::t('label_model', 'lbl_reply_desc'),
			'reply_yesno' => Yii::t('label_model', 'lbl_reply_yesno'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
			'source_app' => Yii::t('label_model', 'lbl_source_app'),
		);
	}
   
   public function checkAllAnswers($attribute,$params)
	{
              if (isset($_POST[Globals::FLD_NAME_TASK_QUESTION_REPLY]))
              {
                   foreach($_POST[Globals::FLD_NAME_TASK_QUESTION_REPLY] as $ans_id => $answers)
                   {    
                        if(isset($answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC]))
                        {
                            if($answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC] == '' || $answers[Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC]== NULL)
                            {    
                                $this->addError("[".$ans_id."]".Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC, 'Answer cannot be blank.');
                            }
                        }
                        elseif( isset($answers[Globals::FLD_NAME_REPLY_YESNO] ))
                        {
                            if($answers[Globals::FLD_NAME_REPLY_YESNO] == '' || $answers[Globals::FLD_NAME_REPLY_YESNO]== NULL)
                            {
                                $this->addError("[".$ans_id."]".Globals::FLD_NAME_REPLY_YESNO, 'Answer cannot be blank.');
                            }
                        }
                   }
              }
	}
	public function getQuestionAnswerByTasker($task_id, $tasker_id)
	{  
           $questionsAnswers = self::getQuestionAnswerByTaskerFromDB($task_id, $tasker_id);
            return $questionsAnswers;
    }
    public function getQuestionAnswerByTaskerFromDB($task_id, $tasker_id)
	{  
        $criteria = new CDbCriteria();
        $criteria->condition = "t.".Globals::FLD_NAME_TASK_ID." ='" . $task_id . "'";
        $criteria->condition = "t.".Globals::FLD_NAME_TASKER_ID." ='" . $tasker_id . "'";
//        echo '<pre>';
//        print_r($criteria);
//        exit;
        $questionsAnswers = TaskQuestionReply::model()->findAll($criteria);
        return $questionsAnswers;
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
		$criteria->compare(Globals::FLD_NAME_TASKER_ID,$this->{Globals::FLD_NAME_TASKER_ID},true);
		//$criteria->compare(Globals::FLD_NAME_QUESTION_ID,$this->{Globals::FLD_NAME_QUESTION_ID},true);
		$criteria->compare(Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC,$this->{Globals::FLD_NAME_TASKER_QUESTION_REPLY_DESC},true);
		$criteria->compare(Globals::FLD_NAME_REPLY_YESNO,$this->{Globals::FLD_NAME_REPLY_YESNO},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_SOURCE_APP,$this->{Globals::FLD_NAME_SOURCE_APP},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskQuestionReply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
