<?php

class LuokkaController extends BaseController {
    
    public static function index() {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $luokat = Luokka::all($kayttaja_id);
        View::make('luokka/list.html', array('luokat' => $luokat));
    }

    public static function show($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/luokka_show.html', array('luokka' => $luokka));
    }
    
    public static function show_notes($luokkaid) {
        $luokka = Luokka::find($luokkaid);
        $noteidt = $luokka->find_notes($luokkaid);
        $notes = array();
        foreach($noteidt as $noteid) {
            $note = Note::find($noteid);
            $notes[] = $note;
        }
        View::make('luokka/notes.html', array('notes' => $notes, 'luokka' => $luokka));
    }

    public static function create() {
        View::make('luokka/new.html');
    }

    public static function store() {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $params = $_POST;
        $attributes = array(
            'nimi' => $params['nimi'],
            'kayttaja_id' => $kayttaja_id
        );
        $luokka = new Luokka($attributes);
        //validointi: toteuta luokka.php:n validointimetodit
        $luokka->save();
        Redirect::to('/luokat', array('message' => 'Luokan luominen onnistui!'));
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
