<?php

class LuokkaController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $luokat = Luokka::all($kayttaja_id);
        View::make('luokka/luokka_list.html', array('luokat' => $luokat));
    }

    public static function show($id) {
        self::check_logged_in();
        $luokka = Luokka::find($id);
        View::make('luokka/luokka_show.html', array('luokka' => $luokka));
    }

    public static function show_notes($luokkaid) {
        self::check_logged_in();
        $luokka = Luokka::find($luokkaid);
        $noteidt = $luokka->find_notes($luokkaid);
        $notes = array();
        foreach ($noteidt as $noteid) {
            $note = Note::find($noteid);
            $notes[] = $note;
        }
        View::make('luokka/luokka_notes.html', array('notes' => $notes, 'luokka' => $luokka));
    }

    public static function create() {
        self::check_logged_in();
        View::make('luokka/luokka_new.html');
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
        $errors = $luokka->errors();

        if (count($errors) == 0) {
            $luokka->save();
            Redirect::to('/luokat', array('message' => 'Luokan luominen onnistui!'));
        } else {
            View::make('luokka/luokka_new.html', array('errors' => $errors, 'luokka' => $luokka));
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $luokka = Luokka::find($id);
        View::make('luokka/luokka_edit.html', array('attributes' => $luokka));
    }

    public function update($id) {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi']
        );
        $luokka = new Luokka($attributes);
        $errors = $luokka->errors();

        if (count($errors) == 0) {
            $luokka->save();
            Redirect::to('/luokat', array('message' => 'Luokan luominen onnistui!'));
        } else {
            View::make('luokka/luokka_edit.html', array('errors' => $errors, 'luokka' => $luokka));
        }
    }

    public function destroy($id) {
        self::check_logged_in();
        $luokka = new Luokka(array('id' => $id));
        $note_ids = $luokka->find_notes($id);
        foreach ($note_ids as $noteid) {
            $note = new Note(array('id' => $noteid));
            //katsotaan, kuuluuko kyseinen muistiinpano muihin luokkiin
            $other_classes = $note->check_classes();
            //poistetaan näistä muista luokista poistettava luokka
            $key = array_search($id, $other_classes);
            unset($other_classes[$key]);
            //jos muut luokat jää tyhjäksi..
            if (empty($other_classes)) {
                //poistetaan kyseinen muistiinpano
                $note->delete();
            }
            //muutoin poistetaan pelkkä luokka
        }
        $luokka->delete();
        Redirect::to('/luokat', array('message' => 'Luokka poistettu onnistuneesti'));
    }

}
