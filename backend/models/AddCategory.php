<?php

namespace backend\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class AddCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
     return [
            [[ 'category_name'], 'required'],

             ['category_name','trim'],
        
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [      
            'category_name'=> 'CATEGORY_NAME',
         
          
            
        ];
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                $this->created_at = date("Y-m-d H:i:s", time());
                $this->updated_at = date("Y-m-d H:i:s", time());

            } else {

                $this->updated_at = date("Y-m-d H:i:s", time());
            }
            return true;
        } else {
            return false;
        }


    }
    
        /**
         * @inheritdoc
         */
      
    
    }
      
    

    