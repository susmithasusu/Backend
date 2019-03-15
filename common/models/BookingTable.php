<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "display".
 *
 * @property integer $id
 * @property string $book_name
 * @property string $author_name
 * @property string $discription
 * @property integer $price
 * @property string $languages
 */
class BookingTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    // public $flag;
    public static function tableName()
    {
        return 'booking-table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'package_id', 'user_id', 'starting_date','end_date', 'no_of_persons','no_of_days','tour_amount','Total_amt'], 'required'],
            [[ 'tour_amount'], 'integer'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [      
            'package_id' => 'PACKAGE_ID',
            'booking_date' => 'BOOKING_DATE',
            'start_date' => 'START_DATE',
            'no_of_persons' => 'NO_OF_PERSONS',
            'tour_amount' => 'TOUR_AMOUNT'
          
            
        ];
    }
    
        /**
         * @inheritdoc
         */
      
    
    }
      
    

    