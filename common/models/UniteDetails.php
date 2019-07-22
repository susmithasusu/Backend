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
class UniteDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    // public $flag;
    public static function tableName()
    {
        return 'user_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_name','total_members','house_name','house_owner','member1','member2','member3'], 'required'],
            [['total_members'], 'integer'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [  
            'user_id'=>'USER_ID',
            'unit_name'=> 'UNIT_NAME',
            'total_members'=>'TOTAL_MEMBERS',
            'house_name'=>'HOUSE_NAME',
            'member1'=>'MEMBER1',
            'member2'=>'MEMBER2',
            'member3'=>'MEMBER3',
            
            
            
        ];
    }
    
        /**
         * @inheritdoc
         */
      
    static public function search($params){

        // $search = Yii::$app->getRequest()->getQueryParam('search');

        $search = Yii::$app->getRequest()->getQueryParam('search');

        if(isset($search)){
            $param = $search;
        }
        
        $query = UniteDetails::find()->where(['unit_name' =>$search])->one();


                    // ->select(['unit_name'])
                    // ->asArray(true);

                    // if(isset($params['unit_name'])){
                    //     $query->andFilterWhere(['like','unit_name', $params['unit_name']]);
                    // }

                    // return [
                           
                    //     'data' =>$query->all()
                    // ];
                    Yii::$app->api->sendSuccessResponse($query);


    }

    
    }
      
    

    