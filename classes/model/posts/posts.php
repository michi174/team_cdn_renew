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
        
        if(!empty($id))
        {
            return $this->executeQuery($query)[0];
        }
        
        return false;
    }
    
    public function createPost($topicId, $autor, $subtitle, $text, $createTimestamp=true, $recRef="")
    {
        if($createTimestamp === true)
        {
            $timestamp  = time();
        }
        
        $redID  = $this->database->createRecID();
        
        $sql    = " INSERT ".$this->table."(topicId, autor, subtitle, text, createTimestamp, recRef, recId)
                    VALUES('".$topicId."','".$autor."','".$subtitle."','".$text."','".$timestamp."','".$recRef."', '".$redID."')";
        
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