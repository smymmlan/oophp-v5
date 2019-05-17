<?php
/**
 * Movie-controller
 */
return [

    "mount" => "textfilter",

    "routes" => [
        [
            "info" => "Text controller.",
            // "mount" => "movie",
            "handler" => "\Anax\MyTextFilter\MyTextFilterController",
        ],
    ]
];
