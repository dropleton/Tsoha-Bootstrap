<?php

class LuokkaController extends BaseController {
    
    public static function create() {
        View::make('luokka/new.html');
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
            'nimi' => $params['nimi']
        );
        $luokka = new Luokka($attributes);
        //validointi: toteuta luokka.php:n validointimetodit
        $luokka->save();
        Redirect::to('/note', array('message' => 'Luokan luominen onnistui!'));
    }

}
