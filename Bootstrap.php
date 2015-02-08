<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 11:38
	 */
	namespace abhimanyu\installer;

	use abhimanyu\installer\helpers\enums\Configuration as Enum;
	use Yii;
	use yii\base\Application;
	use yii\base\BootstrapInterface;

	class Bootstrap implements BootstrapInterface
	{
		/**
		 * Bootstrap method to be called during application bootstrap stage.
		 *
		 * @param Application $app the application currently running
		 */
		public function bootstrap($app)
		{
			if (!Yii::$app->params[Enum::APP_INSTALLED]) {
				Yii::$app->runAction('//installer/install/index');
			}
		}
	}