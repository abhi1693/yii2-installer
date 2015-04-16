<?php
/**
 * Created by PhpStorm.
 * User: Abhimanyu
 * Date: 4/16/2015
 * Time: 11:10 AM
 */

use abhimanyu\installer\models\config\RecaptchaForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model  RecaptchaForm */

?>

<div id="recaptcha-form" class="panel panel-default">
	<div class="panel-heading">
		<h2 class="text-center">Recaptcha Configuration!</h2>
	</div>
	<div class="panel-body">
		<?= $form = ActiveForm::begin([]) ?>

		<div class="form-group">
			<?= $form->field($model, 'siteKey')->textInput(
				[
					'class'        => 'form-control',
					'autofocus'    => 'on',
					'autocomplete' => 'off'
				]
			) ?>
		</div>

		<div class="form-group">
			<?= $form->field($model, 'secret')->textInput(
				[
					'class'        => 'form-control',
					'autocomplete' => 'off'
				]
			) ?>
		</div>

		<hr>

		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>

		<?= $form::end() ?>
	</div>
</div>