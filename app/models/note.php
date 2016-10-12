<?php

class Note extends BaseModel {

    public $id, $kayttaja_id, $otsikko, $sisalto, $prioriteetti, $luokat;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_otsikko', 'validate_sisalto');
        $this->luokat = array();
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Muistiinpano '
                . 'WHERE kayttaja_id = :kayttaja_id;');
        $query->execute(array('kayttaja_id' => $kayttaja_id));
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
        $query = DB::connection()->prepare('SELECT * FROM Muistiinpano '
                . 'WHERE id = :id LIMIT 1;');
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
        $query = DB::connection()->prepare('INSERT INTO Muistiinpano (kayttaja_id, otsikko, sisalto, prioriteetti) '
                . 'VALUES (:kayttaja_id, :otsikko, :sisalto, :prioriteetti) RETURNING id;');
        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'otsikko' => $this->otsikko, 'sisalto' => $this->sisalto, 'prioriteetti' => $this->prioriteetti));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare("UPDATE Muistiinpano "
                . "SET otsikko = :otsikko, sisalto = :sisalto, prioriteetti = :prioriteetti "
                . "WHERE id = :id;");
        $query->execute(array('id' => $this->id, 'otsikko' => $this->otsikko, 'sisalto' => $this->sisalto, 'prioriteetti' => $this->prioriteetti));
    }

    public function delete() {
        $this->remove_classes();
//        $query1 = DB::connection()->prepare('DELETE FROM Liitostaulu WHERE muistiinpano_id = :id');
//        $query1->execute(array('id' => $this->id));
        $query = DB::connection()->prepare('DELETE FROM Muistiinpano WHERE id= :id;');
        $query->execute(array('id' => $this->id));
    }

    public function check_classes() {
        $query = DB::connection()->prepare('SELECT luokka_id FROM Liitostaulu WHERE muistiinpano_id = :id;');
        $query->execute(array('id' => $this->id));
        $rows = $query->fetchAll();
        $luokat = array();
        foreach($rows as $row) {
            $luokat[] = $row['luokka_id'];
        }
        //nyt $luokat sisältää arrayn id:itä, joihin muistiinpano kuuluu
        $this->luokat = $rows;
        return $luokat;
    }

    public function add_to_classes($luokat) {
        //$luokat sisältää luokkien id:t, jotka muistiinpanolle on lisättävä.
        //Metodin idea:
        //Ensin poistetaan Liitostaulusta yhteydet tästä muistiinpanosta kaikkiin luokkiin.
        //Tämän jälkeen lisätään uudet luokat. 

        $this->remove_classes();
        foreach ($luokat as $luokka) {
            $luokka = (int) $luokka;
            $query = DB::connection()->prepare('INSERT INTO Liitostaulu (muistiinpano_id, luokka_id) '
                    . 'VALUES (:note_id, :luokka_id)');
            $query->execute(array('note_id' => $this->id, 'luokka_id' => $luokka));
        }
    }
    
    public function remove_classes() {
        $query = DB::connection()->prepare('DELETE FROM Liitostaulu '
                . 'WHERE muistiinpano_id = :note_id;');
        $query->execute(array('note_id' => $this->id));
    }

    public function validate_otsikko() {
        $errors = array();
        $length = 50;
        $string = $this->otsikko;
        $errors = array_merge($errors, $this->validate_string_length($string, $length));
        return $errors;
    }

    public function validate_sisalto() {
        $errors = array();
        $length = 1000;
        $string = $this->sisalto;
        $errors = array_merge($errors, $this->validate_string_length($string, $length));
        return $errors;
    }

}
