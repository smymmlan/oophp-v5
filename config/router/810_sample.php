<?php
/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.
    // "mount" => "sample",

    // All routes in order
    "routes" => [
        [
            "info" => "Sample controller app style.",
            "mount" => "app",
            "handler" => "\Anax\Controller\Dice100Controller",
        ],
    ]
];
