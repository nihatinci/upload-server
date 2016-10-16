<?php

abstract class ShippingVendor{

  private $username;
  private $password;
  private $apiUrl;
  public $httpClient;

  public function __construct()
  {
    $client = new GuzzleHttp\Client([
      'base_url' => $this->apiUrl,
      'auth' => [$this->username,$this->password],
      'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
    ]);
    $this->setHttpClient($client);
  }

  protected function send($apiPath, $params=[], $method = 'GET'){
    $client = $this->getHttpClient();
    switch($method){
      case 'POST':
        $response = $client->request( 'POST', $this->apiUrl . $apiPath, ['json' => $params]);
        break;
      case "GET":
        $response = $client->request( 'GET', $this->apiUrl . $apiPath, ['query' => $params]);
        break;
    }

    $return = $response->getBody()->getContents();
    return json_decode($return , true);
  }

  public function setHttpClient(GuzzleHttp\Client $client)
  {
    $this->httpClient = $client;
    return $this;
  }

  public function getHttpClient()
  {
    $client = clone $this->httpClient;
    return $client;
  }

  protected function setCredentials($username, $password){
    $this->username = $username;
    $this->password = $password;
  }

  protected function setApiUrl($uri){
    $this->apiUrl = $uri;
  }

  protected function getApiUrl(){
    return $this->apiUrl;
  }

  protected function setApiPath($path){
    $this->apiPath = $path;
  }

  protected function setAccountID($accountID){
    $this->accountID = $accountID;
  }

  protected function getApiPath(){
    return $this->apiPath;
  }

  protected function setRequestParams($method, $params){
    $this->requestParams = [
      'method'  => $method,
      'params'  => $params
    ];
  }

  protected function getRequestParams(){

    return $this->requestParams;
  }

}


?>
