<?php


namespace Outlandish\RoutemasterBundle\Manager;


class QueryManager {

	public function query($queryArgs) {
		return new \WP_Query($queryArgs);
	}

	public function find($id) {
		$query = $this->query(array('p'=>$id));
		return $query->post;
	}

} 