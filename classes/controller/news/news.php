<?php
namespace controller\news;

use wsc\controller\controller_abstract;
use wsc\application\Application;
use model\topics\Topics;
use wsc\functions\tools\Tools;
use model\posts\Posts;

/**
 *
 * @author michi_000
 *        
 */
class News extends controller_abstract
{
    const   ID_NAME = "id";
    
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
    	Tools::internalRedirect("news", "overview");
    }
    
    private function getHeadlineFromText($text)
    {
        $headline_pattern   = '#\[headline\](.*)\[\/headline\]#ismU';
        $headlines          = array();
        
        preg_match($headline_pattern, $text, $headlines);
        
        if(count($headlines) > 0)
        {
            return $headlines[1];
            
        }
        else
            return false;
        
    }
    public function overview_action()
    {
        $view   = $this->createView();
        
        $news       = new Topics();
        $allnews    = $news->getTopicsByBoard($this->database->getDataByField("boards", "name", "news")['id'], 5, 0, "createTimestamp", Topics::SORT_DESC);
        $headline_pattern   = '#\[headline\](.*)\[\/headline\]#ismU';
        
        foreach ($allnews as $id => $news)
        {
            $autorname  = $this->database->getDataById("userdata", $news['autor'])['username'];
            $text       = $this->database->getDataByField("posts", "topicId", $news['id'])['text'];
            
            $headline   = $this->getHeadlineFromText($text);
            
            $allnews[$id]['hasHeadline']    = ($headline !== false) ? true : false;
            $allnews[$id]['autor']          = $autorname;
            $allnews[$id]['text']           = ($headline !== false) ? $this->getHeadlineFromText($text) : $text;
        }

        $view->assign("allnews", $allnews);
    }
    
    public function detailview_action()
    {
        $view       = $this->createView();
        $request    = Application::getInstance()->load("request");
        $error      = true;
        
        
        if($request->get(self::ID_NAME) !== null)
        {
            $topic  = new Topics();
            $topicData  = $topic->getTopicById($request->get(self::ID_NAME));
            
            if($topicData !== false)
            {
                $posts      = new Posts();
                $postData   = $posts->getPostsByTopicID($topicData['id'], 1, 0);
                
                if($postData !== false)
                {
                    $headline_pattern   = '#\[headline\](.*)\[\/headline\]#ismU';
                    $headline   = $this->getHeadlineFromText($postData['text']);
                    $postData['text']   = preg_replace($headline_pattern, "", $postData['text']);
                    
                    $view->assign("autor", Tools::getUsernameByID($topicData['autor']));
                    $view->assign("title", $topicData['title']);
                    $view->assign("date", $topicData['createTimestamp']);
                    $view->assign("text", $postData['text']);
                    $view->assign("subtitle", $postData['subtitle']);
                    $view->assign("headline", $headline);
                    $view->assign("id", $topicData['id']);
                    
                    $error  = false;
                }

            }

        }
        
        if($error === true)
        {
            Tools::internalRedirect("error", "notfound");
        }        
    }
}

?>