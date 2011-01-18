<?php
/*
Plugin Name: YOURLS Toolbar
Plugin URI: http://yourls.org/
Description: Add a social toolbar to your redirected short URLs. Fork this plugin if you want to make your own toolbar.
Version: 1.0
Author: Ozh
Author URI: http://ozh.org/
Disclaimer: Toolbars ruin the user experience. Be warned.
*/

global $ozh_toolbar;
$ozh_toolbar['do'] = false;
$ozh_toolbar['keyword'] = '';

// When a redirection to a shorturl is about to happen, register variables
yourls_add_action( 'redirect_shorturl', 'ozh_toolbar_add' );
function ozh_toolbar_add( $args ) {
	global $ozh_toolbar;
	$ozh_toolbar['do'] = true;
	$ozh_toolbar['keyword'] = $args[1];
}

// On redirection, check if this is a toolbar and draw it if needed
yourls_add_action( 'pre_redirect', 'ozh_toolbar_do' );
function ozh_toolbar_do( $args ) {
	global $ozh_toolbar;
	
	// Does this redirection need a toolbar?
	if( !$ozh_toolbar['do'] )
		return;

	// Do we have a cookie stating the user doesn't want a toolbar?
	if( isset( $_COOKIE['yourls_no_toolbar'] ) && $_COOKIE['yourls_no_toolbar'] == 1 )
		return;
	
	// Get URL and page title
	$url = $args[0];
	$pagetitle = yourls_get_keyword_title( $ozh_toolbar['keyword'] );

	// Update title if it hasn't been stored yet
	if( $pagetitle == '' ) {
		$pagetitle = yourls_get_remote_title( $url );
		yourls_edit_link_title( $ozh_toolbar['keyword'], $pagetitle );
	}
	$_pagetitle = htmlentities( yourls_get_remote_title( $url ) );
	
	$www = YOURLS_SITE;
	$ver = YOURLS_VERSION;
	$md5 = md5( $url );
	$sql = yourls_get_num_queries();

	// When was the link created (in days)
	$diff = abs( time() - strtotime( yourls_get_keyword_timestamp( $ozh_toolbar['keyword'] ) ) );
	$days = floor( $diff / (60*60*24) );
	if( $days == 0 ) {
		$created = 'today';
	} else {
		$created = $days.' '.yourls_plural( 'day', $days).' ago';
	}
	
	// How many hits on the page
	$hits = 1 + yourls_get_keyword_clicks( $ozh_toolbar['keyword'] );
	$hits = $hits.' '.yourls_plural( 'view', $hits);
	
	// Plugin URL (no URL is hardcoded)
	$pluginurl = YOURLS_PLUGINURL . '/'.yourls_plugin_basename( dirname(__FILE__) );

	// All set. Draw the toolbar itself.
	echo <<<PAGE
<html>
<head>
	<title>$pagetitle &mdash; 4Charity</title>
	<link rel="icon" type="image/gif" href="$www/images/favicon.gif" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<meta name="generator" content="YOURLS v$ver" />
	<meta name="ROBOTS" content="NOINDEX, FOLLOW" />
	<link rel="stylesheet" href="$pluginurl/css/toolbar.css" type="text/css" media="all" />
</head>
<body>
<div id="yourls-bar">
	<div id="toolbar-logo">
	
	</div>
	
	<div id="toolbar-ad">
	<!--/* OpenX Javascript Tag v2.8.7 */-->
	
	<script type='text/javascript'><!--//<![CDATA[
	   document.MAX_ct0 ='INSERT_CLICKURL_HERE';
	
	   var m3_u = (location.protocol=='https:'?'https://4c.to/ads/www/delivery/ajs.php':'http://4c.to/ads/www/delivery/ajs.php');
	   var m3_r = Math.floor(Math.random()*99999999999);
	   if (!document.MAX_used) document.MAX_used = ',';
	   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
	   document.write ("?zoneid=1&amp;target=_blank&amp;block=1&amp;blockcampaign=1");
	   document.write ('&amp;cb=' + m3_r);
	   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
	   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
	   document.write ("&amp;loc=" + escape(window.location));
	   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
	   if (document.context) document.write ("&context=" + escape(document.context));
	   if ((typeof(document.MAX_ct0) != 'undefined') && (document.MAX_ct0.substring(0,4) == 'http')) {
	       document.write ("&amp;ct0=" + escape(document.MAX_ct0));
	   }
	   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
	   document.write ("'><\/scr"+"ipt>");
	//]]>--></script><noscript><a href='http://4c.to/ads/www/delivery/ck.php?n=af4c583b&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://4c.to/ads/www/delivery/avw.php?zoneid=1&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af4c583b&amp;ct0=INSERT_CLICKURL_HERE' border='0' alt='' /></a></noscript>
	</div>
	
	<div id="yourls-delicious">
		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="$url" layout="button_count" show_faces="false" width="450"></fb:like>
		<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	</div>
	
	<div id="yourls-selfclose">
		<a id="yourls-once" href="$url" title="Close this toolbar">close</a>
		
	</div>
</div>

<iframe id="yourls-frame" frameborder="0" noresize="noresize" src="$url" name="yourlsFrame"></iframe>
<script type="text/javascript" src="$pluginurl/js/toolbar.js"></script>
<script type="text/javascript" src="http://cdn.topsy.com/topsy.js?init=topsyWidgetCreator"></script>
<script type="text/javascript" src="http://feeds.delicious.com/v2/json/urlinfo/$md5?callback=yourls_get_books"></script>
</body>
</html>
PAGE;
	
	// Don't forget to die, to interrupt the flow of normal events (ie redirecting to long URL)
	die();
}