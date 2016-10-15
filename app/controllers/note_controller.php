<?php

class NoteController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $notes = Note::all($kayttaja_id);
        View::make('note/note_list.html', array('notes' => $notes));
    }

    public static function show($id) {
        self::check_logged_in();
        $note = Note::find($id);
        $luokkien_idt = $note->check_classes();
        $luokat = array();
        foreach ($luokkien_idt as $luokka) {
            $luokat[] = Luokka::find($luokka);
        }
        View::make('note/note_show.html', array('note' => $note, 'luokat' => $luokat));
    }

    public static function store() {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $params = $_POST;
        $attributes = array(
            'kayttaja_id' => $kayttaja_id,
            'otsikko' => $params['otsikko'],
            'sisalto' => $params['sisalto'],
            'prioriteetti' => $params['prioriteetti']
        );
        $note = new Note($attributes);
        $errors = array();
        $errors = array_merge($errors, $note->errors());

        if (array_key_exists('luokat', $params)) {
            $luokat = $params['luokat'];
        } else {
            $errors[] = 'Valitse vähintään yksi luokka!';
        }
        if (count($errors) == 0) {
            $note->save();
            $note->add_to_classes($luokat);
            Redirect::to('/note/' . $note->id, array('message' => 'Muistiinpano lisätty onnistuneesti!'));
        } else {
            $luokat = Luokka::all($kayttaja_id);
            View::make('/note/note_new.html', array('errors' => $errors, 'attributes' => $attributes, 'luokat' => $luokat));
        }
    }

    public static function create() {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $luokat = Luokka::all($kayttaja_id);
        View::make('note/note_new.html', array('luokat' => $luokat));
    }

    public static function edit($id) {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $note = Note::find($id);
        $luokat = Luokka::all($kayttaja_id);
        View::make('note/note_edit.html', array('attributes' => $note, 'luokat' => $luokat));
    }

    public static function update($id) {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $params = $_POST;
        $id = (int) $id;

        $attributes = array(
            'id' => $id,
            'otsikko' => $params['otsikko'],
            'sisalto' => $params['sisalto'],
            'prioriteetti' => $params['prioriteetti']
        );

        $note = new Note($attributes);
        $errors = array();
        $errors = array_merge($errors, $note->errors());

        if (array_key_exists('luokat', $params)) {
            $luokat = $params['luokat'];
        } else {
            $errors[] = 'Valitse vähintään yksi luokka!';
        }
        if (count($errors) > 0) {
            $luokat = Luokka::all($kayttaja_id);
            View::make('note/note_edit.html', array('errors' => $errors, 'attributes' => $attributes, 'luokat' => $luokat));
        } else {
            $note->update();
            $note->add_to_classes($luokat);
            Redirect::to('/note/' . $note->id, array('message' => 'Muistiinpanon muokkaus onnistui!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $note = new Note(array('id' => $id));
        $note->delete();
        Redirect::to('/luokat', array('message' => 'Muistiinpano poistettu'));
    }

//    public static function edit_classes($id) {
//        self::check_logged_in();
//        $kayttaja_id = $_SESSION['user'];
//        $note = Note::find($id);
//        $luokat = Luokka::all($kayttaja_id);
//        View::make('note/edit_classes.html', array('note' => $note, 'luokat' => $luokat));
//    }
//
//    public static function set_classes($id) {
//        self::check_logged_in();
//        //miksi Note::find($id) ei toimi, jos en valitse luokkien muokkaus -sivulta yhtään vaihtoehtoa?
//        $note = Note::find($id);
//        $params = $_POST;
//        if (empty($params['luokat'])) {
//            $errors = array();
//            $errors[] = 'Valitse vähintään yksi vaihtoehto!';
//            Redirect::to('/note/' . $note->id . 'edit-classes', array('errors' => $errors));
//        } else if ($params['luokat'][0] == 'no_classes') {
//            $note->remove_classes();
//            Redirect::to('/note/' . $note->id, array('message' => 'Luokat poistettu onnistuneesti'));
//        } else {
//            $luokat = $params['luokat'];
//            $note->add_to_classes($luokat);
//            Redirect::to('/note/' . $note->id, array('message' => 'Luokat lisätty onnistuneesti'));
//        }
//    }

}
