<?php

class sql_class
{

    /*
      Links for learning:
      SQL Data Types:     https://www.w3schools.com/sql/sql_datatypes.asp
      SQL basics:         https://www.codecademy.com/articles/sql-commands
    */

    private $pdo;

    const dbFile = 'db.sqlite';

    function __construct()
    {
        // Create the connection to the database
        $this->pdo = new PDO('sqlite:' . self::dbFile);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // Create table, if not exists
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS
                          tabella (
                              id                   INTEGER PRIMARY KEY AUTOINCREMENT,
                              task_number          INTEGER NOT NULL,
                              task_category        TEXT NOT NULL,
                              task_title           TEXT NOT NULL,
                              task_description     TEXT,
                              add_date             TEXT,
                              delete_date          TEXT,
                              stato                TEXT
                          );');
    }

    public function readAll()
    {
        // Returns all items contained into the database
        $stmt = $this->pdo->query('SELECT * FROM tabella WHERE stato = :STATO  ORDER BY task_category ASC, id DESC');
        $stmt->bindValue(':STATO', "Active");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function readID($id)
    {
        // Returns all items contained into the database
        $stmt = $this->pdo->query('SELECT * FROM tabella WHERE id = :ID');
        $stmt->bindValue(':ID', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addItem($title, $description, $category)
    {
        // Create a new item and save it into the database
        date_default_timezone_set('Europe/Rome');
        $datetime = date("Y-m-d H:i:s");
        $stmt = $this->pdo->prepare('INSERT INTO tabella (task_number, task_category, task_title, task_description, add_date, stato) VALUES (:TASK_NUMBER, :TASK_CATEGORY, :TASK_TITLE, :TASK_DESCRIPTION, :ADD_DATE, :STATO)');
        $default_task_number = -1;
        $default_state = "Active";
        $stmt->bindParam(':TASK_NUMBER', $default_task_number);
        $stmt->bindParam(':TASK_CATEGORY', $category);
        $stmt->bindParam(':TASK_TITLE', $title);
        $stmt->bindParam(':TASK_DESCRIPTION', $description);
        $stmt->bindParam(':ADD_DATE', $datetime);
        $stmt->bindParam(':STATO', $default_state);
        $stmt->execute();

        //$this->reEnumerate();
    }

    private function reEnumerate()
    {
        // Renumber elements
        // Step 1 : retrieve all active elements's IDs
        $stmt = $this->pdo->query('SELECT id FROM tabella WHERE stato = :STATO ORDER BY task_category ASC');
        $stmt->bindValue(':STATO', "Active");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Step 2 : renumber each element
        $renumber = 0;
        $stmt = $this->pdo->prepare('UPDATE tabella SET task_number = :TASK_NUMBER WHERE id = :ID');
        $stmt->bindParam(':ID', $id);
        $stmt->bindParam(':TASK_NUMBER', $renumber);
        foreach ($result as $row) {
            $id = $row['id'];
            $renumber++;
            $stmt->execute();
        }
    }

    public function doneItem($id)
    {
        date_default_timezone_set('Europe/Rome');
        $datetime = date("Y-m-d H:i:s");
        $stmt = $this->pdo->prepare('UPDATE tabella SET stato = :STATO, delete_date = :DELETE_DATE, task_number = :TASK_NUMBER WHERE id = :ID');
        $stmt->bindParam(':ID', $id);
        $stmt->bindValue(':STATO', "Done");
        $stmt->bindParam(':DELETE_DATE', $datetime);
        $stmt->bindValue(':TASK_NUMBER', "-2");
        $stmt->execute();

        //$this->reEnumerate();
    }

    public function deleteItem($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM tabella WHERE id = :ID');
        $stmt->bindParam(':ID', $id);
        $stmt->execute();

        //$this->reEnumerate();
    }

    public function removeAll()
    {
        $stmt = $this->pdo->query('DELETE FROM tabella; VACUUM');
    }

    public function editItem($id, $title, $description, $category)
    {
        $stmt = $this->pdo->prepare('UPDATE tabella SET task_category = :TASK_CATEGORY, task_title = :TASK_TITLE, task_description = :TASK_DESCRIPTION WHERE id = :ID');
        $stmt->bindParam(':ID', $id);
        $stmt->bindParam(':TASK_CATEGORY', $category);
        $stmt->bindParam(':TASK_TITLE', $title);
        $stmt->bindParam(':TASK_DESCRIPTION', $description);
        $stmt->execute();
    }

}
