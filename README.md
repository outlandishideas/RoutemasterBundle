Routemaster Bundle for WordPress
================================

**Use WordPress as the CMS backend for your Symfony application.**

**NOTE**: Currently assumes the presence of the OOWP WordPress plugin which has not yet been released publicly.
Until then, this is only of use to Outlandish staff and freelancers. Keep checking back for updates.


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

## Usage notes

### Routing

Use [Countroller](http://symfony.com/doc/current/book/controller.html) and [Routing](http://symfony.com/doc/current/book/routing.html)
components as you would in a normal Symfony application. The front controller `web/index.php` loads WordPress before
booting Symfony which means standard WordPress functions and classes such as [WP_Query](http://codex.wordpress.org/Class_Reference/WP_Query)
are available in your Symfony controllers.

### Database

It is recommended (for performance and simplicity) to use WordPress's `$wpdb` global if you require direct database
access but you could also use Doctrine or another ORM.

### Caching

Caching is best handled by WordPress. Since WP is loaded first, a cache hit means that Symfony is not loaded at all.

### Plugins

Most WordPress plugins will continue to work, especially those that mainly affect the admin side. If in doubt, try it
and see. It is recommended to use Composer and [WPackagist](http://wpackagist.org) for plugin management.

### Themes

Normal WordPress themes will not work here. But you knew that, right?