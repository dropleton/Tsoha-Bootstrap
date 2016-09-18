<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/note', function() {
    HelloWorldController::note_list();
});

$routes->get('/note/1', function() {
    HelloWorldController::note_show();
});

$routes->get('/note/new', function() {
    HelloWorldController::note_create();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/createclass', function() {
    HelloWorldController::class_create();
});