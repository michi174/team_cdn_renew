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
    
    protected $form;
    protected $elements   = array();
    
    public function __construct()
    {
        $this->form = new Form("admintopics");
        $this->form->enableDBFunctions(Application::getInstance()->load("database"));
        $this->form->setDefaultTable("topics");
    }
    
    public function __get($element)
    {
        if(isset($this->elements))
        {
            return $this->elements[$element];
        }
    }
    
    public function __set($name, $element)
    {
        $this->elements[$name]  = $element;
    }
    
    protected function getForm()
    {
        return $this->form;
    }
    
    protected function addElementsToForm()
    {
        if(count($this->elements) > 0)
        {
            foreach ($this->elements as $element)
            {
                $this->form->add($element);
            }
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \wsc\controller\controller_abstract::default_action()
     *
     */
    public function default_action()
    {}
    
    protected function createForm()
    {
        $this->board  = new Select("board");
        $this->board->addOptionsFromDBQuery((new Boards())->getAllBoards(), "id", "name");
        $this->board->setLabel("Board");
        $this->board->setTableField("boardsId");
        
        $this->title  = new Text("title");
        $this->title->setLabel("Titel");
        $this->title->setRequired();
        $this->title->setTableField("title");
        
        $this->autor  = new Select("autor");
        $user   = Application::getInstance()->load("auth")->getUser();
        
        $this->autor->addOption($user->data['id'], $user->data['username']);
        $this->autor->setLabel("Bearbeiter");
        $this->autor->setTableField("autor");
        $this->autor->setRequired();
        
        $this->text   = new Textarea("text");
        $this->text->setLabel("Text");
        $this->text->setAttribute("type", "textarea");
        $this->text->setRequired();
        $this->text->setTableField("text", "posts");
        
        $this->form->addDependQuery("posts", "topics", "topicId");
        
        $this->replys = new Checkbox("replys");
        $this->replys->setLabel("Deaktiviere Antworten auf dieses Thema");
        $this->replys->setTableField("disableReplys");
        
        $this->important = new Checkbox("important");
        $this->important->setLabel("Als wichtig markieren");
        $this->important->setTableField("important");
        
        $this->submit = new Submit("submitform");
        $this->submit->setAttribute("value", "Thema erstellen");
        
        $this->form->addManualDBField("", "createTimestamp", time());
        $this->form->addManualDBField("", "autor", $this->autor->getData());
        
        $this->addElementsToForm();
    }
    
    public function add_action()
    {
        $view   = $this->createView();
        $this->view->assign("title", "Neues Thema erstellen");
        $this->createForm();
        $this->form->setDBMod(Form::DB_INSERT);
        $this->submit();

        $view->assign("topic", $this->form);
    }
    
    public function update_action()
    {
        $view   = $this->createView();
        $this->view->assign("title", "Thema bearbeiten");
        $view->setViewFile("add.php");
        $notify = new SystemNotification();
        $this->createForm();
        $this->form->setDBMod(Form::DB_UPDATE);
        $this->form->setUpdateID("id", Application::getInstance()->load("request")->request("id"));
        $this->submit->setAttribute("value", "Thema bearbeiten");
        $this->submit();

        $view->assign("topic", $this->form);
    }
    
    public function delete_action()
    {
        $notify = new SystemNotification();
        $this->createForm();
        $this->form->setDBMod(Form::DB_DELETE);
        $this->form->setUpdateID("id", Application::getInstance()->load("request")->request("id"));
        $this->form->executeDatabase();
        $this->createView();
        
        $request    = Application::getInstance()->load("request");
        $cfg        = Application::getInstance()->load("config");
        
        $notify->addMessage("Daten wurden erfolgreich gel&ouml;scht.", "success");
        
        if($request->issetGet("next"))
        {
            $notify->addButton($request->get("next"), "&laquo; Zur&uuml;ck zur vorherigen Seite");
            
            if($request->issetGet("autoredirect"))
            {
                Application::getInstance()->load("response")->redirect($request->get("next"));
            }
        }
        
        $notify->addButton("?", "Startseite &raquo;");
        
        $this->view->assign("notify", $notify->printMessage(true));
    }
    
    protected function submit()
    {
        if(isset($_POST['submitform']))
        {
            $notify = new SystemNotification();
    
            if($this->form->isValid())
            {
                $saved  = $this->form->executeDatabase();
    
                if($saved === true)
                {
                    $notify->addMessage("Die Daten wurden erfolgreich gespeichert.", "success");
                    $notify->addButton("?site=news&id=5", "Weiter &raquo;");
                }
    
                $this->view->assign("valid", true);
            }
            else
            {
                $message  = Tools::getFormattedFormErrors($this->form);
                $notify->addMessage($message, "error");
            }
    
            $this->view->assign("notify",$notify->printMessage(true));
        }
    }
}

?>