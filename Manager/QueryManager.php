<?php


namespace Outlandish\RoutemasterBundle\Manager;


class QueryManager
{

	/**
	 * Get a single post by ID
	 *
	 * @param int $id Post ID
	 * @return \WP_Post|null
	 */
	public function find($id) {
		$query = $this->query(array('p' => $id, 'post_status' => null));
		return $query->post_count > 0 ? $query->posts[0] : null;
	}

	/**
	 * Set some defaults, similar to get_posts
	 *
	 * @param array $queryArgs
	 * @return array
	 */
	protected function processQueryArgs($queryArgs) {
		$defaults = array(
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post_type' => 'any'
		);

		$queryArgs = wp_parse_args($queryArgs, $defaults);

		return $queryArgs;
	}

	/**
	 * Run a database query and return a new query object
	 *
	 * @param array $queryArgs
	 * @return \WP_Query
	 */
	public function query($queryArgs) {
		return new \WP_Query($this->processQueryArgs($queryArgs));
	}

} 