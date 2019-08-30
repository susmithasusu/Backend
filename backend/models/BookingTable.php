<?php

namespace backend\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class BookingTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public static function tableName()
    {
        return 'bookings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
     return [
            [[ 'user_id','product_name','total_products','boooking_date','return_date'], 'required'],

            ['product_name','trim'],
        
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [ 
                 'user_id'=>'USER_ID',     
                 'product_name'=> 'PRODUCT_NAME',
                 'booking_date'=>'BOOKING_DATE',
                 'return_date'=> 'RETURN_DATE',
                 'total_products'=>'TOTAL_PRODUCTS'
                
          
            
        ];
    }

    // public function beforeSave($insert)
    // {

    //     if (parent::beforeSave($insert)) {

    //         if ($this->isNewRecord) {
    //             $this->created_at = date("Y-m-d H:i:s", time());
    //             $this->updated_at = date("Y-m-d H:i:s", time());

    //         } else {

    //             $this->updated_at = date("Y-m-d H:i:s", time());
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }


    // }
    
        /**
         * @inheritdoc
         */
      
    
    }
      
    

    