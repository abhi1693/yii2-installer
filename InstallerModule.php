<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 11:29
	 */
	namespace abhimanyu\installer;

	use abhimanyu\installer\helpers\Configuration;
	use abhimanyu\installer\helpers\enums\Configuration as Enum;
	use Yii;
	use yii\base\Module as BaseModule;
	use yii\db\Exception;
	use yii\helpers\Html;

	class InstallerModule extends BaseModule
	{
		const VERSION = '0.0.4';

		public static function getAuthor()
		{
			return 'Abhimanyu Saharan';
		}

		public static function getAuthorEmail()
		{
			return 'abhimanyu@teamvulcans.com';
		}

		public static function poweredBy($text = '', $url = '')
		{
			if (empty($text)) {
				$text = 'Powered By Startup-Kit - ' . InstallerModule::getVersion();
			}

			if (empty($url)) {
				$url = 'https://github.com/abhi1693/yii2-app-advanced-startup-kit';
			}

			return Html::a(Html::encode($text), $url);
		}

		public static function getVersion()
		{
			return static::VERSION;
		}

		/**
		 * Checks if database connections works
		 *
		 * @return boolean
		 */
		public static function checkDbConnection()
		{
			try {
				// Check DB Connection
				Yii::$app->db->isActive;

				return TRUE;
			} catch (Exception $e) {
				print_r($e->getMessage());
			}

			return FALSE;
		}

		/**
		 * Checks if the application is already configured.
		 */
		public static function isConfigured()
		{
			if (Yii::$app->config->get(Enum::APP_SECRET) != '') {
				return TRUE;
			}

			return FALSE;
		}

		/**
		 * Sets application in installed state (disables installer)
		 */
		public static function setInstalled()
		{
			// Set App secret
			Yii::$app->config->set(Enum::APP_SECRET, md5(uniqid(time(), TRUE)));

			$param = Configuration::getParam();
			$param[Enum::APP_INSTALLED] = TRUE;
			Configuration::setParam($param);
		}
	}