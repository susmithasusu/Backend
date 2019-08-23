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
            [[ 'product_name', 'product_description','product_category', 'product_price','product_fine','total_products'], 'required'],

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
              'total_products'=>'TOTAL_PRODUCTS'
            
          
            
        ];
    }
    
        /**
         * @inheritdoc
         */
      
    
    }
      
    

    