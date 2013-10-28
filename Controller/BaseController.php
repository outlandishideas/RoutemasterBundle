<?php

namespace Outlandish\RoutemasterBundle\Controller;

use Outlandish\OowpBundle\Helpers\OowpQuery;
use Outlandish\OowpBundle\PostType\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;

class BaseController extends SymfonyController {

    /**
     * Check that the requested URI matches the post permalink and redirect if not
     * @param Post $post
     */
    protected function redirectCanonical($post)
    {
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ("$scheme://$_SERVER[HTTP_HOST]$path" != $post->permalink()) {
            wp_redirect($post->permalink());
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
	 * @param $args
	 * @param bool $redirectCanonical true if should redirect canonically after fetching the post
	 * @throws NotFoundHttpException
	 * @return Post
	 */
    protected function querySingle($args, $redirectCanonical = false)
    {
        global $post;
        $query = $this->query($args);
        //no matched posts so 404
        if (!count($query)) {
            throw new NotFoundHttpException('No posts matching query '.json_encode($args));
        }

        $post = $query[0];

        if ($redirectCanonical) {
            $this->redirectCanonical($post);
        }

        return $post;
    }
}