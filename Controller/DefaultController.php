<?php


namespace Outlandish\RoutemasterBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Outlandish\RoutemasterBundle\Annotation\Template;

class DefaultController extends BaseController {

	/**
	 * @Route("/")
	 * @Template("RoutemasterBundle:Default:defaultPost.html.php")
	 */
	public function frontPageAction() {
		$post = $this->querySingle(array('page_id' => get_option('page_on_front')));
		return array('post' => $post);
	}

    /**
     * @Route("/{slugs}/", requirements={"slugs"="[\w-\/]+"})
     * @Template
     */
    public function defaultPostAction($slugs) {
        $slugBits = explode('/', trim($slugs, '/'));
        $post = $this->querySingle(array('name' => $slugBits[count($slugBits) - 1], 'post_type' => 'any'), true);

        return array('post' => $post);
    }

    /**
     * @Route("/sitemap.xml")
     */
    public function sitemap() {
        $pageItems = new \ooWP_Query(array('post_type' => 'any', 'orderby' => 'date'));

	    $content = $this->renderView('RoutemasterBundle:Default:sitemap.xml.php', array('pageItems' => $pageItems));
	    return new Response($content, 200, array('Content-type' => 'text/xml'));
    }


	/**
	 * @Route("/feed.rss")
	 */
	public function feedAction() {
		$pageItems = array(); //provide your post items here

		$content = $this->renderView('RoutemasterBundle:Default:feed.xml.php', array(
			'title' => get_bloginfo('name'),
			'description' => '',
			'pageItems' => $pageItems
		));
		return new Response($content, 200, array('Content-type' => 'text/xml'));
	}

    /**
     * @Route("/robots.txt")
     */
    public function robots()
    {
        ob_start();
        do_action('do_robots');
        $robots = ob_get_clean();

        return new Response($robots, 200, array('Content-type' => 'text/plain'));
    }

}