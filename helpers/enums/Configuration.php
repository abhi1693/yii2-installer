<?php

	namespace abhimanyu\installer\helpers\enums;

	use abhimanyu\enum\helpers\BaseEnum;

	class Configuration extends BaseEnum
	{
		// Basic Configs
		const APP_NAME           = 'app.name';
		const APP_TOUR           = 'app.tour';
		const APP_SECRET         = 'app.secret';
		const APP_BACKEND_THEME  = 'app.backend.theme';
		const APP_FRONTEND_THEME = 'app.frontend.theme';
		const APP_INSTALLED = 'installed';

		// Cache
		const CACHE_CLASS       = 'cache.class';
		const CACHE_EXPIRE_TIME = 'cache.expireTime';

		// Admin
		const ADMIN_INSTALL_ID = 'admin.installationId';
		const ADMIN_EMAIL      = 'admin.email';

		// Yii2-User
		const USER_REGISTRATION = 'user.enableRegistration';

		// Config File
		const CONFIG_FILE = 'dynamicConfigFile';

		// Migrations Folder
		const MIGRATE_FOLDER = 'migrateFolder';
	}