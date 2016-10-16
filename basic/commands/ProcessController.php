<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

require_once(\Yii::getAlias('@lib'). '/shipStation/ShipStationVendor.php');
require_once(\Yii::getAlias('@lib'). '/EmbroideryOptions.php');
use yii\console\Controller;

/**
 * This command process orders and sends emails to customers
 *
 * @author Nihat Inci <nihatinci@gmail.com>
 * @since 2.0
 */
class ProcessController extends Controller
{
  /**
   * This command echoes what you have entered as the message.
   * @param string $message the message to be echoed.
   */
  public function actionIndex()
  {
    echo "starting process job .. \n";
    $shipStation = new \ShipStationVendor();
    $date = new \DateTime();
    $date->sub(new \DateInterval('P1D'));
    $yesterday = $date->format('Y-m-d');
    $respond = $shipStation->getOrders(['orderDateStart' => $yesterday, 'orderStatus' => 'on_hold']);
    $flag = false;
    $missing = false;
    $embroideried = false;
    foreach($respond['orders'] as $order){
      if(!is_array($order['tagIds']) || !in_array($shipStation->processedTag, $order['tagIds'])){
        echo $order['orderId'] . " is processing .. \n";
        foreach($order['items'] as $item){
          if(trim($item['options'][0]['value']) !='Non-embroidered'){
            $embroideryOptions = new \EmbroideryOptions();
            if (!isset($embroideryOptions->options[strtolower(trim($item['options'][0]['value']))])) {
              echo "sending option missin error email ...\n";
              $this->sendError($item['options'][0]['value']);
              $missing = true;
            }else{
              $embroideried = true;
              echo "sending email to  ". $order['customerEmail'] ." ... \n";
              $flag = true;
              $this->sendEmail($order);
              $shipStation->tagOrderAsEmroidery($order['orderId']);
              break;
            }
          }
        }
        if($embroideried == false){
          echo "updating status to awaiting_shipment .. \n";
          $orderCheck = $shipStation->getOrder($order['orderId']);
          $shipStation->updateStatus($orderCheck, 'awaiting_shipment');
        }
        if(!$missing){
          $shipStation->tagOrderAsProcessed($order['orderId']);
        }
      }
      /*
      if($flag){
        break;
      }
      */
    }
  }

  private function sendEmail($order){
    $mail = new \PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = \Yii::$app->params['smtp']['username'];
    $mail->Password = \Yii::$app->params['smtp']['password'];
    $mail->SetFrom("personalizedtrendsla@gmail.com");
    $mail->Subject = "IMPORTANT!! Request for Etsy order customization details";
    $mail->Body = '<p>Dear '. $order['customerUsername'] . ',</p>
        </p>
        <p>We are pleased that you have chosen Personalized Trends.
        </p>
        <p>Please click the link below to complete the embroidery details of your order. Your order will be processed after you submit the form.
        </p>
        <p>You will not be able to submit the form unless you give us the complete information for personalization.
        </p>
        <p>Please be sure to review your order and check the information you submit. Your items will be embroidered in the exact order of letters that you provide.
        </p>
        <p>If you need to change the items you ordered, please contact us immediately.
        </p>
        <p><strong>Please click the link below</strong><br> <a href="http://personalizedtrendsla.com/order/confirm/' . $order['orderId'] . '">Confirm your order</a>
        </p>
        <p>Thank you,
        </p>
        <p>Warm Regards,
        </p>';
    $mail->AddAddress($order['customerEmail']);

    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      echo "Message has been sent";
    }
  }

  private function sendError($missingOption){
    $mail = new \PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = \Yii::$app->params['smtp']['username'];
    $mail->Password = \Yii::$app->params['smtp']['password'];
    $mail->SetFrom("personalizedtrendsla@gmail.com");
    $mail->Subject = "Options is missing";
    $mail->Body = '<p>Dear Bilal,</p>
        </p>
        <p>Please add the following option to codebase.
        </p>
        <p><b> ' . $missingOption .' </b>
        </p>
        <p>It will send email to customer when you add it.
        </p>
        <p>Thank you,
        </p>
        <p>Warm Regards,
        </p>';
    $mail->AddAddress("bilalatas@gmail.com");

    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      echo "Message has been sent";
    }
  }

}
