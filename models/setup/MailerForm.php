<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 09-02-2015
	 * Time: 19:16
	 */

	namespace abhimanyu\installer\models\setup;

	use yii\base\Model;

	class MailerForm extends Model
	{
		public $host;
		public $username;
		public $password;
		public $password_confirm;
		public $port;
		public $encryption;

		public function rules()
		{
			return [
				// host
				[['host'], 'required'],
				[['host'], 'string', 'max' => 128],

				// username
				[['username'], 'required'],
				[['username'], 'string', 'max' => 255],

				// password
				[['password'], 'required'],
				[['password'], 'string', 'max' => 128],

				// password_confirm
				[['password_confirm'], 'required'],
				[['password_confirm'], 'compare', 'compareAttribute' => 'password'],

				// port
				[['port'], 'required'],
				[['port'], 'integer'],

				// encryption
				[['encryption'], 'string', 'max' => 128]
			];
		}

		public function attributeLabels()
		{
			return [
				'host'             => 'Host',
				'username'         => 'Email/Username',
				'password'         => 'Password',
				'password_confirm' => 'Password Confirm',
				'port'             => 'Port',
				'encryption'       => 'Encryption'
			];
		}
	}