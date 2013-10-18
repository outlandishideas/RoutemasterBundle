<?php print '<?xml version="1.0" encoding="utf-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<?php foreach ($pageItems as $item): ?>
	<url>
		<loc><?php print $item->permalink(); ?></loc>
	    <lastmod><?php print $item->date('Y-m-d'); ?></lastmod>
	    <changefreq><?php print 'weekly'; ?></changefreq>
	    <priority><?php print 0.7; ?></priority>
		<expires><?php print gmdate(DATE_ATOM, mktime(0, 0, 0)); ?></expires>
	</url>
	<?php endforeach; ?>

</urlset>