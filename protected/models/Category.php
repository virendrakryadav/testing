<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $category_id
 * @property string $category_name
 * @property integer $category_priority
 * @property integer $category_status
 * @property integer $category_addedby
 * @property string $category_addedon
 * @property string $category_updateon
 * @property integer $category_updatedby
 */
class Category extends CActiveRecord
{
	public $maxPriority;
        public $category_name;
        public $category_priority;
        public $category_status;        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('category_priority, category_status', 'required'),
//			
//			array('category_priority', 'numerical', 'integerOnly'=>true),
//			array('category_status', 'length', 'max'=>1),
//			array('category_priority', 'length', 'max'=>3),
//			
//			array('category_updateon', 'safe'),
                        array('default_min_price', 'numerical', 'integerOnly'=>true , 'min'=>0),
                        array('default_max_price', 'numerical', 'integerOnly'=>true, 'min'=>0),
                        array('default_estimated_hours', 'numerical', 'integerOnly'=>true, 'min'=>0),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('category_name,category_status', 'safe', 'on'=>'search'),
			
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
			'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', Globals::FLD_NAME_CATEGORY_ID),
                        'parentName' => array(self::BELONGS_TO, 'CategoryLocale', array('parent_id' => Globals::FLD_NAME_CATEGORY_ID), 'through'=>'categorylocale'),
		);
	}
