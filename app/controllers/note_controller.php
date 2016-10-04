<?php

class NoteController extends BaseController {

    public static function index() {
        $notes = Note::all();
        View::make('note/note_list.html', array('notes' => $notes));
    }

    public static function show($id) {
        $note = Note::find($id);
        View::make('note/note_show.html', array('note' => $note));
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
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
        View::make('note/new.html');
    }
    
    public static function edit($id) {
        $note = Note::find($id);
        View::make('note/edit.html', array('attributes' => $note));
    }

    public static function update($id) {
        $params = $_POST;
        $id = (int) $id;

        $attributes = array(
            'id' => $id,
            'otsikko' => $params['otsikko'],
            'sisalto' => $params['sisalto'],
            'prioriteetti' => $params['prioriteetti']
        );
        
//        Kint::dump($attributes);

        $note = new Note($attributes);
//        Kint::dump($note);
        $errors = array();
        $errors = array_merge($errors, $note->errors());
        
        if(count($errors) > 0) {
            View::make('note/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $note->update();
//            Redirect::to('/note/' . $note->id, array('message' => 'Muistiinpanon muokkaus onnistui!'));
        }
    }

    public static function destroy($id) {
        $note = new Note(array('id' => $id));
        $note->delete();
        Redirect::to('/note', array('message' => 'Muistiinpano poistettu'));
    }

    //kaikki ongelmat:
    //Muistiinpanoa muokatessa saan "PDOException (HY093) SGLSTATE[HY093]:
    //Invalid parameter number: :otsikko"
    //Note.php:n riviltä 69. 
    //Kyselyssä tai käyttäjän syöttämissä arvoissa ei pitäisi olla vikaa. 
    //
}
