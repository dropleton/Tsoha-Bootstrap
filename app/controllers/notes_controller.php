<?php

class NoteController extends BaseController {
    
    public static function index() {
        $notes = Note::all();
        View::make('suunnitelmat/note_list.html', array('notes' => $notes));
    }
    
    public static function show($id) {
        $note = Note::find($id);
        View::make('suunnitelmat/note_show.html', $note);
    }
    
}
