<?php

namespace app\controllers;

require_once(\Yii::getAlias('@lib'). '/shipStation/ShipStationVendor.php');
require_once(\Yii::getAlias('@lib'). '/EmbroideryOptions.php');

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class AdminController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
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
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
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
  public function actionIndex()
  {
    return $this->render('index');
  }

  /**
   * Confirm action.
   *
   * @return string
   */
  public function actionOrders()
  {
    $shipStation = new \ShipStationVendor();
    $date = new \DateTime();
    $date->sub(new \DateInterval('P1D'));
    $yesterday = $date->format('Y-m-d');
    $respond = $shipStation->getOrders(['orderDateStart' => $yesterday]);

    foreach($respond['orders'] as $key => $order){
      $customOptions = json_decode($order['internalNotes'],true);
      foreach($order['items'] as $k=>$item){
        if(isset($customOptions[$item['orderItemId']])){
          $respond['orders'][$key]['items'][$k]['customOptions'] = $customOptions[$item['orderItemId']];
        }
      }
    }

    return $this->render('orders', [ 'orders' => $respond['orders'] ]);
  }

  /**
   * Confirm action.
   *
   * @return string
   */
  public function actionSearch()
  {
    $orderNumber = trim(\Yii::$app->request->getQueryParam('orderNumber'));
    if($orderNumber){
      $shipStation = new \ShipStationVendor();
      $respond = $shipStation->getOrders(['orderNumber' => $orderNumber]);
      if(isset($respond['orders'])){
        foreach($respond['orders'] as $key => $order){
          $customOptions = json_decode($order['internalNotes'],true);
          foreach($order['items'] as $k=>$item){
            if(isset($customOptions[$item['orderItemId']])){
              $respond['orders'][$key]['items'][$k]['customOptions'] = $customOptions[$item['orderItemId']];
            }
          }
        }
        $order = $respond['orders'][0];
      }
    }
    return $this->render('order', [ 'order' => $order ]);
  }


}
