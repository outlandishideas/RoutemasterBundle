<?php $view->extend('::layout.html.php'); ?>

<h1><?php print $post->title(); ?></h1>
<?php print $post->content(); ?>