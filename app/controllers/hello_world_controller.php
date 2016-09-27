<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/frontpage.html');
    }

    public static function sandbox() {
        $doom = new Note(array(
            'otsikko' => 'd',
            'sisalto' => 'a',
            'prioriteetti' => '!!!'
        ));
        $errors = $doom->errors();
        
        Kint::dump($errors);
//        $rajaArvot = Note::find(1);
//        $notes = Note::all();
//        
//        Kint::dump($notes);
//        Kint::dump($rajaArvot);
    }

    public static function note_list() {
        View::make('suunnitelmat/note_list.html');
    }
    
    public static function note_show() {
        View::make('suunnitelmat/note_show.html');
    }
    
    public static function note_create() {
        View::make('suunnitelmat/note_create.html');
    }
    
    public static function class_create() {
        View::make('suunnitelmat/class_create.html');
    }
    
    public static function login() {
        View::make('suunnitelmat/login.html');
    }

}
