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

	class InstallerModule extends BaseModule
	{
		/**
		 * Checks if database connections works
		 *
		 * @return boolean
		 */
		public function checkDbConnection()
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
		public function isConfigured()
		{
			if (Yii::$app->config->get('secret') != '') {
				return TRUE;
			}

			return FALSE;
		}

		/**
		 * Sets application in installed state (disables installer)
		 */
		public function setInstalled()
		{
			// Set App secret
			Yii::$app->config->set(Enum::APP_SECRET, md5(uniqid(time(), TRUE)));

			$config                        = Configuration::get();
			$config['params']['installed'] = TRUE;
			Configuration::set($config);
		}
	}