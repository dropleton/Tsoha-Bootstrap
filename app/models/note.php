<?php

class Note extends BaseModel {

    public $id, $kayttaja_id, $otsikko, $sisalto, $prioriteetti;

    public function _construct($attributes) {
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

}
