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
    
    public function getTopicsByBoard($boardId, $limit = 0, $start = 0)
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
        
        $query  = "SELECT * FROM " . $this->table . " WHERE boardsId = ". $boardId . $limit_qu;
        
        return $this->executeQuery($query);
    }
}

?>