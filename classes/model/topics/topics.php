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
        
        return $topic;
    }
}

?>