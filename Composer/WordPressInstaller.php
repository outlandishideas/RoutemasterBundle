<?php


namespace Outlandish\RoutemasterBundle\Composer;

use Composer\Script\CommandEvent; //this script is run in the context of Composer


class WordPressInstaller {

	public static function install(CommandEvent $event) {
		$webDir = 'web';

		define('WORDPRESS_FILE_URI', 'http://wordpress.org/latest.zip');

		if (file_exists($webDir.'/wp-load.php')) {
			echo 'Found wp-load.php in web root. Aborting.';
			return;
		}

		echo "Downloading WordPress from " . WORDPRESS_FILE_URI . "\n";
		$tempFile = tempnam(sys_get_temp_dir(), 'wordpress');
		file_put_contents($tempFile, file_get_contents(WORDPRESS_FILE_URI));

		$zip = new \ZipArchive;
		if (!$zip->open($tempFile)) {
			echo "Failed to open ZIP file.\n";
			return;
		}

		//we don't need most of the files in WPs root dir
		$ignoredFiles = array('index.php', 'license.txt', 'readme.html', 'wp-activate.php', 'wp-blog-header.php',
			'wp-comments-post.php', 'wp-config-sample.php', 'wp-cron.php', 'wp-links-opml.php', 'wp-mail.php',
			'wp-signup.php', 'wp-trackback.php', 'xmlrpc.php');

		for ($i = 0; $i < $zip->numFiles; $i++) {
			//get filename
			$stat = $zip->statIndex($i);
			//strip off leading directory
			$filepath = preg_replace('|^wordpress/|', '', $stat['name']);
			//ignore empty and content directories
			if (!$filepath || preg_match('|^wp-content/|', $filepath) || in_array($filepath, $ignoredFiles)) {
				continue;
			}
			//check if file is a directory
			if (substr($filepath, -1) == '/') {
				if (!file_exists($webDir .'/'.$filepath)) {
					echo "Creating folder $webDir/$filepath\n";
					mkdir($webDir.'/'.$filepath);
				} else {
					echo "Skipping folder $webDir/$filepath\n";
				}
			} else {
				file_put_contents($webDir . '/' . $filepath, $zip->getFromIndex($i));
			}
		}

		$zip->close();

		unlink($tempFile);

		//copy our sample config
		if (!file_exists($webDir.'/wp-config.php') && file_exists($webDir.'/wp-config-oi.php')) {
			echo "Copying sample config\n";
			copy($webDir . '/wp-config-oi.php', $webDir . '/wp-config.php');
		}

		echo "All done.\n";

	}
}