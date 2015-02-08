<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 12:37
	 */

	namespace abhimanyu\installer\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\web\ErrorAction;

	/**
	 * Install Controller shows a simple welcome page.
	 *
	 * @author Abhimanyu Saharan
	 */
	class InstallController extends Controller
	{
		public $layout = 'setup';

		public function actions()
		{
			return [
				'error' => [
					'class' => ErrorAction::className(),
				],
			];
		}

		/**
		 * Initiates application setup
		 */
		public function actionIndex()
		{
			return $this->render('index');
		}

		public function actionGo()
		{
			if (Yii::$app->db->getIsActive())
				$this->redirect(Yii::$app->urlManager->createUrl('//installer/setup/init'));
			else
				$this->redirect(Yii::$app->urlManager->createUrl('//installer/setup/prerequisites'));
		}
	}