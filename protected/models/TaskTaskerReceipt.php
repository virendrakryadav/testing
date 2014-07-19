<?php

/**
 * This is the model class for table "{{dta_task_tasker}}".
 *
 * The followings are the available columns in table '{{dta_task_tasker}}':
 * @property string $task_tasker_id
 * @property string $task_id
 * @property string $tasker_id
 * @property string $selection_type
 * @property string $tasker_location_longitude
 * @property string $tasker_location_latidude
 * @property string $tasker_location_geo_area
 * @property integer $tasker_in_range
 * @property string $poster_comments
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $source_app
 * @property string $status
 */
class TaskTaskerReceipt extends CActiveRecord
{
    
    //public $agree_for_expenses;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_tasker_receipt}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('task_id, tasker_id, selection_type, created_at, created_by, updated_at, updated_by', 'required'),
//			array('tasker_in_range, created_by, updated_by', 'numerical', 'integerOnly'=>true),
//			array('task_id, tasker_id', 'length', 'max'=>20),
//			array('selection_type, source_app', 'length', 'max'=>10),
//			array('tasker_location_longitude, tasker_location_latidude', 'length', 'max'=>30),
//			array('tasker_location_geo_area', 'length', 'max'=>100),
			
//			array('status', 'length', 'max'=>1),
                        // sendProposal//
//                        array('proposed_cost,approved_cost, poster_comments', 'required','on'=>'sendProposal'),
//                        array('agree_for_expenses', 'agreeForExpenses','on'=>'sendProposal'),
//                        array('proposed_cost,approved_cost', 'numerical','min'=>0),
//                        array('agree_for_expenses', 'numerical' ,'integerOnly'=>true),
//                        array('proposed_cost,approved_cost', 'length','max'=>7),
//                        array('poster_comments', 'length', 'max'=>Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH ,'min'=>10),
                       
                        // sendProposal ends//
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
//			array('task_tasker_id, task_id, tasker_id, selection_type, tasker_location_longitude, tasker_location_latidude, tasker_location_geo_area, tasker_in_range, poster_comments, created_at, created_by, updated_at, updated_by, source_app, status', 'safe', 'on'=>'search'),
//                        
//                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert,sendProposal'),
//                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update,sendProposal'),
//                        array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update,sendProposal')
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
//                    'task' => array(self::BELONGS_TO, 'Task', 'task_id'),
//                    'user' => array(self::BELONGS_TO, 'User', 'tasker_id'),
                    'taskTasker' => array(self::BELONGS_TO, 'TaskTasker', Globals::FLD_NAME_TASK_TASKER_ID),
                   
		);
	}
      
	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
            return array(
//                    'task_tasker_id' => Yii::t('label_model', 'lbl_task_tasker_id'),
//                    'task_id' => Yii::t('label_model', 'lbl_task_id'),
//                    'tasker_id' => Yii::t('label_model', 'lbl_tasker_id'),
//                    'selection_type' => Yii::t('label_model', 'lbl_selection_type'),
//                    'tasker_location_longitude' => Yii::t('label_model', 'lbl_tasker_location_longitude'),
//                    'tasker_location_latidude' => Yii::t('label_model', 'lbl_tasker_location_latidude'),
//                    'tasker_location_geo_area' => Yii::t('label_model', 'lbl_tasker_location_geo_area'),
//                    'tasker_in_range' => Yii::t('label_model', 'lbl_tasker_in_range'),
//                    'proposed_cost' => Yii::t('label_model', 'lbl_proposal_cost'),
//                    'poster_comments' => Yii::t('label_model', 'lbl_poster_comments'),
//                    'created_at' => Yii::t('label_model', 'lbl_created_at'),
//                    'created_by' => Yii::t('label_model', 'lbl_created_by'),
//                    'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
//                    'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
//                    'status' => Yii::t('label_model', 'lbl_status'),
//                    'source_app' => Yii::t('label_model', 'lbl_source_app'),
//                    'agree_for_expenses' => Yii::t('label_model', 'lbl_agree_for_expenses'),

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
        public function getReceiptAttachmentByTaskTaskerId()
        {
            $model = new TaskTaskerReceipt();
            $criteria = new CDbCriteria();
            $criteria->addCondition('t.'.Globals::FLD_NAME_TASK_TASKER_ID.' ="'.Yii::app()->user->id.'" ');
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                ));
        }
        
        public function getReceiptAttachment()
        {
            $task_tasker_id = 5;
            $model = new TaskTaskerReceipt();
            $criteria = new CDbCriteria();
            $criteria->compare( 't.'.Globals::FLD_NAME_TASK_TASKER_ID , $task_tasker_id);
            $getReceiptAttachment = TaskTaskerReceipt::model()->findAll($criteria);
//            echo $getReceiptAttachment['task_tasker_id']; exit();
            return $getReceiptAttachment;
                        
        }
        
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare(Globals::FLD_NAME_TASK_TASKER_ID,$this->{Globals::FLD_NAME_TASK_TASKER_ID},true);
//		$criteria->compare(Globals::FLD_NAME_TASK_ID,$this->{Globals::FLD_NAME_TASK_ID},true);
//		$criteria->compare(Globals::FLD_NAME_TASKER_ID,$this->{Globals::FLD_NAME_TASKER_ID},true);
//		$criteria->compare(Globals::FLD_NAME_SELECTION_TYPE,$this->{Globals::FLD_NAME_SELECTION_TYPE},true);
//		$criteria->compare(Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE,$this->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE},true);
//		$criteria->compare(Globals::FLD_NAME_TASKER_LOCATION_LATITUDE,$this->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE},true);
//		$criteria->compare(Globals::FLD_NAME_TASKER_LOCATION_GEO_AREA,$this->{Globals::FLD_NAME_TASKER_LOCATION_GEO_AREA},true);
//		$criteria->compare(Globals::FLD_NAME_TASKER_IN_RANGE,$this->{Globals::FLD_NAME_TASKER_IN_RANGE});
//		$criteria->compare(Globals::FLD_NAME_TASKER_POSTER_COMMENTS,$this->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS},true);
//		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
//		$criteria->compare(Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);
//		$criteria->compare(Globals::FLD_NAME_CREATED_BY,$this->{Globals::FLD_NAME_CREATED_BY});
//		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});
//		$criteria->compare(Globals::FLD_NAME_SOURCE_APP,$this->{Globals::FLD_NAME_SOURCE_APP},true);
//		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

       
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskTasker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getTaskTaskerId($poster_id, $task_id)
    {
         $poster_id = $_POST['poster_id'];
         $task_id = $_POST['task_id'];
         $taskTasker = TaskTasker::model()->findByAttributes(array('task_id' =>$task_id,'tasker_id' =>Yii::app()->user->id));
         return $taskTasker;
    }
    
    public function checkTaskTaskerId($taskTaskerIdArray)
    {
        $model = new TaskTaskerReceipt();
        $criteria=new CDbCriteria;
        $taskTaskerId = $taskTaskerIdArray;
        $criteria->addInCondition(Globals::FLD_NAME_TASK_TASKER_ID,$taskTaskerId);
        
        return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
            ));
    }
}