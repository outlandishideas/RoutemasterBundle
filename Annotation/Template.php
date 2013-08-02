<?php


namespace Outlandish\RoutemasterBundle\Annotation;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as BaseTemplate;


/**
 * Set default template engine to PHP.
 *
 * @Annotation
 */
class Template extends BaseTemplate {
	protected $engine = 'php';
}