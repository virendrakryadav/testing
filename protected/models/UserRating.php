<?php

/**
 * This is the model class for table "{{dta_task_location}}".
 *
 * The followings are the available columns in table '{{dta_task_location}}':
 * @property string $id
 * @property string $task_id
 * @property string $is_location_region
 * @property integer $region_id
 * @property string $country_code
 * @property string $location_longitude
 * @property string $location_latitude
 * @property string $location_geo_area
 */
class UserRating extends CActiveRecord
{
       
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_rating}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('location_geo_area', 'required' on),
                       
                        ///in-person task ///
                        
                        // end in-person task//
                        // 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
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
		return array();
	}

        public function getPosterRatingByTasker($task_id)
        {
            $criteria=new CDbCriteria;
               
            $criteria->addCondition('task_id ='.$task_id);
            $criteria->addCondition('by_user_id ='.Yii::app()->user->id);

            $rating = UserRating::model()->findAll($criteria);
//            echo '<pre>';
//            print_r($rating);
//            exit;
            return $rating;
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskLocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
