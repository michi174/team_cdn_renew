<?php
namespace controller\admintopics;

use wsc\controller\controller_abstract;
use wsc\form\Form;
use wsc\form\element\Select;
use model\boards\Boards;
use wsc\form\element\Text;
use wsc\application\Application;
use wsc\form\element\Submit;
use wsc\systemnotification\SystemNotification;
use wsc\functions\tools\Tools;
use wsc\form\element\Textarea;
use wsc\form\element\Checkbox;

/**
 *
 * @author michi_000
 *        
 */
class admintopics extends controller_abstract
{

    /**
     * (non-PHPdoc)
     *
     * @see \wsc\controller\controller_abstract::default_action()
     *
     */
    public function default_action()
    {}
    
    public function add_action()
    {
        $view   = $this->createView();
        $notify = new SystemNotification();
        
        $topic  = new Form("add_topic");
        $topic->enableDBFunctions(Application::getInstance()->load("database"));
        $topic->setDefaultTable("topics");
        $topic->setDBMod($topic::DB_INSERT);
        
        
        $board  = new Select("board");
        $board->addOptionsFromDBQuery((new Boards())->getAllBoards(), "id", "name");
        $board->setLabel("Board");
        $board->setTableField("boardsId");
        
        $title  = new Text("title");
        $title->setLabel("Titel");
        $title->setRequired();
        $title->setTableField("title");
        
        $autor  = new Select("autor");
        $user   = Application::getInstance()->load("auth")->getUser();
        $autor->addOption($user->data['id'], $user->data['username']);
        $autor->setLabel("Ersteller");
        $autor->setTableField("autor");
        $autor->setRequired();
        $autor->setAttribute("disabled", "disabled");
        
        $text   = new Textarea("text");
        $text->setLabel("Text");
        $text->setAttribute("type", "textarea");
        $text->setRequired();
        
        $replys = new Checkbox("replys");
        $replys->setLabel("Deaktiviere Antworten auf dieses Thema");
        
        $important = new Checkbox("important");
        $important->setLabel("Als wichtig markieren");
        
        $submit = new Submit("addtopic");
        $submit->setAttribute("value", "Thema erstellen");
        
        $topic->add($title)
        ->add($board)
        ->add($autor)
        ->add($submit)
        ->add($text)
        ->add($replys)
        ->add($important);
        

        if(isset($_POST['addtopic']))
        {
            if($topic->isValid())
            {
                $topic->addManualDBField("", "createTimestamp", time());
                $topic->addManualDBField("", "autor", $user->data['id']);
                
                $saved  = $topic->executeDatabase();
                
                
                
                if($saved["result"] === true)
                {
                    $topic->addManualDBField("posts", "topicId", $saved['database']->insert_id);
                    $topic->addManualDBField("posts", "autor", $user->data['id']);
                    $topic->addManualDBField("posts", "createTimestamp", time());
                    $topic->addManualDBField("posts", "subtitle", $title->getData());
                    $topic->addManualDBField("posts", "text", $text->getData());
                    
                    $saved  = $topic->executeDatabase(true);
                }
                
                
        
                if($saved["result"] === true)
                {
                    $notify->addMessage("Die Daten wurden erfolgreich gespeichert.", "success");
                    $view->assign("valid", true);
                }
            }
            else
            {
                $message  = Tools::getFormattedFormErrors($topic);
                $notify->addMessage($message, "error");
            }
        }
        
        $view->assign("topic",$topic);
        $view->assign("notify",$notify->printMessage(true));
        
        
    }
}

?>