<?php

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $admin_id
 * @property string $login_name
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property integer $role_id
 * @property integer $is_super
 *
 * The followings are the available model relations:
 * @property Roles $role
 */
class Admin extends CActiveRecord
{
    public $repeatpassword;
    public $newpassword;
    public $oldpassword;
	/**
	 * @return string the associated database table name
	 */
    
	public function tableName()
	{
		return '{{dta_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
                                //set scenarios for roll
                                array('gender, password, repeatpassword, user_roleid', 'required', 'on' => 'hasRoleInsert'),
                                array('  gender, user_roleid', 'required', 'on' => 'hasRoleUpdate'),
                                // For Remove Spacing using trim
                                array('  lastname,gender', 'filter', 'filter'=>array($this,'filterPostalCode'), 'on' => 'hasRoleInsert'),
                                array('  gender,password, repeatpassword', 'required', 'on'=>'insert'),
                                array('firstname', 'required','message'=>"First Name cannot be blank.", 'on'=>'insert,hasRoleInsert,hasRoleUpdateupdate,updateaccount'),
                                array('firstname,  ', 'required', 'on'=>'updateaccount'),

                                array('  gender', 'required', 'on'=>'update'),
                               // array('phone', 'match','pattern'=>'(/^\d*\.?\d*[0-9]+\d*$)|(^[0-9]+\d*\.\d*$)/'),
                                //array('user_phone', 'numerical'),

                                array('oldpassword, newpassword, repeatpassword', 'required', 'on' => 'changepassword'),
                                array('newpassword, repeatpassword', 'required', 'on' => 'userchangepassword'),
                                //array('login_name', 'unique'),
                                array('user_roleid, is_admin', 'numerical', 'integerOnly'=>true),
                               // array('login_name',  'length', 'max'=>100,'min'=>2),

                                array('firstname', 'length', 'max'=>100,'min'=>2),
                                array('lastname', 'length', 'max'=>100),
                               // array('user_email','email'),
                              //  array('user_phone', 'length', 'min'=>10,'max'=>20),
                                //  The following rule is used by search().
                                // @todo Please remove those attributes that should not be searched.
                                array('user_id,   firstname,lastname,gender, password, user_roleid, is_admin', 'safe', 'on'=>'search'),
                                array('password, newpassword, repeatpassword, oldpassword', 'length', 'min'=>6,'max'=>50),

                                array('repeatpassword', 'compare', 'compareAttribute'=>'newpassword', 'message'=>"Passwords don't match",'on' => 'changepassword, userchangepassword'),
                                array('repeatpassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match",'on'=>'insert'),
                                array('oldpassword', 'equalPasswords','on' => 'changepassword'),
                                //array('password', 'match' ,'pattern'=>'/^[a-z0-9_-]+\.[a-z]+$/i', 'message'=>'Field can contain only alphanumeric characters and hyphens(-).'),
                                //Password Validation
                                array('password', 'match' ,'pattern'=>'/^\S+$/', 'message'=>'Space not allow', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword'),
                                array('password', 'match' ,'pattern'=>'/(?=.*[\W])/', 'message'=>'Contains at least one special character', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword'),
                                array('password', 'match' ,'pattern'=>'/(?=.*[\d])/', 'message'=>'Contains at least one digit', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword'),

                                array('newpassword', 'match' ,'pattern'=>'/^\S+$/', 'message'=>'Space not allow', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword'),
                                array('newpassword', 'match' ,'pattern'=>'/(?=.*[\W])/', 'message'=>'Contains at least one special character', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword'),
                                array('newpassword', 'match' ,'pattern'=>'/(?=.*[\d])/', 'message'=>'Contains at least one digit', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword'),


                                array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert,hasRoleInsert'),
                                array('update_timestamp','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update,hasRoleUpdate'),
                                array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update,hasRoleUpdate')
                    
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
			'roles' => array(self::BELONGS_TO, 'Roles', 'user_roleid'),
		);
	}
	
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'Admin',
			//'login_name' => 'User Name',
			//'user_salutation' => 'Salution',
			'firstname' => 'Name',
			'lastname' => 'Last Name',
			'gender' => 'Gender',
			'password' => 'Password',
			'repeatpassword'=>'Confirm Password',
			'oldpassword'=>'Old Password',
			'newpassword'=>'New Password',
			//'user_email' => 'Email',
			//'user_phone' => 'Phone No',
			'user_roleid' => 'User Role',
			'is_admin' => 'Is Admin',
			'status' => 'Status',
                   

		);
	}
        /**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->password);
	}
    //Validate after Trim
	public function filterPostalCode($stringToTrim)
	{
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return $stringToTrim;
	}
	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
       
	public function equalPasswords($attribute,$params)
	{
            if (isset($this->oldpassword))
            {
                $user = Admin::model()->findByPk(Yii::app()->user->id);
	        if ($user->password != md5($this->oldpassword.Yii::app()->params["salt"]))
                {
                    $this->addError($attribute, 'Old password is incorrect.');
                }      
            }
	}
	public function getGenderOptions() {
                return array(
                        "M"=>'Male',
                        "F"=>'Female',
                );
        }
	public function beforeSave() 
	{  
            if ( Yii::app()->controller->action->id != "update" )
            {
                if ( Yii::app()->controller->action->id != "updateaccount" )
                {
                    $pass = md5($this->password.Yii::app()->params["salt"]);
                    $this->password = $pass;
                }
            }
		
		return true;
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
		//$criteria->compare('admin_id','2',true);
		//$criteria->compare('login_name',$this->login_name,true);
		$criteria->compare('firstname',$this->firstname,true);
                $criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('password',$this->password,true);
		//$criteria->compare('user_email',$this->user_email,true);
		//$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_roleid',$this->user_roleid);
		$criteria->addCondition('user_id!="'.Yii::app()->params['superAdminId'].'" ');
                $criteria->addCondition('user_id!="'.Yii::app()->user->id.'" ');
                
		if(Yii::app()->user->id!=Yii::app()->params['superAdminId'])
		{
			$criteria->compare('is_admin',0);
		}
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>  array(
                                    'pageSize'=>Yii::app()->user->getState('adminDataSession',Yii::app()->params['defaultPageSize'])
                                    ),
                   
                    
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Admin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}