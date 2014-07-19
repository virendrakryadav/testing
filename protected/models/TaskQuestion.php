<?php

/**
 * This is the model class for table "{{dta_task_question}}".
 *
 * The followings are the available columns in table '{{dta_task_question}}':
 * @property string $task_id
 * @property string $question_id
 */
class TaskQuestion extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{dta_task_question}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('task_id, question_id', 'required'),
            array(
                'task_id, question_id',
                'length',
                'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'task_id, question_id',
                'safe',
                'on' => 'search'),
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
            'categoryquestion' => array(
                self::BELONGS_TO,
                'CategoryQuestion',
                Globals::FLD_NAME_QUESTION_ID),
            'categoryquestion' => array(
                self::BELONGS_TO,
                'CategoryQuestion',
                Globals::FLD_NAME_QUESTION_ID),

            'categoryquestionlocale' => array(
                self::BELONGS_TO,
                'CategoryQuestionLocale',
                array(Globals::FLD_NAME_QUESTION_ID => Globals::FLD_NAME_QUESTION_ID),
                'through' => 'categoryquestion'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'task_id' => Yii::t('label_model', 'lbl_task_id'),
            'question_id' => Yii::t('label_model', 'lbl_question_id'),
            );
    }
    public function getTaskQuestion($task_id)
    {
		
        $criteria = new CDbCriteria();
        $criteria->condition = "categoryquestionlocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
        $criteria->condition = "t.".Globals::FLD_NAME_TASK_ID." ='" . $task_id . "'";
        $criteria->params = array(':language' => Yii::app()->user->getState('language'));
//        print_r($criteria);exit;
        $questions = TaskQuestion::model()->with('categoryquestionlocale')->findAll($criteria);
		//print_r($questions);exit;
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

        $criteria = new CDbCriteria;

        $criteria->compare(Globals::FLD_NAME_TASK_ID, $this->{Globals::FLD_NAME_TASK_ID}, true);
        $criteria->compare(Globals::FLD_NAME_QUESTION_ID, $this->{Globals::FLD_NAME_QUESTION_ID}, true);

        return new CActiveDataProvider($this, array('criteria' => $criteria, ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TaskQuestion the static model class
     */
    public static function model($className = __class__)
    {
        return parent::model($className);
    }
}
