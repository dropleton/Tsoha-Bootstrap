<?php

class Luokka extends BaseModel {

    public $id, $nimi, $notes;

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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Luokka (nimi) '
                . 'VALUES (:nimi) RETURNING id;');
        $query->execute(array('nimi' => $this->nimi));
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
