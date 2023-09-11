<?php
function em_ical_cors_headers( ){
    //check if this is a calendar request for all events
    if ( preg_match('/events.ics(\?.+)?$/', $_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == '/?ical=1' ) {
        header('Access-Control-Allow-Origin: *');
    }
}

add_action ( 'init', 'em_ical_cors_headers', 5 );
