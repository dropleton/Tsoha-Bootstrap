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
//        $errors[] = $note->errors();

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

        $attributes = array(
            'id' => $id,
            'otsikko' => $params['otsikko'],
            'sisalto' => $params['sisalto'],
            'prioriteetti' => $params['prioriteetti']
        );

        $note = new Note($attributes);
        $errors = array();
        $errors[] = $note->errors();
//        $errors = array_merge($errors);
        
        if(count($errors) > 0) {
            View::make('note/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $note->update();
            Redirect::to('/note/' . $note->id, array('message' => 'Muistiinpanon muokkaus onnistui!'));
        }
    }

    public static function destroy($id) {
        $note = new Note(array('id' => $id));
        $note->delete();
        Redirect::to('/note', array('message' => 'Muistiinpano poistettu'));
    }

    //kaikki ongelmat:
    //Muistiinpanon lisäys tai poisto ei onnistu. Aina, kun kutsun note_controllerissa
    //$noten metodia errors(), virheitä löytyy, vaikkeivät note-luokan validointimetodit
    //edes palauta mitään.
    //Lisätessä tai poistaessa (kutsumatta metodia errors()) ohjautuu sivulle /note, 
    //mutta näyttää sivun new.html
    //Tästä huolimatta virheet eivät tulostu muuten kuin tekstinä "Array"
    //BaseModelin metodi errors ei tunnista attribuuttia $validators arrayksi jos 
    //määrittelen sen Note-luokan (extends BaseModel) puolella, vaan metodi vaatii
    //attribuutin array-määrittelyn BaseModel-luokassa
    
    //nyt toimii
    //update()-metodi errors()-kutsun kanssa, mutta luo joka kerta uuden muistiinpanon
    //
}
