<?php print '<?xml version="1.0" encoding="utf-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<?php foreach ($pageItems as $item):
        $update   = 'weekly';
        $priority = 0.7;
	?>
	<url>
		<loc><?php print $item->permalink(); ?></loc>
	    <lastmod><?php print $item->date('Y-m-d'); ?></lastmod>
	    <changefreq><?php print $update; ?></changefreq>
	    <priority><?php print $priority; ?></priority>
		<expires><?php print gmdate(DATE_ATOM, strtotime('midnight')); ?></expires>
	</url>
	<?php endforeach; ?>

</urlset>