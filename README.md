Yii2-Installer
==============

[![Dependency Status](https://www.versioneye.com/user/projects/54e1e6630a910b6b01000241/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54e1e6630a910b6b01000241)
[![Code Climate](https://codeclimate.com/github/abhi1693/yii2-installer/badges/gpa.svg)](https://codeclimate.com/github/abhi1693/yii2-installer)
[![Latest Stable Version](https://poser.pugx.org/abhi1693/yii2-installer/v/stable.svg)](https://packagist.org/packages/abhi1693/yii2-installer) [![Total Downloads](https://poser.pugx.org/abhi1693/yii2-installer/downloads.svg)](https://packagist.org/packages/abhi1693/yii2-installer) [![Latest Unstable Version](https://poser.pugx.org/abhi1693/yii2-installer/v/unstable.svg)](https://packagist.org/packages/abhi1693/yii2-installer)
Yii2-Installer provides a web interface for advanced access control, user management and includes following features:

**Works only with [Yii2 app advanced startup kit](https://github.com/abhi1693/yii2-app-advanced-startup-kit)**

## Features

- Setup database correctly
- Setup Admin account
- Setup other configurations like:
    - Cache
    - Application Name
    - Admin Email
    - Default Frontend & Backend Theme
- Stores all the configurations in the file as well as the database

## Installation

This document will guide you through the process of installing Yii2-Installer using **composer**.

Add Yii2-installer to the require section of your **composer.json** file:

```php
{
    "require": {
        "abhi1693/yii2-installer": "0.0.3"
    }
}
```

And run following command to download extension using **composer**:

```bash
$ php composer.phar update
```

## Roadmap

- [ ] Documentation
- [ ] Compatibility with other databases
- [x] Auto migrate feature

#### How to contribute?

Contributing instructions are located in [CONTRIBUTING.md](CONTRIBUTING.md) file.

## Change Log

Refer to [Change Logs](CHANGE.md)

## License

Yii2-installer is released under the MIT License. See the bundled [LICENSE](LICENSE.md) for details.
