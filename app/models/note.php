<?php

class Note extends BaseModel {

    public $id, $kayttaja_id, $otsikko, $sisalto, $prioriteetti, $validate_otsikko, $validate_sisalto;

    public function _construct($attributes) {
//        $this->validators = array('validate_otsikko', 'validate_sisalto');
        parent::_construct($attributes);
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

    public function validate_otsikko() {
//        $this->validators[] = 'validate_otsikko';
        $length = 50;
        $string = $this->otsikko;
        $errors = array();
        $errors[] = $this->validate_string_length($string, $length);
        return $errors;
    }

    public function validate_sisalto() {
//        $this->validators[] = 'validate_sisalto';
        $length = 1000;
        $string = $this->sisalto;
        $errors = array();
        $errors[] = $this->validate_string_length($string, $length);
        return $errors;
    }

}
