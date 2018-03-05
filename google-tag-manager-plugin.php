<?php
/*
Plugin Name: Google Tag Manager Plugin
Plugin URI:
Description: Add all Google Tag Manager scripts in Wordpress websites.
Version: 1.1
Author: Jeremy Spaeth
Author URI:
License: GPL v3
*/

class GoogleTagManager
{
	public function __construct()
	{
		add_filter('wp_head', array($this, 'getDataLayer'), 50, 0);
		add_filter('wp_head', array($this, 'GtmHead'), 51, 0);
		add_filter('wp_footer', array($this, 'GtmBody'));
	}

	function getDataLayer()
	{
		// Get current user informations if is logged in.
		$user = wp_get_current_user();

		// Return true if is single post.
		$is_post = 'false';
		if (is_single()) {
			$is_post = 'true';
		}

		echo '
<script>
    var dataLayer = [{
        "user": {
            "userId" : "' . $user->ID. '",
            "userEmail" : "' . $user->user_email . '",
            "userEmailMd5" : "' . md5($user->user_email) . '"
        },
        "site": {
            "is_post" : "' . $is_post . '"
        }
    }];
</script>
            ';
	}

	function GtmHead()
	{
		echo "
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KBF7DJ2');
</script>
<!-- End Google Tag Manager -->
";
	}

	function GtmBody()
	{
		echo '
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KBF7DJ2" height="0" width="0" style="display:none; visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
        ';
	}
}
new GoogleTagManager;