/*
	public function getCategoryList()
	{  
           $category = self::getCategoryListFromDB();
            return $category;
    }*/
    public function getCategoryList()
	{  
           //$userLang = Yii::app()->user->getState('language');
	  //Yii::app()->cache->delete(Globals::$cacheKeys['GET_CATEGORY_LIST'].'_'.$userLang);
     
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::beginProfile('Category.getCategoryList','Category.getCategoryList');
      }
      $userLang = Yii::app()->user->getState('language');
      $categories = Yii::app()->cache->get(Globals::$cacheKeys['GET_CATEGORY_LIST'].'_'.$userLang);     

      if($categories === false)
      {

         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         if(!empty($defaultLang))
         {
            $criteria->params = array(':language' => $defaultLang );
         }else
         {
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
         }
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_CATEGORY_LIST'].'_'.$userLang, $categories);
      }
      
      if(empty($categories))
      {
         $defaultLang = GLOBALS::DEFAULT_LANGUAGE;
         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         $criteria->params = array(':language' => $defaultLang );
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_CATEGORY_LIST'].'_'.$defaultLang, $categories);
      }
                    	  
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::endProfile('Category.getCategoryList');
      }
            
      return $categories;
    }
   /* public function getCategoryListFromDB()
	{  
            $criteria = new CDbCriteria();
            $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return $category;
    }*/
    public function getCategoryListLimit($limit = Globals::CATEGORY_LIMIT )
    {
            $category = self::getCategoryListLimitFromDB($limit);
            return $category;
    }
    public function getCategoryListLimitFromDB($limit = Globals::CATEGORY_LIMIT )
	{
            $criteria = new CDbCriteria();
            $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->limit = $limit;
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return $category;
	}
    public function getCategoryListByID($id,$limit = Globals::CATEGORY_LIMIT)
	{  
		$category = self::getCategoryListByIDFromDB($id , $limit);
		return $category;
	}
    public function getCategoryListByIDFromDB($id,$limit = Globals::CATEGORY_LIMIT)
	{  
            $criteria = new CDbCriteria();
            $criteria->compare('categorylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
            $criteria->compare('t.category_id',$id);
            $criteria->limit = $limit;
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return $category;
   }
        
        public function getCategoryListByType( $id = '',$limit = Globals::CATEGORY_LIMIT )
	{
            $category = self::getCategoryListByTypeFromDB($id , $limit);
            return $category;
        }
        public function getCategoryListByTypeFromDB($id = '' , $limit = Globals::CATEGORY_LIMIT)
	{
            $type = "";
            $criteria = new CDbCriteria();
  
            $criteria->addCondition("categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language");
            if( $id == Globals::DEFAULT_VAL_V )
            {
               $criteria->addCondition("t.is_virtual =1");
            }
            if( $id == Globals::DEFAULT_VAL_P )
            {
                $criteria->addCondition("t.is_inperson =1");
            }
            if( $id == Globals::DEFAULT_VAL_I )
            {
                $criteria->addCondition("t.is_instant =1");
            }
               
            
            $criteria->limit = $limit;
            $criteria->params = array(':language' => Yii::app()->user->getState('language'));
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
//            echo '<pre>';
//            print_r($category);
//            exit;
            return $category;
        }

/*
   public function getInpersonCategoryList()
	{  
            $category = self::getInpersonCategoryListFromDB();
            return $category;
        } */
   public function getInpersonCategoryList()
	{  
      //$userLang = Yii::app()->user->getState('language');
	 // Yii::app()->cache->delete(Globals::$cacheKeys['GET_IN_PERSON_CATEGORY_LIST'].'_'.$userLang);
     
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::beginProfile('Category.getInpersonCategoryList','Category.getInpersonCategoryList');
      }
      $userLang = Yii::app()->user->getState('language');
      $categories = Yii::app()->cache->get(Globals::$cacheKeys['GET_IN_PERSON_CATEGORY_LIST'].'_'.$userLang);     

      if($categories === false)
      {

         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         if(!empty($defaultLang))
         {
            $criteria->params = array(':language' => $defaultLang );
         }else
         {
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
         }
         $criteria->addCondition('t.is_inperson = true ');
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_IN_PERSON_CATEGORY_LIST'].'_'.$userLang, $categories);
      }
      
      if(empty($categories))
      {
         $defaultLang = GLOBALS::DEFAULT_LANGUAGE;
         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         $criteria->addCondition('t.is_inperson = true ');
         $criteria->params = array(':language' => $defaultLang );
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_IN_PERSON_CATEGORY_LIST'].'_'.$defaultLang, $categories);
      }
                    	  
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::endProfile('Category.getInpersonCategoryList');
      }
       //CommonUtility::pre($categories);     
      return $categories;
   }
  /* public function getInpersonCategoryListFromDB()
	{  
      $criteria = new CDbCriteria();
      $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
      $criteria->addCondition('t.is_inperson = true ');
      $criteria->params = array(':language' => Yii::app()->user->getState('language') );
      $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
      return $category;
   } */
        /*public function getInstantCategoryList()
	{  
            $category = self::getInstantCategoryListFromDB();
            return $category;
        } */
        
   public function getInstantCategoryList()
	{  
	  //$userLang = Yii::app()->user->getState('language');
	  //Yii::app()->cache->delete(Globals::$cacheKeys['GET_INSTANT_CATEGORY_LIST'].'_'.$userLang);
     
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::beginProfile('Category.getInstantCategoryList','Category.getInstantCategoryList');
      }
      $userLang = Yii::app()->user->getState('language');
      $categories = Yii::app()->cache->get(Globals::$cacheKeys['GET_INSTANT_CATEGORY_LIST'].'_'.$userLang);     
     
      if($categories === false)
      {
         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         if(!empty($defaultLang))
         {
            $criteria->params = array(':language' => $defaultLang );
         }else
         {
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
         }
         $criteria->addCondition('t.is_instant = true ');
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_INSTANT_CATEGORY_LIST'].'_'.$userLang, $categories);
      }
      
      if(empty($categories))
      {
         $defaultLang = GLOBALS::DEFAULT_LANGUAGE;
         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         $criteria->params = array(':language' => $defaultLang );
         $criteria->addCondition('t.is_instant = true ');
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_INSTANT_CATEGORY_LIST'].'_'.$defaultLang, $categories);
      }
                    	  
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::endProfile('Category.getInstantCategoryList');
      }
            
      return $categories;
   } 
      /*  public function getInstantCategoryListFromDB()
	{  
            $criteria = new CDbCriteria();
            $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $criteria->addCondition('t.is_instant = true ');
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return $category;
        } */
       /* public function getVirtualCategoryListParentOnly()
	{  
            $category = self::getVirtualCategoryListParentOnlyFromDB();
            return $category;
        } */
        
 public function getInstantCategoryList2()
	{  
	    $criteria=new CDbCriteria;
            $criteria->with = array( 'categorylocale','parentName' );
                
            $criteria->compare('categorylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
            $criteria->compare('t.is_instant',true);
        
        
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                      
                        
		));

   } 
    public function getVirtualCategoryListParentOnly()
    {  
     //$userLang = Yii::app()->user->getState('language');
	  //Yii::app()->cache->delete(Globals::$cacheKeys['GET_VIRTUAL_CATEGORY_LIST_PARENT_ONLY'].'_'.$userLang);
     
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::beginProfile('Category.getVirtualCategoryListParentOnly','Category.getVirtualCategoryListParentOnly');
      }
      $userLang = Yii::app()->user->getState('language');
      $categories = Yii::app()->cache->get(Globals::$cacheKeys['GET_VIRTUAL_CATEGORY_LIST_PARENT_ONLY'].'_'.$userLang);     
     
      if($categories === false)
      {
         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         if(!empty($defaultLang))
         {
            $criteria->params = array(':language' => $defaultLang );
         }else
         {
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
         }
         $criteria->addCondition('t.is_virtual =true ');
         $criteria->addCondition('t.'.Globals::FLD_NAME_SUB_CATEGORY_CNT.' > 0 ');
         $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' IS NULL ');
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_VIRTUAL_CATEGORY_LIST_PARENT_ONLY'].'_'.$userLang, $categories);
      }
      
      if(empty($categories))
      {
         $defaultLang = GLOBALS::DEFAULT_LANGUAGE;
         $criteria = new CDbCriteria();
         $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
         $criteria->params = array(':language' => $defaultLang );
         $criteria->addCondition('t.is_virtual =true ');
         $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' IS NULL ');
         $categories = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
         Yii::app()->cache->set(Globals::$cacheKeys['GET_VIRTUAL_CATEGORY_LIST_PARENT_ONLY'].'_'.$defaultLang, $categories);
      }
                    	  
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::endProfile('Category.getVirtualCategoryListParentOnly');
      }
            
      return $categories;
   }
   
    public function getInpersonCategoryListParentOnly()
    {  
        $criteria = new CDbCriteria();
        $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
        $criteria->params = array(':language' => Yii::app()->user->getState('language') );
        $criteria->addCondition('t.is_inperson = true ');
        $criteria->addCondition('t.'.Globals::FLD_NAME_SUB_CATEGORY_CNT.' > 0 ');
        $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' IS NULL ');
        $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
        return $category;
    }
      
    public function getInstantCategoryListParentOnly()
    {  
        $criteria = new CDbCriteria();
        $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
        $criteria->params = array(':language' => Yii::app()->user->getState('language') );
        $criteria->addCondition('t.is_instant = true ');
        $criteria->addCondition('t.'.Globals::FLD_NAME_SUB_CATEGORY_CNT.' > 0 ');
        $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' IS NULL ');
        $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
        return $category;
    }
    public function getCategoryListParentOnly()
    {  
        $criteria = new CDbCriteria();
        $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
        $criteria->params = array(':language' => Yii::app()->user->getState('language') );
//        $criteria->addCondition('t.is_instant = true ');
        $criteria->addCondition('t.'.Globals::FLD_NAME_SUB_CATEGORY_CNT.' > 0 ');
        $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' IS NULL ');
        $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
        return $category;
    }
        
   /*     public function getVirtualCategoryListParentOnlyFromDB()
	{  
            $criteria = new CDbCriteria();
            $criteria->condition = "categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $criteria->addCondition('t.is_virtual =true ');
            $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' IS NULL ');
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return $category;
        } */
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => Yii::t('label_model', 'lbl_category'),
			'category_name' => Yii::t('label_model', 'lbl_category_name'),
			'category_priority' => Yii::t('label_model', 'lbl_category_priority'),
			'category_status' => Yii::t('label_model', 'lbl_category_status'),
			
		);
	}
