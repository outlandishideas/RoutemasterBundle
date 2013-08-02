Routemaster Bundle for WordPress
================================

**Use WordPress as the CMS backend for your Symfony application.**

Install
-------

### Add to `composer.json`

	"require": {
	    "outlandish/oowp": "dev-master",
	},
	"repositories": [
	    {
	        "type": "vcs",
	        "url": "ssh://tsr@beta.gd:7777/var/projects/lib/oowp.git"
	    }
	]

### Add WordPress installer script (optional)

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

### Run `composer update`

### Add to `AppKernel.php`

	public function registerBundles()
	{
	    $bundles = array(
	        new Outlandish\RoutemasterBundle\RoutemasterBundle(),
	    );

	    return $bundles;
	}

### Load WordPress in your front controller

	<?php

	use Symfony\Component\Debug\ExceptionHandler;
	use Symfony\Component\HttpFoundation\Request;

	//load WordPress
	require 'wp-load.php';

	require_once __DIR__ . '/../app/autoload.php';
    require_once __DIR__ . '/../app/AppKernel.php';

	...
