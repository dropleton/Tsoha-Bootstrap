<?php

class NoteController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $notes = Note::all($kayttaja_id);
        $luokat = Luokka::all($kayttaja_id);
        View::make('note/note_list.html', array('notes' => $notes, 'luokat' => $luokat));
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

        if (count($errors) == 0) {
            $note->save();
            Redirect::to('/note/' . $note->id, array('message' => 'Muistiinpano lisätty onnistuneesti!'));
        } else {
            View::make('/note/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        self::check_logged_in();
        View::make('note/new.html');
    }

    public static function edit($id) {
        self::check_logged_in();
        $note = Note::find($id);
        View::make('note/edit.html', array('attributes' => $note));
    }

    public static function update($id) {
        self::check_logged_in();
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

        if (count($errors) > 0) {
            View::make('note/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $note->update();
            Redirect::to('/note/' . $note->id, array('message' => 'Muistiinpanon muokkaus onnistui!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $note = new Note(array('id' => $id));
        $note->delete();
        Redirect::to('/note', array('message' => 'Muistiinpano poistettu'));
    }

    public static function edit_classes($id) {
        self::check_logged_in();
        $kayttaja_id = $_SESSION['user'];
        $note = Note::find($id);
        $luokat = Luokka::all($kayttaja_id);
        View::make('note/edit_classes.html', array('note' => $note, 'luokat' => $luokat));
    }

    public static function set_classes($id) {
        self::check_logged_in();
        //miksi Note::find($id) ei toimi, jos en valitse luokkien muokkaus -sivulta yhtään vaihtoehtoa?
        $note = Note::find($id);
        $params = $_POST;
        if (empty($params['luokat'])) {
            $errors = array();
            $errors[] = 'Valitse vähintään yksi vaihtoehto!';
            Redirect::to('/note/' . $note->id . 'edit-classes', array('errors' => $errors));
        } else if ($params['luokat'][0] == 'no_classes') {
            $note->remove_classes();
            Redirect::to('/note/' . $note->id, array('message' => 'Luokat poistettu onnistuneesti'));
        } else {
            $luokat = $params['luokat'];
            $note->add_to_classes($luokat);
            Redirect::to('/note/' . $note->id, array('message' => 'Luokat lisätty onnistuneesti'));
        }
    }

}
