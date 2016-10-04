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

$routes->get('/note/:id/edit', function($id) {
    NoteController::edit($id);
});

$routes->post('/note/:id/edit', function($id) {
    NoteController::update($id);
});

$routes->get('/note/:id/destroy', function($id) {
    NoteController::destroy($id);
});

$routes->get('/note', function() {
    NoteController::index();
});

$routes->get('/createclass', function() {
    HelloWorldController::class_create();
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->post('/logout', function() {
    UserController::logout();
});
