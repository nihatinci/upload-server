<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Locations;
use app\models\Users;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{
  public $firstName;
  public $lastName;
  public $title;
  public $companyName;
  public $password;
  public $confirmPassword;
  public $locationName;
  public $locationType;
  public $address1;
  public $address2;
  public $city;
  public $state;
  public $country;
  public $zip;
  public $phone;
  public $alternatePhone;
  public $fax;
  public $email;
  public $secretQuestion;
  public $secretAnswer;

  private $_user = false;


  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [
      // username and password are both required
      [['firstName', 'lastName', 'companyName', 'password', 'confirmPassword', 'lastName', 'address1', 'city', 'state', 'country', 'zip', 'phone', 'email', 'secretQuestion', 'secretAnswer'], 'required'],
      [['password', 'confirmPassword'], 'validatePassword'],
      [['email'], 'email']
    ];
  }

  /**
   * Validates the password.
   * This method serves as the inline validation for password.
   *
   * @param string $attribute the attribute currently being validated
   * @param array $params the additional name-value pairs given in the rule
   */
  public function validatePassword($attribute, $params)
  {

    if (!$this->hasErrors()) {
      if ($this->password != $this->confirmPassword) {
        $this->addError($attribute, 'Password doesn\'t match');
      }
    }
  }

  /**
   * Logs in a user using the provided username and password.
   * @return boolean whether the user is logged in successfully
   */
  public function register()
  {
    if ($this->validate()) {
      $post = \Yii::$app->request->post();
      $params = $post['RegistrationForm'];
      $location = new Locations();
      $location->setAttributes([
        'locationName' => $params['locationName'],
        'address1' => $params['address1'],
        'address2' => $params['address1'],
        'city' => $params['city'],
        'stateId' => $params['state'],
        'zip' => $params['zip'],
        'locationTypeId' => $params['locationType']
      ]);
      if($location->save()){
        $user = new Users();
        $user->setAttributes([
          'username' => $params['email'],
          'password' => $params['password'],
          'email' => $params['email'],
          'firstName' => $params['firstName'],
          'lastName' => $params['lastName'],
          'title' => $params['title'],
          'companyName' => $params['companyName'],
          'phone' => $params['phone'],
          'alternatePhone' => $params['alternatePhone'],
          'fax' => $params['fax'],
          'secretQuestionId' => $params['secretQuestion'],
          'secretAnswer' => $params['secretAnswer'],
          'locationId' => $location->id,
        ]);
        if($user->save()){
          $this->sendRegistrationEmail($user, $location);
          return true;
        }else{
          return false;
          //var_dump($user->getErrors());
        }
      }else{
        //var_dump($location->getErrors());
        return false;
      }
      return Yii::$app->user->register($this->params);
    }
    return false;
  }

  /**
   * Finds user by [[username]]
   *
   * @return User|null
   */
  public function getUser()
  {
    if ($this->_user === false) {
      $this->_user = User::findByUsername($this->username);
    }

    return $this->_user;
  }

  private function sendRegistrationEmail($user, $location){
    $mail = new \PHPMailer(); // create a new object
    $mail->IsHTML(true);
    $mail->Username = \Yii::$app->params['smtp']['username'];
    $mail->Password = \Yii::$app->params['smtp']['password'];
    $mail->SetFrom("nihatinci@gmail.com");
    $mail->Subject = "Eastside Print Co user account information for {$user->firstName} {$user->lastName}";

    $body = '<p>Thank you for registering with the Eastside Print Co . We look forward to your visits and we hope you find our site useful and informative.</p>';
    $body.= "<table>
    <tr><td>Name</td><td>{$user->lastName} {$user->firstName}</td>
    <tr><td>Title</td><td>{$user->title}</td>
    <tr><td>Company Name</td><td>{$user->companyName}</td>
    <tr><td>Address 1</td><td>{$location->address1}</td>
    <tr><td>Address 2</td><td>{$location->address2}</td>
    <tr><td>City/State/Zip</td><td>{$location->city} / {$location->state->state} / {$location->zip}</td>
    <tr><td>Phone</td><td>{$user->phone}</td>
    <tr><td>Alternate Phone</td><td>{$user->alternatePhone}</td>
    <tr><td>Fax</td><td>{$user->fax}</td>
    <tr><td>Email</td><td>{$user->email}</td>
    <tr><td>Password</td><td>{$user->password}</td>
    <tr><td>Secret Question</td><td>{$user->secretQuestion->question}</td>
    <tr><td>Secret Question Answer</td><td>{$user->secretAnswer}</td>";
    $mail->Body = $body;
    $mail->AddAddress($user->email);

    if(!$mail->Send()) {
      return "Mailer Error: " . $mail->ErrorInfo;
    } else {
      return "Message has been sent";
    }
  }



}
