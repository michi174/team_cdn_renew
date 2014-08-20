<?php
namespace model\posts;

use wsc\model\Model_abstract;

/**
 *
 * @author michi_000
 *        
 */
class Posts extends Model_abstract
{
    private $table  = "posts";
    
    public function getPostsByTopicID($id, $limit = 0, $start = 0, $order="id", $sort = "ASC")
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
    
        $query  = "SELECT * FROM " . $this->table . " WHERE TopicId = ". $id . " ORDER BY " . $order ." ". $sort . $limit_qu;
    
        return $this->executeQuery($query)[0];
    }
}

?>