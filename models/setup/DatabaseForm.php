<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 13:27
	 */

	namespace abhimanyu\installer\models\setup;

	use Yii;
	use yii\base\Model;

	/**
	 * DatabaseForm holds all required database settings.
	 */
	class DatabaseForm extends Model
	{
		public $hostname;
		public $username;
		public $password;
		public $database;

		public function rules()
		{
			return [
				[['hostname', 'username', 'database'], 'required'],
				[['password'], 'safe']
			];
		}

		public function attributeLabels()
		{
			return [
				'hostname' => 'Hostname',
				'username' => 'Username',
				'password' => 'Password',
				'database' => 'Name of Database'
			];
		}
	}