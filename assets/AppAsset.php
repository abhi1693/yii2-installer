<?php
	/**
	 * Created by PhpStorm.
	 * User: Abhimanyu
	 * Date: 08-02-2015
	 * Time: 12:44
	 */

	namespace abhimanyu\installer\assets;

	use Yii;
	use yii\web\AssetBundle;

	class AppAsset extends AssetBundle
	{
		public $basePath = '@webroot';
		public $baseUrl  = '@web/assets_b';
		public $css      = [
			'font-awesome/css/font-awesome.min.css',
			'css/site.css'
		];
		public $js       = [
		];
		public $depends  = [
			'yii\web\YiiAsset',
			'yii\bootstrap\BootstrapAsset',
		];
	}