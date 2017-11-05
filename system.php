<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $env = json_decode( file_get_contents( "../environment.json" ) );

    require_once "../inc/core/Zinc.php";
    $zink = new Zinc();

    require_once "../inc/core/ZincValidator.php";
    $validator = new ZincValidator();

    // Setting JSON type globally.
    header( 'Content-Type: application/json; charset=utf-8' );

    require_once "../inc/func_return_404.php";
    require_once "../inc/func_requests.php";

    // Simple routing.
    if( isset( $_GET[ 'route' ] ) ) {
        $component = trim( $_GET[ 'route' ] );
        if( empty( $component ) ) {
            $component = 'index';
        }
    } else {
        $component = 'index';
        // return_error();
    }

    // Check if component exist.
    $segments = '/'; 
    // For security purposes recasting the url splitted by segments.
    foreach( explode( '/', $component ) as $uri ) {
        $segments = $segments . $uri . '/';
    }
    $component = '../blocks'.rtrim( $segments, '/' ).'.php';
    if( file_exists( $component ) ) {
        require_once $component;
    } else {
        return_error( 'Controller not found.' );
    }