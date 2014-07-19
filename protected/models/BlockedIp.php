<?php

/**
 * This is the model class for table "{{mst_blocked_ip}}".
 *
 * The followings are the available columns in table '{{mst_blocked_ip}}':
 * @property integer $blocked_ip_id
 * @property string $ip_address
 * @property string $start_dt
 * @property string $end_dt
 * @property string $reason
 * @property string $status
 * @property string $create_at
 * @property string $created_by
 * @property string $update_at
 * @property string $updated_by
 */
class Blockedip extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_blocked_ip}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip_address', 'required'),
                        array('end_dt','compareDate','on'=>'datevalidete'),
                        array('end_dt','compareDate','on'=>'datevalideteonupdate'),
			array('ip_address', 'length', 'max'=>40),
			array('reason', 'length', 'max'=>2000),
			array('status', 'length', 'max'=>1),
			array('created_by, updated_by', 'length', 'max'=>20),
			array('end_dt, update_at', 'safe'),
                        //array('ip_address', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ip_address, start_dt, end_dt, reason, status', 'safe', 'on'=>'search'),
                        array('created_by','default','value'=>Yii::app()->user->getState('actionUserId'), 'setOnEmpty'=>false,'on'=>'datevalidete'),
                        array('update_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'datevalideteonupdate'),
                        array('updated_by','default', 'value'=>Yii::app()->user->getState('actionUserId'),'on'=>'datevalideteonupdate')
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
			'blocked_ip_id' => 'Blocked IP',
			'ip_address' => 'IP Address',
			'start_dt' => 'Start Date',
			'end_dt' => 'End date',
			'reason' => 'Reason',
			'status' => 'Status',
			'create_at' => 'Create At',
			'created_by' => 'Created By',
			'update_at' => 'Update At',
			'updated_by' => 'Updated By',
		);
	}

	public function compareDate($attribute,$params)
        {
            if(isset($this->{Globals::FLD_NAME_BLOCKED_IP_START_DATE}) && isset($this->{Globals::FLD_NAME_BLOCKED_IP_END_DATE}))
            {      
                $datetime1 = date_create($this->{Globals::FLD_NAME_BLOCKED_IP_START_DATE});
                $datetime2 = date_create($this->{Globals::FLD_NAME_BLOCKED_IP_END_DATE});
                $interval = date_diff($datetime1, $datetime2);
                $difference =  $interval->format('%R%a');
                if($difference < 0)
                {
                    if($this->{Globals::FLD_NAME_BLOCKED_IP_START_DATE}!='')
                    {
                        $startDate = $this->{Globals::FLD_NAME_BLOCKED_IP_START_DATE};
                        $this->addError(Globals::FLD_NAME_BLOCKED_IP_END_DATE,$this->getAttributeLabel(Globals::FLD_NAME_BLOCKED_IP_END_DATE).' must be greater than "'.$startDate.'".');
                    }
                    else
                    {
                        $startDate = 'start date';
                        $this->addError(Globals::FLD_NAME_BLOCKED_IP_END_DATE,$this->getAttributeLabel(Globals::FLD_NAME_BLOCKED_IP_END_DATE).' must be greater than '.$startDate);
                    }
                }
            }
        }
        
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare('blocked_ip_id',$this->blocked_ip_id);
		$criteria->compare(Globals::FLD_NAME_BLOCKED_IP_ADDRESS,$this->{Globals::FLD_NAME_BLOCKED_IP_ADDRESS},true);
		$criteria->compare(Globals::FLD_NAME_BLOCKED_IP_START_DATE,$this->{Globals::FLD_NAME_BLOCKED_IP_START_DATE},true);
		$criteria->compare(Globals::FLD_NAME_BLOCKED_IP_END_DATE,$this->{Globals::FLD_NAME_BLOCKED_IP_END_DATE},true);
		$criteria->compare(Globals::FLD_NAME_BLOCKED_IP_REASON,$this->{Globals::FLD_NAME_BLOCKED_IP_REASON},true);
		$criteria->compare(Globals::FLD_NAME_BLOCKED_IP_STATUS,$this->{Globals::FLD_NAME_BLOCKED_IP_STATUS},true);		

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=> array(
                                        'pageSize'=>Yii::app()->user->getState('blockedIpDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                    
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlockedIp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
