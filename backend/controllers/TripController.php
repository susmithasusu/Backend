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
use yii\web\UploadedFile;

 

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
                'exclude' => ['authorize', 'register','create', 'accesstoken','index','list','details','packages','view_package','list_packages','bookingtable','contactlist','viewtrip','custometrip','agency','mycustometrips','customdelete','cancelmytrip','create','testemail','sendmsg','otp','list_outofstock','add','category','viewcategory','booking','products'],
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
                    'products'=>['GET'],
                    'category'=>['POST'],
                    'viewcategory'=>['GET'],
                    'booking'=>['GET']
                   

                   
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

            // base64 decoding and image saved in folder
            $model = new AddProduct();
            $model->attributes = $this->request;
            $content = base64_decode($this->request['product_image']);
            $image = $this->request['product_image'];
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('','+',$image);
            $data = base64_decode($image);
            $imageName = 'img_'.$this->request['product_name'].'.'.'png';
            $img = \Yii::$app->basePath.'\web\uploads'.$imageName;
            $new_img=Yii::$app->urlManager->createabsoluteUrl('uploads').'/'.$imageName;
            file_put_contents(\Yii::$app->basePath.'\web\uploads\''.$imageName,$data);
            exec('sudo chmod' .Yii::$app->basePath.'\web\uploads\''.$imageName.'777');
            $model->category_name = $this->request['category_name'];
            $model->product_name = $this->request['product_name'];
            $model->product_image =  $imageName;
            $model->product_description = $this->request['product_description'];
            $model->product_price = $this->request['product_price'];
            $model->product_fine = $this->request['product_fine'];
            $model->total_products = $this->request['total_products'];
            $model->save();         
            if ($model->save()) {
                // $model->product_image = $new_img;
                Yii::$app->api->sendSuccessResponse($model->attributes);
            } else {
                Yii::$app->api->sendFailedResponse($model->errors);
            }
        }

        public function actionProducts()
        {
             
             $model = AddProduct::find()->all();
             return[
                 'products'=>$model,
             ];
       
             if($model){
                Yii::$app->api->sendSuccessResponse($model);
             }
             else{
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


        public function actionViewcategory()
        {

            $view = AddCategory::find()->all(); 
            if(!$view){
                Yii::$app->api->sendFailedResponse($view);
            }
            else{
                  Yii::$app->api->sendSuccessResponse($view);
            }
        }

        public function actionBooking($id){

            $model = BookingTable::findone($id);

            if(!$model){
                Yii::$app->api->sendFailedResponse($model);
            }
            else{
                Yii::$app->api->sendSuccessResponse($model);
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
