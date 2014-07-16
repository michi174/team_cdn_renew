<?php
namespace model\boards;

use wsc\model\Model_abstract;

/**
 *
 * @author michi_000
 *        
 */
class Boards extends Model_abstract
{
    /**
     * Tabelle in der Datenbank
     * @var string
     */
    private $table  = "boards";
    
    /**
     * Alle Boards
     */
    public function getAllBoards()
    {
        return $this->executeQuery("SELECT * FROM " . $this->table);
    }
    
    /**
     * Alle Boards die nicht für Subboards gesperrt sind.
     */
    public function allNotClosedForSubboards()
    {
        return $this->executeQuery("SELECT * FROM " . $this->table . " WHERE disableSubboards = 0");
    }
}

?>