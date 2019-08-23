<?php
namespace backend\controllers;
use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\AuthorizationCodes;
use common\models\AccessTokens;
use backend\models\SignupForm;
use backend\behaviours\Verbcheck;
use backend\behaviours\Apiauth;
use common\models\User;
use common\models\OutStock;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use bryglen\sendgrid\Mailer;
use backend\models\AddProduct;
use backend\models\AddCategory;

 

/**
 * Site controller
 */
class TripController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['authorize', 'register','create', 'accesstoken','index','list','details','packages','view_package','list_packages','bookingtable','contactlist','viewtrip','custometrip','agency','mycustometrips','customdelete','cancelmytrip','create','testemail','sendmsg','otp','list_outofstock','add','category'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'me'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['authorize', 'register', 'accesstoken'],
                        'allow' => true,
                        'roles' => ['*'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'logout' => ['GET'],
                    'authorize' => ['POST'],
                    'register' => ['POST'],
                    'accesstoken' => ['POST'],
                    'me' => ['GET'],
                    'testemail'=>['POST'],
                    'sendmsg'=>['POST'],
                    'otp'=>['GET'],
                    'add'=>['POST'],
                    'category'=>['POST']
                   

                   
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->api->sendSuccessResponse(['Yii2 RESTful API with OAuth2']);
        //  return $this->render('index');
    }

    public function actionRegister()
    {

          $model = new SignupForm();
          $model->attributes = $this->request;    

        if ($user = $model->signup()) {

            $data=$user->attributes;
            unset($data['auth_key']);
            unset($data['password_hash']);
            unset($data['password_reset_token']);
            unset($data['status']);          
            Yii::$app->api->sendSuccessResponse($data);
            $model->email =$this->request['email'];         
        }
    }

    public function actionAdd(){


            $model = new AddProduct();
            $model->attributes = $this->request;
            $model->save();
            if ($model->save()) {
                Yii::$app->api->sendSuccessResponse($model->attributes);
            } else {
                Yii::$app->api->sendFailedResponse($model->errors);
            }
        }

        public function actionCategory()
        {
            
            $model = new AddCategory();
            $model->attributes = $this->request;
            $model->save();
            if ($model->save()) {
                Yii::$app->api->sendSuccessResponse($model->attributes);
            } else {
                Yii::$app->api->sendFailedResponse($model->errors);
            }

        }
     
       

    
        // $model = new User();
        // $model1=new SignupForm();
        // $data= $this->request;
        // $pass= $this->request['password'];
        // $password = Yii::$app->getSecurity()->generatePasswordHash($pass);
     
        //       $model->name =$this->request['name'];
        //       $model->email =$this->request['email'];
        //       $model->phone =$this->request['phone'];
        //       $model->password_hash =$password;
        //       $model->status = 0;
        //       $model->auth_key = \Yii::$app->security->generateRandomString();
        //       $model->save();
        //       $data= $model->attributes;
        //     Yii::$app->api->sendSuccessResponse($data);

        // }
    
 
// testing emails

   public function actionTestemail()
   {
    Yii::$app->mail->compose()
    ->setFrom([\Yii::$app->params['supportEmail'] => 'alexthanikkal@gmail.com'])
    ->setTo('alexthanikkal@gmail.com')
    ->setSubject('blocked ' )
    ->send();
   }
  
   // sending msg 

   public function actionOtp(){
    $n = 4;
    $generator = "1357902468";
    $result = ""; 
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    // Return result 
    // return $result;
    print_r($result);

} 
  



    public function actionMe()
    {
        $data = Yii::$app->user->identity;
        $data = $data->attributes;
        unset($data['auth_key']);
        unset($data['password_hash']);
        unset($data['password_reset_token']);
        unset($data['status']);

        Yii::$app->api->sendSuccessResponse($data);
    }

    public function actionAccesstoken()
    {  
        // print_r('authcode'); exit();

        if (!isset($this->request["authorization_code"])) {
            Yii::$app->api->sendFailedResponse("Authorization code missing");
        }

        $authorization_code = $this->request["authorization_code"];

        $auth_code = AuthorizationCodes::isValid($authorization_code);
        if (!$auth_code) {
            Yii::$app->api->sendFailedResponse("Invalid Authorization Code");
        }

        $accesstoken = Yii::$app->api->createAccesstoken($authorization_code);
        $username= AuthorizationCodes::find()->where(['code' => $authorization_code])->one(); 
       
        $name=User::find()->where(['id' => $username['user_id']])->one(); 

        $data = [];
        $data['name']=$name['name'];
        $data['id']=$name['id'];
        $data['access_token'] = $accesstoken->token;
        $data['expires_at'] = $accesstoken->expires_at;
        Yii::$app->api->sendSuccessResponse($data);

    }

    public function actionAuthorize()
    {
        $model = new LoginForm();

        $model->attributes = $this->request;
      
        if ($model->validate() && $model->login()) {

            $auth_code = Yii::$app->api->createAuthorizationCode(Yii::$app->user->identity['id']);

            $data = [];
            $data['authorization_code'] = $auth_code->code;
            $data['expires_at'] = $auth_code->expires_at;

            Yii::$app->api->sendSuccessResponse($data);
        } else {
            Yii::$app->api->sendFailedResponse($model->errors);
        }
    }

    public function actionLogout()
    {
        $headers = Yii::$app->getRequest()->getHeaders();
        $access_token = $headers->get('x-access-token');

        if(!$access_token){
            $access_token = Yii::$app->getRequest()->getQueryParam('access-token');
        }

        $model = AccessTokens::findOne(['token' => $access_token]);

        if ($model->delete()) {

            Yii::$app->api->sendSuccessResponse(["Logged Out Successfully"]);

        } else {
            Yii::$app->api->sendFailedResponse("Invalid Request");
        }


    }
   
  
    protected function findmodel($id)
    {
        if (($model = Packages::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Record requested");
        }
    }
    

  
   
}
