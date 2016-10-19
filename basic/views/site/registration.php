<?php
$this->registerJsFile('@web/js/registration.js',['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-registration">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    We only allow registered users to access this service. If you wish to access this service please fill out the registration form below.
    You will then be able to logon to our services using your e-mail or user number and password.</p>

  <?php $form = ActiveForm::begin([
    'id' => 'registration-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
      'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
      'labelOptions' => ['class' => 'col-lg-2 control-label'],
    ],
  ]); ?>

  <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]) ?>

  <?= $form->field($model, 'lastName')->textInput() ?>

  <?= $form->field($model, 'title')->textInput() ?>

  <?= $form->field($model, 'companyName')->textInput() ?>

  <?= $form->field($model, 'password')->passwordInput() ?>

  <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

  <?= $form->field($model, 'locationName')->textInput() ?>

  <?= $form->field($model, 'locationType')->dropDownList($locationTypes) ?>

  <?= $form->field($model, 'address1')->textInput() ?>

  <?= $form->field($model, 'address2')->textInput() ?>

  <?= $form->field($model, 'city')->textInput() ?>

  <?php
  foreach($states as $countryId=>$sts){
    echo $form->field($model, 'state')->dropDownList($sts, ['id' => $countryId]);
  }
  ?>

  <?= $form->field($model, 'country')->dropDownList($countries) ?>

  <?= $form->field($model, 'zip')->textInput() ?>

  <?= $form->field($model, 'phone')->textInput() ?>

  <?= $form->field($model, 'alternatePhone')->textInput() ?>

  <?= $form->field($model, 'fax')->textInput() ?>

  <?= $form->field($model, 'email')->textInput() ?>

  <?= $form->field($model, 'secretQuestion')->dropDownList($secretQuestions) ?>

  <?= $form->field($model, 'secretAnswer')->textInput() ?>



  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-11">
      <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
    </div>
  </div>

  <?php ActiveForm::end(); ?>
</div>
