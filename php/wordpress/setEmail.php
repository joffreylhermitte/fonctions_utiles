<?php
// Dans functions.php

function wpb_sender_email( $original_email_address ) {
    return 'email';
}

function wpb_sender_name( $original_email_from ) {
    return 'Nom';
}
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );