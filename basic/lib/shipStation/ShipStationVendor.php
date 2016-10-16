<?php
require_once(\Yii::getAlias('@lib'). '/shipStation/base/ShippingVendor.php');

class ShipStationVendor extends ShippingVendor{

  public $storeId;
  public $processedTag = 37872;
  public $embroideryTag = 12613;
  public $confirmedTag = 37992;

  public function __construct(){
    if(!isset(Yii::$app->params['shipstation'])){
      throw new \Exception('Shipstation does not have config', 500);
    }else{
      $shipConfig = Yii::$app->params['shipstation'];
    }
    $this->setApiUrl($shipConfig['url']);
    $this->setCredentials($shipConfig['apiKey'], $shipConfig['apiSecret']);
    $this->storeId = $shipConfig['storeId'];
    parent::__construct();
  }

  public function getOrders($params=[]){
    $path = 'orders';
    $params['storeId'] = $this->storeId;
    return $this->send($path, $params);
  }

  public function getOrder($orderId){
    $path = 'orders/' . $orderId;
    return $this->send($path);
  }

  public function getStores(){
    $path = 'stores';
    //$params = [$search];
    return $this->send($path);
  }

  public function getTags(){
    $path = 'accounts/listTags';
    return $this->send($path);
  }

  public function tagOrderAsProcessed($orderId){
    $method = 'POST';
    $path = 'orders/addtag';
    $params = ['orderId' => $orderId, 'tagId' => $this->processedTag];
    return $this->send($path, $params, $method);
  }

  public function tagOrderAsEmroidery($orderId){
    $method = 'POST';
    $path = 'orders/addtag';
    $params = ['orderId' => $orderId, 'tagId' => $this->embroideryTag];
    return $this->send($path, $params, $method);
  }

  public function tagOrderAsConfirmed($orderId){
    $method = 'POST';
    $path = 'orders/addtag';
    $params = ['orderId' => $orderId, 'tagId' => $this->confirmedTag];
    return $this->send($path, $params, $method);
  }

 
  public function updateNotes($order, $notes){
    $method = 'POST';
    $path = 'orders/createorder';
    $order['internalNotes'] = json_encode($notes);
    $giftmessage = '';
    foreach($order['items'] as $product){
      $giftmessage .= $product['options'][1]['name'].':'.$product['options'][1]['value']."<br>";
      $items  = $notes[$product['orderItemId']];
      foreach($items as $key=>$item){
        $giftmessage .= 'item ' . $key . ":<br>";
        foreach($item as $option=>$value){
          $giftmessage .= $option . ':' . $value . "<br>";
        }
      }
    }
    $order['giftMessage'] = $giftmessage;
    $params = $order;
    return $this->send($path, $params, $method);
  }

  public function updateStatus($order, $status){
    $method = 'POST';
    $path = 'orders/createorder';
    $order['orderStatus'] = $status;
    $params = $order;
    return $this->send($path, $params, $method);
  }




}


?>
