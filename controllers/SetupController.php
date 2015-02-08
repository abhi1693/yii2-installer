<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 13:17
	 */

	namespace abhimanyu\installer\controllers;

	use abhimanyu\installer\helpers\Configuration;
	use abhimanyu\installer\helpers\SystemCheck;
	use abhimanyu\installer\InstallerModule;
	use abhimanyu\installer\models\setup\DatabaseForm;
	use Yii;
	use yii\db\Connection;
	use yii\db\Exception;
	use yii\web\Controller;
	use yii\web\Response;
	use yii\widgets\ActiveForm;

	class SetupController extends Controller
	{
		public $layout = 'setup';

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

							$config['params']['installer']['db']['installer_hostname'] = $form->hostname;
							$config['params']['installer']['db']['installer_database'] = $form->database;
							$config['params']['installer']['db']['installer_username'] = $form->username;

							Configuration::set($config);
							$success = TRUE;

							return $this->redirect(Yii::$app->urlManager->createUrl('//installer/setup/init'));
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

			//todo Migrate Up the Database

			return $this->redirect(Yii::$app->urlManager->createUrl('//installer/config/index'));
		}
	}