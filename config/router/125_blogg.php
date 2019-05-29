<?php
/**
 * Movie-controller
 */
return [

    "mount" => "blogg",

    "routes" => [
        [
            "info" => "Blogg controller.",
            // "mount" => "movie",
            "handler" => "\Anax\Blogg\BloggController",
        ],
    ]
];
