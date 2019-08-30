<?php

namespace backend\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class AddProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public static function tableName()
    {
        return 'add_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
     return [
            [[ 'product_name', 'product_description','category_name', 'product_price','product_fine','total_products','product_image'], 'required'],

            ['product_name','trim'],
        
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [      
                'product_name'=> 'PRODUCT_NAME',
                'product_description'=> 'PRODUCT_DESCRIPTION',
                'product_category'=>'PRODUCT_CATEGORY',
                'product_price'=>'PRODUCT_PRICE',
                'product_fine'=>'PRODUCT_FINE',
                'total_products'=>'TOTAL_PRODUCTS',
                'product_image'=>'PRODUCT_IMAGE'
                
          
            
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
      
    

    