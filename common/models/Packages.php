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
class Packages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $flag;
    public static function tableName()
    {
        return 'packages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'start','place', 'end','rate'], 'required'],
            [[ 'name', 'start','place', 'end'], 'string', 'max' => 200],
            [[ 'rate'], 'integer'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [      
            'id' => 'ID',
            'name' => 'Name'
          
            
        ];
    }
    
        /**
         * @inheritdoc
         */
      
        static public function search($params)
        {
    
            $page = Yii::$app->getRequest()->getQueryParam('page');
            $limit = Yii::$app->getRequest()->getQueryParam('limit');
            $order = Yii::$app->getRequest()->getQueryParam('order');
    
            $search = Yii::$app->getRequest()->getQueryParam('search');
    
            if(isset($search)){
                $params=$search;
            }
    
            $limit = isset($limit) ? $limit : 10;
            $page = isset($page) ? $page : 1;
            $offset = ($page - 1) * $limit;
            $query = Packages::find()
                ->select(['id','name', 'start','place', 'end','rate'])
                ->asArray(true)
                ->limit($limit)
                ->offset($offset);
    
           
            if(isset($params['name'])) {
                $query->andFilterWhere(['like','name', $params['name']]);
            }
            if(isset($params['place'])) {
                $query->andFilterWhere(['like', 'place', $params['place']]);
            }
            
    
    
            if(isset($order)){
                $query->orderBy($order);
            }
    
    
            $additional_info = [
                'page' => $page,
                'size' => $limit,
                'totalCount' => (int)$query->count()
            ];
    
            return [
                'data' => $query->all(),
                'info' => $additional_info
            ];
        }
    }
      
    

    