<?php


namespace Outlandish\RoutemasterBundle\EventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * Manipulate WordPress hooks and filters to fit the Symfony request lifecycle
 */
class HookSubscriber implements EventSubscriberInterface {

	/**
	 * Remove feed links from head of page
	 */
	public function unhookFeedLinks() {
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
	}

	/**
	 * Trigger the template_redirect hook to enable, among other things, the admin bar
	 *
	 * @param GetResponseEvent $event
	 */
	public function doTemplateRedirect(GetResponseEvent $event) {
		if ($event->getRequestType() == HttpKernel::MASTER_REQUEST) {
			remove_action('template_redirect', 'redirect_canonical');
			do_action('template_redirect');
		}
	}

	/**
	 * Allow Hypercache to properly handle redirects
	 *
	 * @param FilterResponseEvent $event
	 */
	public function checkRedirect(FilterResponseEvent $event) {
		if ($event->getResponse() instanceof RedirectResponse) {
			apply_filters('redirect_canonical', $event->getResponse()->getTargetUrl());
		}
	}

	/**
	 * Returns an array of event names this subscriber wants to listen to.
	 *
	 * For instance:
	 *
	 *  * array('eventName' => 'methodName')
	 *  * array('eventName' => array('methodName', $priority))
	 *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
	 *
	 * @return array The event names to listen to
	 *
	 * @api
	 */
	public static function getSubscribedEvents() {
		return array(
			KernelEvents::REQUEST => array(
				array('unhookFeedLinks'),
				array('doTemplateRedirect'),
			),
			KernelEvents::RESPONSE => array(
				array('checkRedirect')
			),
		);
	}
}