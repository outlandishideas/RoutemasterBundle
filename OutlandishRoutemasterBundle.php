<?php


namespace Outlandish\RoutemasterBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class OutlandishRoutemasterBundle extends Bundle {

	public function boot() {
		if (class_exists('ooTheme')) { //needed until we can autoload ooTheme
			$this->container->get('templating')->addGlobal('theme', \ooTheme::getInstance());
		}
	}

}