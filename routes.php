<?php
$routes = [
    'default' => [
        'class' => 'DefaultController',
        'index' => 'index'
    ],
    'auth' => [
        'class' => 'AuthController',
        'login' => 'login',
        'register' => 'register'
    ],
    'tournament' => [
        'class' => 'TournamentController',
        'list' => 'list',
        'form' => 'form'
    ],
    'team' => [
        'class' => 'TeamController',
        'list' => 'list',
        'detail' => 'detail'
    ],
    'match' => [
        'class' => 'MatchController',
        'list' => 'list',
        'bracket' => 'bracket',
        'detail' => 'detail'
    ],
    'news' => [
        'class' => 'NewsController',
        'list' => 'list',
        'detail' => 'detail'
    ],
    'video' => [
        'class' => 'VideoController',
        'highlights' => 'highlights'
    ]
    
];
?>