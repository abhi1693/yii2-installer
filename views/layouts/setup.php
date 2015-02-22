<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 12:36
	 */

	use abhimanyu\installer\assets\AppAsset;
	use abhimanyu\installer\InstallerModule;
	use yii\helpers\Html;

	/* @var $this \yii\web\View */
	/* @var $content string */

	AppAsset::register($this);
?>
<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode('Setup Wizard') ?></title>
		<?php $this->head() ?>
	</head>

	<body>
	<?php $this->beginBody() ?>
	<div class="container"
	     style="margin: 0 auto;max-width: 700px;padding-top: 80px;">
		<?= $content ?>

		<div class="text">
			<p class="pull-left"><?= InstallerModule::poweredBy() ?></p>

			<p class="pull-right">Created
				By <?= Html::mailto(InstallerModule::getAuthor(), InstallerModule::getAuthorEmail()) ?></p>
		</div>
	</div>

	<?php $this->endBody() ?>
	</body>
	</html>
<?php $this->endPage() ?>