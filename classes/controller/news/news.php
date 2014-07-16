<?php
namespace controller\news;

use wsc\controller\controller_abstract;
use wsc\application\Application;
use model\topics\Topics;

/**
 *
 * @author michi_000
 *        
 */
class News extends controller_abstract
{
    
    private $database;

    /**
     * (non-PHPdoc)
     *
     * @see \wsc\controller\controller_abstract::default_action()
     *
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->database = Application::getInstance()->load("database");
    }
    
    public function default_action()
    {
    	
    }
    
    public function overview_action()
    {
        $view   = $this->createView();
        
        $news       = new Topics();
        $allnews    = $news->getTopicsByBoard($this->database->getDataByField("boards", "name", "news")['id']);
        $headline_pattern   = "#\[headline\](.*)\[\/headline\]#ismU";
        
        
        
        foreach ($allnews as $id => $news)
        {
            $autorname  = $this->database->getDataById("userdata", $news['autor'])['username'];
            $text       = $this->database->getDataByField("posts", "topicId", $news['id'])['text'];
            $headlines  = array();
            
            preg_match($headline_pattern, $text, $headlines);
            
            $allnews[$id]['hasHeadline']    = (count($headlines)> 0) ? true : false;
            $allnews[$id]['autor']          = $autorname;
            $allnews[$id]['text']           = (count($headlines)> 0) ? $headlines[1] : $text;
        }
        
        
        $view->assign("allnews", $allnews);
    }
}

?>