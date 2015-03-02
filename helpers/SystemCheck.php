<?php

	namespace abhimanyu\installer\helpers;

	use Yii;
	use yii\helpers\Html;

	/**
	 * SelfTest is a helper class which checks all dependencies of the application.
	 *
	 * @since  1.0
	 * @author Abhimanyu Saharan
	 */
	class SystemCheck
	{
		/**
		 * Get Results of the Application SystemCheck.
		 *
		 * Fields
		 *  - title
		 *  - state (OK, WARNING or ERROR)
		 *  - hint
		 *
		 * @return Array
		 */
		public static function getResults()
		{
			/**
			 * ['title']
			 * ['state']    = OK, WARNING, ERROR
			 * ['hint']
			 */
			$checks = [];

			// Checks PHP Version
			$title = 'PHP - Version - ' . PHP_VERSION;

			# && version_compare(PHP_VERSION, '5.9.0', '<')
			if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} elseif (version_compare(PHP_VERSION, '5.3.0', '<=')) {
				$checks[] = [
					'title' => $title,
					'state' => 'ERROR',
					'hint'  => 'Minimum 5.4'
				];
			}

			// PDO extension
			$title = 'PDO extension';
			if (extension_loaded('pdo')) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} else {
				$checks[] = [
					'title' => $title,
					'state' => 'ERROR',
					'hint'  => 'Install PDO Extension'
				];
			}

			// PDO MySQL extension
			$title = 'PDO MySQL extension';
			if (extension_loaded('pdo_mysql')) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} else {
				$checks[] = [
					'title' => $title,
					'state' => 'ERROR',
					'hint'  => 'Required by database'
				];
			}

			// Checks GD Extension
			$title = 'PHP - GD Extension';
			if (function_exists('gd_info')) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} else {
				$checks[] = [
					'title' => $title,
					'state' => 'ERROR',
					'hint'  => 'Install GD Extension'
				];
			}

			// PHP SMTP
			$title = 'PHP Mail SMTP';
			if (strlen(ini_get('SMTP')) > 0) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} else {
				$checks[] = [
					'title' => $title,
					'state' => 'WARNING',
					'hint'  => 'SMTP is required to send mails'
				];
			}

			// Checks Writable Config
			$title      = 'Permissions - Config';
			$configFile = dirname(Yii::$app->params['dynamicConfigFile']);
			if (is_writeable($configFile)) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} else {
				$checks[] = [
					'title' => $title,
					'state' => 'ERROR',
					'hint'  => 'Make ' . $configFile . " writable"
				];
			}

			// Check Runtime Directory
			$title = 'Permissions - Runtime';
			if (is_writable(Yii::$app->runtimePath)) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} else {
				$checks[] = [
					'title' => $title,
					'state' => 'ERROR',
					'hint'  => 'Make ' . Yii::$app->runtimePath . ' writable'
				];
			}

			// Check COM support
			$title = 'PHP COM Support';
			if (extension_loaded('com_dotnet')) {
				$checks[] = [
					'title' => $title,
					'state' => 'OK'
				];
			} else {
				$checks[] = [
					'title' => $title,
					'state' => 'ERROR',
					'hint'  => 'Install COM extension - ' . Html::a('COM Support', 'http://php.net/manual/en/book.com
					.php', ['target' => 'blank'])
				];
			}

			return $checks;
		}
	}