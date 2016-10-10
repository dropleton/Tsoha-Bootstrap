<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->post('/note/new', function() {
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

//$routes->get('/note/:id/edit_classes', function($id) {
//    NoteController::edit_classes($id);
//});

//$routes->post('/note/:id/edit_classes', function($id) {
//    NoteController::set_classes($id);
//});

$routes->get('/note/:id/destroy', function($id) {
    NoteController::destroy($id);
});

$routes->get('/note', function() {
    NoteController::index();
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

$routes->get('/luokat', function() {
    LuokkaController::index();
});

$routes->post('/luokka', function() {
    LuokkaController::store();
});

$routes->get('/luokka/new', function() {
    LuokkaController::create();
});

$routes->get('/luokka/:id', function($id) {
    LuokkaController::show($id);
});

$routes->get('/luokka/:id/show', function($id) {
    LuokkaController::show_notes($id);
});

$routes->get('/luokka/:id/edit', function($id) {
    LuokkaController::edit($id);
});

$routes->post('/luokka/:id/edit', function($id) {
    LuokkaController::update($id);
});

$routes->get('/luokka/:id/destroy', function($id) {
    LuokkaController::destroy($id);
});
