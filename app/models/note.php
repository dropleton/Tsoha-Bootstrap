<?php

class Note extends BaseModel {

    public $id, $kayttaja_id, $otsikko, $sisalto, $prioriteetti;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_otsikko', 'validate_sisalto');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Muistiinpano;');
        $query->execute();
        $rows = $query->fetchAll();
        $notes = array();

        foreach ($rows as $row) {
            $notes[] = new Note(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'otsikko' => $row['otsikko'],
                'sisalto' => $row['sisalto'],
                'prioriteetti' => $row['prioriteetti']
            ));
        }
        return $notes;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Muistiinpano WHERE id = :id LIMIT 1;');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $note = new Note(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'otsikko' => $row['otsikko'],
                'sisalto' => $row['sisalto'],
                'prioriteetti' => $row['prioriteetti']
            ));
            return $note;
        }
        return NULL;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Muistiinpano (otsikko, sisalto, prioriteetti) VALUES (:otsikko, :sisalto, :prioriteetti) RETURNING id;');
        $query->execute(array('otsikko' => $this->otsikko, 'sisalto' => $this->sisalto, 'prioriteetti' => $this->prioriteetti));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $update = 'UPDATE Muistiinpano SET'
                . ' otsikko = \':otsikko\''
                . ' sisalto = \':sisalto\''
                . ' prioriteetti = \':prioriteetti\''
                . ' WHERE id = :id';
//        "UPDATE Muistiinpano SET otsikko = ':otsikko', sisalto = ':sisalto', prioriteetti = ':prioriteetti' WHERE id = :id;"
        $query = DB::connection()->prepare($update);
        $query->execute(array('otsikko' => $this->otsikko, 'sisalto' => $this->sisalto, 'prioriteetti' => $this->prioriteetti, 'id' => $this->id, ));
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Muistiinpano WHERE id= :id;');
        $query->execute(array('id' => $this->id));
    }

    public function validate_otsikko() {
        $errors = array();
        $length = 50;
        $string = $this->otsikko;
        $errors = array_merge($errors, $this->validate_string_length($string, $length));
//        $errors = array_merge($errors);
        return $errors;
    }

    public function validate_sisalto() {
        $errors = array();
        $length = 1000;
        $string = $this->sisalto;
        $errors = array_merge($errors, $this->validate_string_length($string, $length));
//        $errors = array_merge($errors);
        return $errors;
    }

}
