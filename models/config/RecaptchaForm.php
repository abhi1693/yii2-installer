<?php
/**
 * Created by PhpStorm.
 * User: Abhimanyu
 * Date: 4/16/2015
 * Time: 11:14 AM
 */

namespace abhimanyu\installer\models\config;

use yii\base\Model;

/**
 * Class RecaptchaForm
 * Holds the recaptcha settings
 *
 * @package abhimanyu\installer\models\config
 */
class RecaptchaForm extends Model
{
	public $secret;
	public $siteKey;
	public $debugMode;

	public function rules()
	{
		return [
			// Site Key
			['siteKey', 'required'],
			['siteKey', 'string'],

			// Secret
			['secret', 'required'],
			['secret', 'string'],

			// Debug Mode
			['debugMode', 'boolean']
		];
	}

	public function attributeLabels()
	{
		return [
			'siteKey'   => 'Site Key',
			'secret'    => 'Secret',
			'debugMode' => 'Debug Mode'
		];
	}
}
