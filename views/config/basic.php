<?php
	/** @var $model \abhimanyu\installer\models\config\ConfigBasicForm */
?>
<div id="name-form" class="panel panel-default">
	<div class="panel-heading">
		<h2 class="text-center">Application's Name</h2>
	</div>

	<div class="panel-body">
		<p>Of course, your new application need a name. Please change the default name with one you like.</p>

		<?php
			$form = \yii\widgets\ActiveForm::begin([
				                                       'id'                   => 'basic-form',
				                                       'enableAjaxValidation' => TRUE,
			                                       ]);
		?>

		<div class="form-group">
			<?=
				$form->field($model, 'name')->textInput([
					                                        'autofocus'    => 'on',
					                                        'autocomplete' => 'off',
					                                        'class'        => 'form-control']) ?>
		</div>

		<div class="form-group">
			<?=
				$form->field($model, 'email')->textInput([
					                                         'autocomplete' => 'off',
					                                         'class'        => 'form-control']) ?>
		</div>

		<hr/>

		<?= \yii\helpers\Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>

		<?php \yii\widgets\ActiveForm::end(); ?>
	</div>
</div>