<?php
	/** @var $model */
?>
<div id="create-admin-account-form" class="panel panel-default">
	<div class="text-center">
		<h2 class="panel-heading">Admin Account</h2>
	</div>

	<div class="panel-body">
		<p>You're almost done. In the last step you have to fill out the form to create an admin account. With this
			account you can manage the whole website.</p>
		<hr/>
		<?php $form = \yii\widgets\ActiveForm::begin([
			                                             'id'                   => 'admin-form',
			                                             'enableAjaxValidation' => TRUE
		                                             ]); ?>
		<div class="form-group">
			<?= $form->field($model, 'username')->textInput([
				                                                'class'        => 'form-control',
				                                                'autofocus'    => 'on',
				                                                'autocomplete' => 'off'
			                                                ]) ?>
		</div>

		<div class="form-group">
			<?= $form->field($model, 'email')->textInput([
				                                             'class'        => 'form-control',
				                                             'autocomplete' => 'off'
			                                             ]) ?>
		</div>

		<div class="form-group">
			<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
		</div>

		<div class="form-group">
			<?= $form->field($model, 'password_confirm')->passwordInput([
				                                                            'class'        => 'form-control',
				                                                            'autocomplete' => 'off'
			                                                            ]) ?>
		</div>

		<hr>

		<?= \yii\helpers\Html::submitButton('Create Admin Account', ['class' => 'btn btn-primary']) ?>

		<?php $form::end(); ?>

	</div>
</div>