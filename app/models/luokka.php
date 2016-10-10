<?php

class Luokka extends BaseModel {

    public $id, $kayttaja_id, $nimi, $notes;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $notes = array();
//        $this->get_notes();
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka '
                . 'WHERE Luokka.kayttaja_id = :id;');
        $query->execute(array('id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $luokat = array();

        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'nimi' => $row['nimi']
            ));
        }

        return $luokat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka '
                . 'WHERE id = :id LIMIT 1;');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $luokka = new Luokka(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
            return $luokka;
        }
        return null;
    }
    
    public static function find_notes($luokkaid) {
        $query = DB::connection()->prepare('SELECT muistiinpano_id FROM Liitostaulu WHERE luokka_id = :id;');
        $query->execute(array('id' => $luokkaid));
        $rows = $query->fetchAll();
        $notes = array();
        foreach($rows as $row) {
            $notes[] = $row['muistiinpano_id'];
        }
        return $notes;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Luokka (nimi, kayttaja_id) '
                . 'VALUES (:nimi, :kayttaja_id) RETURNING id;');
        $query->execute(array('nimi' => $this->nimi, 'kayttaja_id' => $this->kayttaja_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Luokka '
                . 'SET nimi = :nimi '
                . 'WHERE id = :id;');
        $query->execute(array('nimi' => $this->nimi, 'id' => $this->id));
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Luokka WHERE id = :id;');
        $query->execute(array('id' => $this->id));
    }

}
