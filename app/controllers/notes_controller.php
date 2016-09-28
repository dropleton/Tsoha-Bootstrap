<?php

class NoteController extends BaseController {

    public static function index() {
        $notes = Note::all();
        View::make('suunnitelmat/note/note_list.html', array('notes' => $notes));
    }

    public static function show($id) {
        $note = Note::find($id);
        View::make('suunnitelmat/note/note_show.html', array('note' => $note));
    }

    public static function store() {
        $params = $_POST;
        $note = new Note(array(
            'otsikko' => $params['otsikko'],
            'sisalto' => $params['sisalto'],
            'prioriteetti' => $params['prioriteetti']
        ));
        $note->save();
        Redirect::to('/note/' . $note->id, array('message' => 'Muistiinpano lisätty onnistuneesti!'));
    }

    public static function create() {
        View::make('suunnitelmat/note/new.html');
    }

}
