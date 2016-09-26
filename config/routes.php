<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->post('/note', function() {
    NoteController::store();
});

$routes->get('/note/new', function() {
    NoteController::create();
});

$routes->get('/note/:id', function($id) {
    NoteController::show($id);
});

$routes->get('/note', function() {
    NoteController::index();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/createclass', function() {
    HelloWorldController::class_create();
});
