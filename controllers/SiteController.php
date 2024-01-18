<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Labor_info;
use app\models\Service_info;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(){
        return $this->redirect('/tables');
    }

    public function actionTables(){
        if(Yii::$app->session->getFlash('services')){
            $services = Yii::$app->session->getFlash('services');
        }else{
            $services = Service_info::find()->all();
        }
        $labores = Labor_info::find()->all();
        $service = new Service_info();
        $labor = new Labor_info();
        return $this->render("tables", ["labors" => $labores, "services" => $services, "service" => $service, "labor" => $labor]);
    }

    public function actionCreateservice(){
        $service = new Service_info();
        if($service->load(yii::$app->request->post())){
            $service->save();
            return $this->redirect("/tables");
        }
    }

    public function actionCreatelabor(){
        $labor = new Labor_info();
        if($labor->load(yii::$app->request->post())){
            $service = $labor->getServiceInfo()->all();
            // return $this->asJson($service);
            if($service){
                $labor->save();
                return $this->redirect("/tables");
            }else{
                Yii::$app->session->setFlash('message', 'No such service Id');
                return $this->redirect("/tables");
            }
        }
    }

    public function actionDeleteservice($id){
        $service = Service_info::findOne($id);
        $service->delete();
        return $this->redirect("/tables");
    }

    public function actionDeletelabor($id){
        $labor = Labor_info::findOne($id);
        $labor->delete();
        return $this->redirect("/tables");
    }

    public function actionQueryservices1(){
        $services = Service_info::find()->where([">=", "price", "100"])->all();
        Yii::$app->session->setFlash('services', $services);
        return $this->redirect("/tables");
        // return $this->render("tables", ["labors" => $labores, "services" => $services, "service" => $service, "labor" => $labor]);
    }

    public function actionQueryservices2(){
        $services = Service_info::find()
        ->leftJoin("labor_info", "service_info.id = labor_info.service_id")
        ->where(["labor_info.service_id" => null])
        ->all();
        Yii::$app->session->setFlash('services', $services);
        return $this->redirect("/tables");
    }


    public function actionApi(){
        $Labor = Labor_info::findOne(1);
        $service = $Labor->getServiceInfo()->all();
        return $this->asJson($service);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
