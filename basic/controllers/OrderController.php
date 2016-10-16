<?php

namespace app\controllers;
require_once(\Yii::getAlias('@lib'). '/shipStation/ShipStationVendor.php');
require_once(\Yii::getAlias('@lib'). '/EmbroideryOptions.php');

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class OrderController extends Controller
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
          'save'   => ['post']
        ],
      ],
    ];
  }

  public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
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
  public function actionConfirm()
  {
    $ref = trim(\Yii::$app->request->getQueryParam('ref'));
    $shipStation = new \ShipStationVendor();
    $embroideryOptions = new \EmbroideryOptions();
    $orderId = Yii::$app->request->get('id');
    $order = $shipStation->getOrder($orderId);
    $error = null;
    if(!is_array($order['tagIds']) || !in_array($shipStation->confirmedTag, $order['tagIds']) || $ref == 'admin') {
      foreach ($order['items'] as $key => $item) {
        if (isset($embroideryOptions->options[strtolower(trim($item['options'][0]['value']))])) {
          $order['items'][$key]['optionElements'] = $embroideryOptions->options[strtolower(trim($item['options'][0]['value']))];
        } else if (trim($item['options'][0]['value']) == 'Non-embroidered') {
          $order['items'][$key]['optionElements'] = [];
        } else {
          //do nothing for now
        }
      }
    }else{
      $error = "This order has already been confirmed! Please contact us if you have further questions.";
    }
    return $this->render('confirm', [ 'order' => $order, 'error' =>$error ]);
  }

  /**
   * Save action.
   *
   * @return string
   */
  public function actionSave()
  {
    $params = \Yii::$app->request->post();
    $orderId = Yii::$app->request->get('id');
    $shipStation = new \ShipStationVendor();
    $order = $shipStation->getOrder($orderId);
    if(isset($order['orderKey'])){
      $shipStation->updateNotes($order, $params['options']);
      $shipStation->tagOrderAsConfirmed($orderId);
    }
    $this->sendConfirmationEmail($order);
    return $this->render('save', [ 'order' => $order ]);
  }

  private function sendConfirmationEmail($order){
    $customOptions = json_decode($order['internalNotes'],true);
    foreach($order['items'] as $k=>$item){
      if(isset($customOptions[$item['orderItemId']])){
        $order['items'][$k]['customOptions'] = $customOptions[$item['orderItemId']];
      }
    }
    $mail = new \PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP//
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = \Yii::$app->params['smtp']['username'];
    $mail->Password = \Yii::$app->params['smtp']['password'];
    $mail->SetFrom("personalizedtrendsla@gmail.com");
    $mail->Subject = "IMPORTANT!! Request for Etsy order customization details";

    $body = '<p>Dear '. $order['customerUsername'] . ',</p>
        <p>Your order has been successfully completed.  Please view your order summary below.</p>
        <p>ORDER SUMMARY</p>
        <p>Order ID : ' . $order['orderId'] . '</p>
        <p>Order Number : ' . $order['orderNumber']   . '</p>
        <p>Order Status : ' . $order['orderStatus'] . '</p>
        <p>Products :</p>';
    foreach($order['items'] as $no => $product) {
      $body .= $no + 1  . ' . <br/>
        <p>SKU : ' . $product['sku'] . '</p>
        <p>Name :' . $product['name'] . '</p>
        <p>Color-Size : ' . $product['options'][1]['value'] . '</p>
        <p>Embroidery Placement : ' . $product['options'][0]['value'] . '</p>
        <p>Items :</p>';
      if (isset($product['customOptions'])) {
        foreach ($product['customOptions'] as $key => $items) {
          $body .= $key . ' . <br/>';
          foreach ($items as $option => $value) {
            $body .= '<p>' . $option . ' : ' . $value . '</p>';
          }
        }
      }
    }
    $body .=  '<p>If you need change or cancel your order contact us immediately.</p>
        <p>You will be sent an email with the tracking information when your item is shipped.</p>
        <p>Thank you,</p>
        <p>Warm Regards,</p>
        <p>Personalized Trends</p>';
    $mail->Body = $body;
    $mail->AddAddress($order['customerEmail']);

    if(!$mail->Send()) {
      return "Mailer Error: " . $mail->ErrorInfo;
    } else {
      return "Message has been sent";
    }
  }


}
