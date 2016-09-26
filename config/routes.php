<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/note', function() {
    NoteController::index();
});

$routes->get('/note/:id', function($id) {
    NoteController::show($id);
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