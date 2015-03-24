<?php

namespace abhimanyu\installer\controllers;

use abhimanyu\installer\helpers\Configuration;
use abhimanyu\installer\helpers\enums\Configuration as Enum;
use abhimanyu\installer\InstallerModule;
use abhimanyu\installer\models\config\ConfigBasicForm;
use abhimanyu\user\models\Profile;
use abhimanyu\user\models\User;
use Yii;
use yii\caching\DbCache;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ConfigController allows initial configuration of your application.
 * E.g. Name of Network, Root User
 *
 * ConfigController can only run after SetupController wrote the initial
 * configuration.
 *
 * @author Abhimanyu Saharan
 */
class ConfigController extends Controller
{
	public $layout = 'setup';

	/**
	 * Before each config controller action check if
	 *  - Database Connection works
	 *  - Database Migrated Up
	 *  - Not already configured (e.g. update)
	 *
	 * @param $action
	 *
	 * @return bool
	 */
	public function beforeAction($action)
	{
		// Flush caches
		if (Yii::$app->cache) {
			Yii::$app->cache->flush();
		}

		// Check DB Connection
		if (!InstallerModule::checkDbConnection()) {
			return $this->redirect(Yii::$app->urlManager->createUrl('//installer/setup/'));
		}

		// When not at index action, verify that database is not already configured
		if ($action->id != 'finished') {
			if (InstallerModule::isConfigured()) {
				return $this->redirect(Yii::$app->urlManager->createUrl('//installer/config/finished'));
			}
		}

		return TRUE;
	}

	/**
	 * Index is only called on fresh databases, when there are already settings
	 * in database, the user will directly redirected to actionFinished()
	 */
	public function actionIndex()
	{
		if (InstallerModule::checkDbConnection()) {
			$this->setupInitialData();

			return $this->redirect(Yii::$app->urlManager->createUrl('//installer/config/basic'));
		}

		return $this->redirect(Yii::$app->urlManager->createUrl('//installer/setup/database'));
	}

	/**
	 * Setup some initial database settings.
	 *
	 * This will be done at the first step.
	 */
	private function setupInitialData()
	{
		// Get Configuration File
		$config = Configuration::get();

		// Application Title
		Yii::$app->config->set(Enum::APP_NAME, 'Starter Kit');
		// Application Default Backend Theme
		Yii::$app->config->set(Enum::APP_BACKEND_THEME, 'yeti');
		// Application Default Frontend Theme
		Yii::$app->config->set(Enum::APP_FRONTEND_THEME, 'readable');

		// Caching
		Yii::$app->config->set(Enum::CACHE_CLASS, DbCache::className());

		// Admin
		Yii::$app->config->set(Enum::ADMIN_INSTALL_ID, md5(uniqid('', TRUE)));

		// Basic
		Yii::$app->config->set(Enum::APP_TOUR, TRUE);

		// Yii2-User
		Yii::$app->config->set(Enum::USER_REGISTRATION, 1);
		Yii::$app->config->set(Enum::USER_PASSWORD_RESET_TOKEN_EXPIRE, 86400);
		Yii::$app->config->set(Enum::USER_FORGOT_PASSWORD, 1);
		Yii::$app->config->set(Enum::REMEMBER_ME_DURATION, 3600);

		// Mailer
		Yii::$app->config->set(Enum::MAILER_USE_TRANSPORT, $config['params']['installer']['mail']['useTransport']);
		Yii::$app->config->set(Enum::MAILER_HOST, $config['params']['installer']['mail']['transport']['host']);
		Yii::$app->config->set(Enum::MAILER_USERNAME, $config['params']['installer']['mail']['transport']['username']);
		Yii::$app->config->set(Enum::MAILER_PASSWORD, $config['params']['installer']['mail']['transport']['password']);
		Yii::$app->config->set(Enum::MAILER_PORT, $config['params']['installer']['mail']['transport']['port']);
		Yii::$app->config->set(Enum::MAILER_ENCRYPTION, $config['params']['installer']['mail']['transport']['encryption']);

		// Authentication Clients
		Yii::$app->config->set(Enum::GOOGLE_AUTH, NULL);
		Yii::$app->config->set(Enum::GOOGLE_CLIENT_ID, NULL);
		Yii::$app->config->set(Enum::GOOGLE_CLIENT_SECRET, NULL);

		Yii::$app->config->set(Enum::FACEBOOK_AUTH, NULL);
		Yii::$app->config->set(Enum::FACEBOOK_CLIENT_ID, NULL);
		Yii::$app->config->set(Enum::FACEBOOK_CLIENT_SECRET, NULL);

		Yii::$app->config->set(Enum::LINKED_IN_AUTH, NULL);
		Yii::$app->config->set(Enum::LINKED_IN_CLIENT_ID, NULL);
		Yii::$app->config->set(Enum::LINKED_IN_CLIENT_SECRET, NULL);

		Yii::$app->config->set(Enum::GITHUB_AUTH, NULL);
		Yii::$app->config->set(Enum::GITHUB_CLIENT_ID, NULL);
		Yii::$app->config->set(Enum::GITHUB_CLIENT_SECRET, NULL);

		Yii::$app->config->set(Enum::LIVE_AUTH, NULL);
		Yii::$app->config->set(Enum::LIVE_CLIENT_ID, NULL);
		Yii::$app->config->set(Enum::LIVE_CLIENT_SECRET, NULL);

		Yii::$app->config->set(Enum::TWITTER_AUTH, NULL);
		Yii::$app->config->set(Enum::TWITTER_CONSUMER_KEY, NULL);
		Yii::$app->config->set(Enum::TWITTER_CONSUMER_SECRET, NULL);
	}

	public function actionBasic()
	{
		$form = new ConfigBasicForm();
		$form->name = Yii::$app->config->get(Enum::APP_NAME);
		$form->email = Yii::$app->config->get(Enum::ADMIN_EMAIL);

		if ($form->load(Yii::$app->request->post())) {
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;

				return ActiveForm::validate($form);
			}

			if ($form->validate()) {
				// Set some default settings
				Yii::$app->config->set([
					Enum::APP_NAME    => $form->name,
					Enum::ADMIN_EMAIL => $form->email
				]);

				return $this->redirect(Yii::$app->urlManager->createUrl('//installer/config/admin'));
			}
		}

		return $this->render('basic', ['model' => $form]);
	}

	/**
	 * Setup Administrative User
	 *
	 * This should be the last step, before the user is created also the
	 * application secret will created.
	 */
	public function actionAdmin()
	{
		$model = new User();
		$profile = new Profile();

		$model->scenario = 'register';

		if ($model->load(Yii::$app->request->post())) {
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;

				return ActiveForm::validate($model);
			}

			if ($model->register(TRUE))
				return $this->redirect(Yii::$app->urlManager->createUrl('//installer/config/finished'));
		}

		return $this->render('admin', ['model' => $model, 'profile' => $profile]);
	}

	/**
	 * Last Step, finish up the installation
	 */
	public function actionFinished()
	{
		// Rewrite whole configuration file, also sets application
		// in installed state.
		Configuration::rewriteConfiguration();

		// Set to installed
		InstallerModule::setInstalled();

		return $this->render('finished');
	}
}
