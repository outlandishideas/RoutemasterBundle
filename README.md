Routemaster Bundle for WordPress
================================

**Use WordPress as the CMS backend for your Symfony application.**

Installation
------------

### 1. Add to `composer.json`

	"require": {
	    "outlandish/routemaster-bundle": "dev-master",
	},
	"repositories": [
	    {
	        "type": "vcs",
	        "url": "https://github.com/outlandishideas/RoutemasterBundle.git"
	    }
	]

### 2. Add WordPress installer script

Until a way is found to allow Composer to install and manage WordPress, this script can be used
to ensure WordPress is present:

	"scripts": {
	    "post-install-cmd": [
		    "Outlandish\\RoutemasterBundle\\Composer\\WordPressInstaller::install"
	    ],
	    "post-update-cmd": [
	        "Outlandish\\RoutemasterBundle\\Composer\\WordPressInstaller::install"
	    ]
	},

### 3. Run `composer update`

### 4. Add to `AppKernel.php`

	public function registerBundles()
	{
	    $bundles = array(
			//...
	        new Outlandish\RoutemasterBundle\RoutemasterBundle(),
	    );

	    return $bundles;
	}

### 5. Load WordPress in your front controller

	<?php

	use Symfony\Component\Debug\ExceptionHandler;
	use Symfony\Component\HttpFoundation\Request;

	//load WordPress
	require 'wp-load.php';

	require_once __DIR__ . '/../app/autoload.php';
    require_once __DIR__ . '/../app/AppKernel.php';

	//...
