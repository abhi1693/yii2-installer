<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 09-02-2015
	 * Time: 22:05
	 */

	/** @var $model \abhimanyu\installer\models\setup\MailerForm */
?>
<div id="mailer-form" class="panel panel-default">
	<div class="panel-heading">
		<h2 class="text-center">Mailer Configuration!</h2>
	</div>
	<div class="panel-body">
		<p>Below you have to enter your mailer details. If you’re not sure about these, please contact your
			administrator or web host.</p>

		<?php
			$form = \yii\widgets\ActiveForm::begin([
				                                       'id'                   => 'mailer-form',
				                                       'enableAjaxValidation' => FALSE,
			                                       ]);
		?>

		<div class="form-group">
			<?=
				$form->field($model, 'host')->textInput([
					                                        'autofocus'    => 'on',
					                                        'autocomplete' => 'off',
					                                        'class'        => 'form-control'
				                                        ])->hint('You should be able to get this info from your web host.') ?>
		</div>

		<hr/>

		<div class="form-group">
			<?=
				$form->field($model, 'username')->textInput([
					                                            'autocomplete' => 'off',
					                                            'class'        => 'form-control'
				                                            ]) ?>
		</div>

		<div class="form-group">
			<?=
				$form->field($model, 'password')->passwordInput([
					                                                'class' => 'form-control'
				                                                ])->hint('Your Email\'s password') ?>
		</div>

		<div class="form-group">
			<?=
				$form->field($model, 'password_confirm')->passwordInput([
					                                                        'class' => 'form-control'
				                                                        ]) ?>
		</div>

		<hr>

		<div class="form-group">
			<?=
				$form->field($model, 'port')->textInput([
					                                        'autocomplete' => 'off',
					                                        'class'        => 'form-control'
				                                        ]) ?>
		</div>

		<div class="form-group">
			<?=
				$form->field($model, 'encryption')->textInput([
					                                              'autocomplete' => 'off',
					                                              'class'        => 'form-control'
				                                              ])->hint('e.g. tls') ?>
		</div>

		<div class="form-group">
			<?= $form->field($model, 'useTransport')->checkbox([
				                                                   'class' => 'form-control'
			                                                   ]) ?>
		</div>

		<hr/>

		<?= \yii\helpers\Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>

		<?php \yii\widgets\ActiveForm::end(); ?>
	</div>
</div>