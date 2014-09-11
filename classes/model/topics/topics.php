<?php
namespace model\topics;

use wsc\model\Model_abstract;

/**
 *
 * @author michi_000
 *        
 */
class Topics extends Model_abstract
{
    private $table  = "topics";
    
    /**
     * Gibt alle Topics zurück, die aufgrund der BoardsId gefunden werden.
     * 
     * @param int $boardId
     * @param int $limit
     * @param int $start
     * @param string $order
     * @param string $sort
     * @return Ambigous <NULL, array>
     */
    public function getTopicsByBoard($boardId, $limit = 0, $start = 0, $order="id", $sort = "ASC")
    {
        
        if($limit <= 0){
            $limit_qu  = "";
        }
        else{
            $limit_qu  = " LIMIT ";
            
            if($start   <= 0){
                $limit_qu   .= $limit;
            }
            else {
                $limit_qu   .= $start . ",".$limit;
            }
        }
        
        $query  = "SELECT * FROM " . $this->table . " WHERE boardsId = ". $boardId . " ORDER BY " . $order ." ". $sort . $limit_qu;
        
        
        return $this->executeQuery($query);
    }
    
    public function getTopicById($id)
    {
        $topic  = $this->database->getDataById($this->table, $id);
        
        if(!empty($topic))
        {
            return $topic;
        }
        
        return false;
    }
    /**
     * Erstellt ein neues Thema.
     * 
     * @param int $board
     * @param string $title
     * @param string $autor
     * @param int $replys
     * @param int $important
     * @param int $recRef
     * @param bool $createTimestamp
     * 
     * @return boolean
     */
    public function createTopic($board, $title, $autor, $replys, $important, $recRef = "", $createTimestamp = true)
    {
        if($createTimestamp === true)
        {
            $timestamp  = time();
        }
        
        $redID  = $this->database->createRecID();
        
        $sql    = " INSERT ".$this->table."(boardsId, title, autor, disableReplys, important, redId, recRef, createTimestamp)
                    VALUES('".$board."','".$title."','".$autor."','".$replys."','".$important."','".$recRef."','".$timestamp."')";
        
        $res    = $this->database->query($sql);
        
        if($this->database->affected_rows > 0)
        {
            return $this->database->insert_id;
        }
        else
        {
            return false;
        }
    }
}

?>