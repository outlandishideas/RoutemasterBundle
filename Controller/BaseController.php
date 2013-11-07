<?php

namespace Outlandish\RoutemasterBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;

class BaseController extends SymfonyController {

    /**
     * Check that the requested URI matches the post permalink and redirect if not
     * @param $post
     */
    protected function redirectCanonical($post)
    {
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	    $isPreview = isset($_GET['preview']) && $_GET['preview'] == 'true';
	    if ("$scheme://$_SERVER[HTTP_HOST]$path" != get_permalink($post) && !$isPreview) {
            wp_redirect(get_permalink($post));
            die;
        }
    }

    /**
     * Create a new query object and set the global $wp_query
     * @param $args
     * @return \WP_Query
     */
    protected function query($args)
    {
        global $wp_query;
        $wp_query = $this->get('outlandish_routemaster.query_manager')->query($args);
        return $wp_query;
    }

	/**
	 * Select a single post, set globals and throw 404 exception if nothing matches
	 * @param $queryArgs
	 * @param bool $redirectCanonical true if should redirect canonically after fetching the post
	 * @throws NotFoundHttpException
	 * @return \WP_Post
	 */
    protected function querySingle($queryArgs, $redirectCanonical = false)
    {
        global $post;

	    //check for post preview and modify query
	    if (isset($_GET['preview']) && $_GET['preview'] == 'true') {
		    $queryArgs['preview'] = 'true';

		    //for unpublished posts, override query entirely
		    if (isset($_GET['p']) || isset($_GET['page_id'])) {
			    $queryArgs = array_intersect_key($_GET, array_flip(array('preview', 'p', 'page_id')));
		        $queryArgs['post_status'] = null;
		    }
	        //published posts user preview_id and don't need any extra help
	    }

        $query = $this->query($queryArgs);

        //no matched posts so 404
        if (!count($query->posts)) {
            throw new NotFoundHttpException('No posts matching query '.json_encode($query->query));
        }

        $post = $query->post;

        if ($redirectCanonical) {
            $this->redirectCanonical($post);
        }

        return $post;
    }
}