//        public function getChildren($parent, $level=0) 
//        { 
//            $criteria = new CDbCriteria;
//            $criteria->condition='t.parent_id=:id';
//            $criteria->params=array(':id'=>$parent);
//            $model = Category::model()->with('categorylocale')->findAll($criteria,array('order' => 'category_priority'));
//            foreach ($model as $key) 
//            {
//                echo str_repeat(' — ', $level) . $key->categorylocale->category_name . "<br />";
//                Category::getChildren($key->category_id, $level+1);
//            }
//        }
//        public function beforeSave() 
//	{
//               
//		 
//		return true;
//	}
        public function getParentCategory($taskType = '' , $notIn='') 
        { 
             $category = self::getParentCategoryFromDB($taskType , $notIn);
             return  $category;
        }
     
        public function getParentCategoryFromDB( $taskType = '' , $notIn='' ) 
        { 
            $criteria = new CDbCriteria();
            $criteria->compare("categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE, Yii::app()->user->getState('language'));
           
            $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' IS NULL ');
         
            if($taskType)
            {
                
                if( $taskType == Globals::DEFAULT_VAL_V )
                {
                    $criteria->addCondition("t.is_virtual =1");
                }
                if( $taskType == Globals::DEFAULT_VAL_P )
                {
                    $criteria->addCondition("t.is_inperson =1");
                }
                if( $taskType == Globals::DEFAULT_VAL_I )
                {
                    $criteria->addCondition("t.is_instant = 1");
                }
               

            }
            if($notIn)
            {
              $criteria->addCondition('categorylocale.'.Globals::FLD_NAME_CATEGORY_ID.' !="'.$notIn.'"');  
            }
            //print_r($criteria);
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return  $category;
        }
        public function getChildCategoryByID($cat_id , $notIn='') 
        { 
             $category = self::getChildCategoryByIDFromDB($cat_id ,$notIn);
             return  $category;
        }
        public function getChildCategoryByIDFromDB($cat_id , $notIn='') 
        { 
            $criteria = new CDbCriteria;
            $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' = "'.$cat_id.'"');
            $criteria->addCondition('categorylocale.'.Globals::FLD_NAME_LANGUAGE_CODE.' = "'.Yii::app()->user->getState('language').'"');
            if($notIn)
            {
              $criteria->addCondition('categorylocale.'.Globals::FLD_NAME_CATEGORY_ID.' !="'.$notIn.'"');  
            }
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return  $category;
        }
        public function getParentCategoryChild($cat_id) 
        { 
            $criteria = new CDbCriteria;
           
            $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_ID.' ="'.$cat_id.'"'); 
            $criteria->addCondition('parentName.'.Globals::FLD_NAME_LANGUAGE_CODE.' = "'.Yii::app()->user->getState('language').'"');
        
            $category = Category::model()->with('parentName')->find($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return  $category;
        }
        public function getChildCategoryByIDDataprovider(array $filter = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            if(!isset($filter['pageSize']))
            {
                $filter['pageSize'] = Yii::app()->params['defaultPageSize'];
            }
            $filter[Globals::FLD_NAME_CATEGORY_NAME] = empty($filter[Globals::FLD_NAME_CATEGORY_NAME]) ? '' : $filter[Globals::FLD_NAME_CATEGORY_NAME];
            $filter[Globals::FLD_NAME_CATEGORY_NAME] = trim($filter[Globals::FLD_NAME_CATEGORY_NAME]);
		$criteria=new CDbCriteria;
                $criteria->with = array( 'categorylocale','parentName' );
                if(isset($filter[Globals::FLD_NAME_CATEGORY_ID]))
                {
                      $criteria->addCondition('t.'.Globals::FLD_NAME_CATEGORY_PARENT_ID.' = "'.$filter[Globals::FLD_NAME_CATEGORY_ID].'"');
                    //$criteria->compare('categorylocale.category_id',$this->{Globals::FLD_NAME_CATEGORY_ID});
                }
                if(isset($filter[Globals::FLD_NAME_CATEGORY_NAME]))
                {
                    $criteria->compare('categorylocale.category_name',$filter[Globals::FLD_NAME_CATEGORY_NAME],true);
                }
                $criteria->addCondition('categorylocale.'.Globals::FLD_NAME_LANGUAGE_CODE.' = "'.Yii::app()->user->getState('language').'"');
		
		
               // $criteria->addCondition('categorylocale.parent_id IS NULL ');
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>$filter['pageSize'],
                                        ),
                       
		));

	}
        
        public function getCategoryListByTypeForApi($id = '' ,$language='', $limit = Globals::CATEGORY_LIMIT)
	{
            $criteria = new CDbCriteria();
  
            $criteria->addCondition("categorylocale.".Globals::FLD_NAME_CATEGORY_PARENT_ID." =0");
            $criteria->addCondition("categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language");
            if( $id == Globals::DEFAULT_VAL_V )
            {
               $criteria->addCondition("t.is_virtual =1");
            }
            if( $id == Globals::DEFAULT_VAL_P )
            {
                $criteria->addCondition("t.is_inperson =1");
            }
            if( $id == Globals::DEFAULT_VAL_I )
            {
                $criteria->addCondition("t.is_instant =1");
            }
            $criteria->limit = $limit;
            $criteria->params = array(':language' => $language);
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return $category;
        }
        public function getSubCategoryListByTypeForApi($id = '' ,$category_id='',$language='', $limit = Globals::CATEGORY_LIMIT)
	{
            $criteria = new CDbCriteria();
  
            $criteria->addCondition("categorylocale.".Globals::FLD_NAME_CATEGORY_PARENT_ID." =".$category_id);
            $criteria->addCondition("categorylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language");
            if( $id == Globals::DEFAULT_VAL_V )
            {
               $criteria->addCondition("t.is_virtual =1");
            }
            if( $id == Globals::DEFAULT_VAL_P )
            {
                $criteria->addCondition("t.is_inperson =1");
            }
            if( $id == Globals::DEFAULT_VAL_I )
            {
                $criteria->addCondition("t.is_instant =1");
            }
            $criteria->limit = $limit;
            $criteria->params = array(':language' => $language);
            $category = Category::model()->with('categorylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_CATEGORY_PRIORITY));
            return $category;
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
                $criteria->with = array( 'categorylocale','parentName' );
                $criteria->compare('categorylocale.category_id',$this->{Globals::FLD_NAME_CATEGORY_ID});
		$criteria->compare('categorylocale.category_priority',$this->{Globals::FLD_NAME_CATEGORY_PRIORITY});
		$criteria->compare('categorylocale.category_status',$this->{Globals::FLD_NAME_CATEGORY_STATUS});
		$criteria->compare('categorylocale.language_code',Yii::app()->user->getState('language'));
		$criteria->addCondition('categorylocale.category_name like "%'.$this->{Globals::FLD_NAME_CATEGORY_NAME}.'%" ');
               // $criteria->addCondition('categorylocale.parent_id IS NULL ');
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('categoryDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                        'sort'=>array(
                                            'attributes'=>array(
                                            'category_name'=>array(
                                                            'asc'=>'categorylocale.category_name',
                                                            'desc'=>'categorylocale.category_name DESC',
                                                            ),
                                         
                                                
                                                'parent_name'=>array(
                                                            'asc'=>'parentName.category_name',
                                                            'desc'=>'parentName.category_name DESC',
                                                            ),
                                                'category_priority'=>array(
                                                            'asc'=>'categorylocale.category_priority',
                                                            'desc'=>'categorylocale.category_priority DESC',
                                                            ),
                                                            '*',
                                            ),
                                  'defaultOrder'=>'categorylocale.category_priority ASC',
                       
                        ),
		));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
