<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="text-center">Setup Complete</h2>
	</div>
	<div class="panel-body text-center">
		<p class="lead"><strong>Congratulations!</strong> You're done.</p>

		<p>The installation completed successfully! Have fun with your new application.</p>

		<div class="text-center">
			<br/>
			<?= \yii\helpers\Html::a('Sign In', Yii::$app->urlManager->createUrl('//site/index'),
			                         ['class' => 'btn btn-success']) ?>
		</div>
	</div>
</div>