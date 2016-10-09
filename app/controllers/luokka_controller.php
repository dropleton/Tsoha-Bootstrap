<?php

class LuokkaController extends BaseController {

    public static function show($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/luokka_show.html', array('luokka' => $luokka));
    }

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

    public static function edit($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/edit.html', array('attributes' => $luokka));
    }
    
    public function update($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi']
        );
        $luokka = new Luokka($attributes);
        //validointi: toteuta luokka.php:n validointimetodit
        $luokka->update();
        Redirect::to('/luokka/' . $luokka->id, array('message' => 'Luokan muokkaus onnistui!'));
    }
    
    public function destroy($id) {
        $luokka = new Luokka(array('id' => $id));
        $luokka->delete();
        //luokan viitteen poistaminen muistiinpanoista?
        Redirect::to('/note', array('message' => 'Luokka poistettu onnistuneesti'));
    }
}
