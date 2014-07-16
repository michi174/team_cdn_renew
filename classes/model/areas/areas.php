<?php
namespace model\areas;

use wsc\model\Model_abstract;

/**
 *
 * @author michi_000
 *        
 */
class Areas extends Model_abstract
{
    private $table      = "areas";
    
    public function getAllAreasIds()
    {
        
    }
    
    public function getAllAreas()
    {
        $query  = "SELECT * FROM " . $this->table;
        
        return $this->executeQuery($query);
    }
    
    public function getEntriesByFields(array $fields, $limit = null)
    {
        $query  = "SELECT * FROM " . $this->table . " WHERE ";
        
        $i      = 0;
        $limit  = count($fields);
        
        $and    = "";
        
        foreach($fields as $field => $values)
        {
            if($i != $limit || $limit != 1)
            {
                $and    = " AND ";
            }
            else 
            {
                $and    = "";
            }
            
            if(!is_array($values))
            {
                $query  .= $field . " = '" . $values ."'". $and;
            }
            else
            {
                $query  .= "(";
                   
                $k          = 0;
                $num_val    = count($values);
                $or         = null;
                
                foreach ($values as $value)
                {
                    if($k != $num_val || $num_val != 1)
                    {
                        $or = " OR ";
                    }
                    else
                    {
                        $or = "";
                    }
                    $query  .= $field. " = '" .$value. "'".$or;
                }
                
                $query  .= ")";
            }
        }
        if(is_int($limit))
        {
            $query  .= "LIMIT ".$limit;
        }
        
        return $this->executeQuery($query);
    }
}

?>