<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 13:17
	 */

	namespace abhimanyu\installer\controllers;

	use abhimanyu\installer\helpers\Configuration;
	use abhimanyu\installer\helpers\enums\Configuration as Enum;
	use abhimanyu\installer\helpers\SystemCheck;
	use abhimanyu\installer\InstallerModule;
	use abhimanyu\installer\models\setup\DatabaseForm;
	use abhimanyu\installer\models\setup\MailerForm;
	use Yii;
	use yii\db\Connection;
	use yii\db\Exception;
	use yii\swiftmailer\Mailer;
	use yii\web\Controller;
	use yii\web\Response;
	use yii\widgets\ActiveForm;

	class SetupController extends Controller
	{
		public $layout = 'setup';

		public function beforeAction($action)
		{
			// Checks if application has been installed successfully
			if (Yii::$app->params[Enum::APP_INSTALLED]) {
				return $this->redirect(Yii::$app->homeUrl);
			}

			return parent::beforeAction($action);
		}

		public function actionIndex()
		{
			$this->redirect(Yii::$app->urlManager->createUrl('prerequisites'));
		}

		/**
		 * Prerequisites action checks application requirement using the SystemCheck
		 * Library
		 *
		 * (Step 2)
		 */
		public function actionPrerequisites()
		{
			$checks = SystemCheck::getResults();

			$hasError = FALSE;
			foreach ($checks as $check) {
				if ($check['state'] == 'ERROR')
					$hasError = TRUE;
			}

			// Render template
			return $this->render('prerequisites', ['checks' => $checks, 'hasError' => $hasError]);
		}

		/**
		 * Database action is responsible for all database related stuff.
		 * Checking given database settings, writing them into a config file.
		 *
		 * (Step 3)
		 */
		public function actionDatabase()
		{
			$success  = FALSE;
			$errorMsg = '';

			$config = Configuration::get();
			$form   = new DatabaseForm();

			if ($form->load(Yii::$app->request->post())) {
				if (Yii::$app->request->isAjax) {
					Yii::$app->response->format = Response::FORMAT_JSON;

					return ActiveForm::validate($form);
				}


				if ($form->validate()) {
					$dsn = "mysql:host=" . $form->hostname . ";dbname=" . $form->database;
					// Create Test DB Connection
					Yii::$app->set('db', [
						'class'    => Connection::className(),
						'dsn'      => $dsn,
						'username' => $form->username,
						'password' => $form->password,
						'charset'  => 'utf8'
					]);

					try {
						Yii::$app->db->open();
						// Check DB Connection
						if (InstallerModule::checkDbConnection()) {
							// Write Config
							$config['components']['db']['class']    = Connection::className();
							$config['components']['db']['dsn']      = $dsn;
							$config['components']['db']['username'] = $form->username;
							$config['components']['db']['password'] = $form->password;
							$config['components']['db']['charset']  = 'utf8';

							// Write config for future use
							$config['params']['installer']['db']['installer_hostname'] = $form->hostname;
							$config['params']['installer']['db']['installer_database'] = $form->database;
							$config['params']['installer']['db']['installer_username'] = $form->username;

							Configuration::set($config);

							$success = TRUE;

							return $this->redirect(Yii::$app->urlManager->createUrl('//installer/setup/mailer'));
						} else {
							$errorMsg = 'Incorrect configuration';
						}
					} catch (Exception $e) {
						$errorMsg = $e->getMessage();
					}
				}
			} else {
				if (isset($config['params']['installer']['db']['installer_hostname']))
					$form->hostname = $config['params']['installer']['db']['installer_hostname'];

				if (isset($config['params']['installer']['db']['installer_database']))
					$form->database = $config['params']['installer']['db']['installer_database'];

				if (isset($config['params']['installer']['db']['installer_username']))
					$form->username = $config['params']['installer']['db']['installer_username'];
			}

			return $this->render('database', ['model' => $form, 'success' => $success, 'errorMsg' => $errorMsg]);
		}

		/**
		 * @return array|string|\yii\web\Response
		 */
		public function actionMailer()
		{
			$config = Configuration::get();
			$mailer = new MailerForm();
			$mailer->useTransport = Yii::$app->config->get(Enum::MAILER_USE_TRANSPORT) === 'true' ? '1' : '0';

			if ($mailer->load(Yii::$app->request->post())) {
				if (Yii::$app->request->isAjax) {
					Yii::$app->response->format = Response::FORMAT_JSON;

					return ActiveForm::validate($mailer);
				}

				if ($mailer->validate()) {
					if ($mailer->useTransport === '0')
						$mailer->useTransport = FALSE;
					else
						$mailer->useTransport = TRUE;

					// Write Config
					$config['components']['mail']['class']                   = Mailer::className();
					$config['components']['mail']['useTransport']            = $mailer->useTransport;
					$config['components']['mail']['transport']['class']      = 'Swift_SmtpTransport';
					$config['components']['mail']['transport']['host']       = $mailer->host;
					$config['components']['mail']['transport']['username']   = $mailer->username;
					$config['components']['mail']['transport']['password']   = $mailer->password;
					$config['components']['mail']['transport']['port']       = $mailer->port;
					$config['components']['mail']['transport']['encryption'] = $mailer->encryption;

					// Write config for future use
					$config['params']['installer']['mail']['useTransport'] = $mailer->useTransport;
					$config['params']['installer']['mail']['transport']['host']       = $mailer->host;
					$config['params']['installer']['mail']['transport']['username']   = $mailer->username;
					$config['params']['installer']['mail']['transport']['password']   = $mailer->password;
					$config['params']['installer']['mail']['transport']['port']       = $mailer->port;
					$config['params']['installer']['mail']['transport']['encryption'] = $mailer->encryption;

					Configuration::set($config);

					return $this->redirect(Yii::$app->urlManager->createUrl('//installer/setup/init'));
				}
			} else {
				if (isset($config['params']['installer']['mail']['transport']['host']))
					$mailer->host = $config['params']['installer']['mail']['transport']['host'];

				if (isset($config['params']['installer']['mail']['transport']['username']))
					$mailer->username = $config['params']['installer']['mail']['transport']['username'];

				if (isset($config['params']['installer']['mail']['transport']['password']))
					$mailer->password = $config['params']['installer']['mail']['transport']['password'];

				if (isset($config['params']['installer']['mail']['transport']['port']))
					$mailer->port = $config['params']['installer']['mail']['transport']['port'];

				if (isset($config['params']['installer']['mail']['transport']['encryption']))
					$mailer->encryption = $config['params']['installer']['mail']['transport']['encryption'];
			}

			return $this->render('mailer', ['model' => $mailer]);
		}

		/**
		 * The init action imports the database structure & initial data
		 */
		public function actionInit()
		{
			if (!InstallerModule::checkDbConnection())
				Yii::$app->db->open();

			// Flush the caches
			if (Yii::$app->cache) {
				Yii::$app->cache->flush();
			}

			// todo make migration better
			$data = file_get_contents((dirname(__DIR__) . '/migrations/data.sql'));
			Yii::$app->db->createCommand($data)->execute();

			return $this->redirect(Yii::$app->urlManager->createUrl('//installer/config/index'));
		}
	}