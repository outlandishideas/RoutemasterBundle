<?php


namespace Outlandish\RoutemasterBundle\EventListener;


/**
 * Class UnhookListener
 * @package Outlandish\RoutemasterBundle\EventListener
 */
class UnhookListener {

	public function onKernelRequest() {
		//don't add feed links in wp_head
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
	}

}