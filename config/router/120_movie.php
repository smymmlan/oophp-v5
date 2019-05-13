<?php
/**
 * Movie-controller
 */
return [

    "mount" => "movie",

    "routes" => [
        [
            "info" => "Movie controller.",
            // "mount" => "movie",
            "handler" => "\Anax\Movie\MovieController",
        ],
    ]
];
