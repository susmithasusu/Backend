<?php

namespace backend\models;

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
class Contactus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $flag;
    public static function tableName()
    {
        return 'contact_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'email','phone', 'message'], 'required'],
            ['name','trim'],
    
            [['phone'],'match','pattern'=> '/^[6-9][0-9]{9}$/'],

            ['email','trim'],
            ['email','email'],
            ['email','string','max'=> '200'],
            ['email','unique', 'targetClass' =>'\backend\models\Contactus','message' => 'this email has been already '],

          
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [      
            'name' => 'NAME',
            'email' => 'EMAIL',
            'phone' => 'PHONE',
            'message' => 'MESSAGE',
            
          
            
        ];
    }
    
        /**
         * @inheritdoc
         */
      
    
    }
      
    

    