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
class Custom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    // public $flag;
    public static function tableName()
    {
        return 'custome_trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'req_fromlocation','req_tolocation','req_startdate', 'req_enddate', 'req_persons',
            'req_expectedamt'], 'required'],
            [[ 'req_expectedamt'], 'integer'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [  
         
            'req_fromlocation'=> 'FROM_LOCATION',
            'req_tolocation'=>'TO_LOCATION',
            'req_startdate'=>'START_DATE_REQUESTED',
            'req_enddate'=>'END_DATE_REQUESTED',
            'req_persons'=>'NO_OF_PERSON_REQUESTED',
            'req_expectedamt'=>'EXPECTED AMOUNT_REQUESTED'
            
        ];
    }
    
        /**
         * @inheritdoc
         */
      
    
    }
      
    

    