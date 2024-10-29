<?php
if( !defined( 'ABSPATH' ) ) exit;

function jtpp_share_text() {
    if( is_home() || is_front_page() ) {
        $share_text = get_bloginfo( "name" );
        return $share_text;
    } else {
        $share_text = mb_strimwidth( get_the_title(), 0, 80, '…', 'utf-8' ) . ' - ' . get_bloginfo( 'name' );
        return $share_text;
    }
}

function jtpp_share_url() {
    if( is_home() || is_front_page() ) {
        $share_url = home_url();
        return $share_url;
    } else {
        $share_url = get_the_permalink();
        return $share_url;
    }
}

function jtpp_share_button_twitter() {
    $share_url = jtpp_share_url();
    $share_text = jtpp_share_text();
    $source = "<li class=\"twitter\"><a href=\"https://twitter.com/intent/tweet?original_referer=" . $share_url . "&text=" . $share_text . "&tw_p=tweetbutton&url=" . $share_url . "\" target=\"_blank\"><i></i><span>Twitter</span></a></li>" . PHP_EOL;
    return $source;
}

function jtpp_share_button_facebook() {
    $share_url = jtpp_share_url();
    $source = "<li class=\"facebook\"><a href=\"https://www.facebook.com/sharer/sharer.php?u=" . $share_url . "\" target=\"_blank\"><i></i><span>Facebook</span></a></li>" . PHP_EOL;
    return $source;
}

function jtpp_share_button_google() {
    $share_url = jtpp_share_url();
    $source = "<li class=\"google\"><a href=\"https://plus.google.com/share?url=" . $share_url . "\" target=\"_blank\"><i></i><span>Google+</span></a></li>" . PHP_EOL;
    return $source;
}

function jtpp_share_button_hatena() {
    $share_url = jtpp_share_url();
    $share_text = jtpp_share_text();
    $source = "<li class=\"hatena\"><a href=\"http://b.hatena.ne.jp/entry/" . $share_url . "\" target=\"_blank\" data-hatena-bookmark-title=\"" . $share_text . "\"><i></i><span>Hatena</span></a></li>" . PHP_EOL;
    return $source;
}

function jtpp_share_button_line() {
    $share_url = jtpp_share_url();
    $share_text = jtpp_share_text();
    $source = "<li class=\"line\"><a href=\"line://msg/text/?" . $share_url . "\" target=\"_blank\"><i></i><span>LINE</span></a></li>" . PHP_EOL;
    return $source;
}

function jtpp_share_buttons_list() {
    $twitter = jtpp_share_button_twitter();
    $facebook = jtpp_share_button_facebook();
    $google = jtpp_share_button_google();
    $hatena = jtpp_share_button_hatena();
    $line = jtpp_share_button_line();
    if( wp_is_mobile() ) {
        $source = "<div class=\"jtpp-share-buttons\">" . PHP_EOL . "<ul>" . PHP_EOL . $twitter . $facebook . $google . $line . "</ul>" . PHP_EOL . "</div>" . PHP_EOL;
        return $source;
    } else {
        $source = "<div class=\"jtpp-share-buttons\">" . PHP_EOL . "<ul>" . PHP_EOL . $twitter . $facebook . $google . $hatena . "</ul>" . PHP_EOL . "</div>" . PHP_EOL;
        return $source;
    }
}
