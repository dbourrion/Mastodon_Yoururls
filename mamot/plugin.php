<?php
/**
Plugin Name: Mamot: quickshare
Plugin URI: http://yourls.org/
Description: Add Mamot.fr (a french Mastodon) api to YOURLS
Version: 1.0
Author: Daniel Bourrion
Author URI: daniel.bourrion@gmail.com
**/

yourls_add_action( 'share_links', 'mamot_share_url' );
function mamot_share_url( $args ) {
    list( $longurl, $shorturl, $title, $text ) = $args;
    $shorturl = rawurlencode( $shorturl );
    $title = rawurlencode( htmlspecialchars_decode( $title ) );
    
    // Plugin URL (no URL is hardcoded)
    $pluginurl = YOURLS_PLUGINURL . '/'.yourls_plugin_basename( dirname(__FILE__) );
    $icon = $pluginurl.'/Mastodon.png';
    echo <<<MAMOT
    <style type="text/css">
    #share_mamot{
        background: transparent url("$icon") left center no-repeat;
    }
    </style>
    <a id="share_mamot"
        href="https://mamot.fr/share?text=$shorturl&title=$title"
        title="Share on Mamot"
        onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;">Mamot
    </a>
    <script type="text/javascript">
    // Dynamically update Mamot link
    // when user clicks on the "Share" Action icon, event $('#tweet_body').keypress() is fired, so we'll add to this
    $('#tweet_body').keypress(function(){
        var url = encodeURIComponent( $('#copylink').val() );
        var mamot = 'https://mamot.fr/share?url='+url;
        $('#share_mamot').attr('href', mamot);        
    });
    </script>
MAMOT;
}
