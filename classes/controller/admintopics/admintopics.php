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
    
    private function createForm()
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
        $this->autor->setLabel("Ersteller");
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
        
        $this->important = new Checkbox("important");
        $this->important->setLabel("Als wichtig markieren");
        
        $this->submit = new Submit("submitform");
        $this->submit->setAttribute("value", "Thema erstellen");
        
        $this->form->addManualDBField("", "createTimestamp", time());
        $this->form->addManualDBField("", "autor", $this->autor->getData());
        
        $this->addElementsToForm();
    }
    
    public function add_action()
    {
        $view   = $this->createView();
        $notify = new SystemNotification();
        $this->createForm();
        $this->form->setDBMod(Form::DB_INSERT);
        

        if(isset($_POST['submitform']))
        {
            if($this->form->isValid())
            {
                $saved  = $this->form->executeDatabase();
                
                if($saved === true)
                {
                    $notify->addMessage("Die Daten wurden erfolgreich gespeichert.", "success");
                }
                
                $view->assign("valid", true);
            }
            else
            {
                $message  = Tools::getFormattedFormErrors($this->form);
                $notify->addMessage($message, "error");
            }
        }
        
        $view->assign("topic", $this->form);
        $view->assign("notify",$notify->printMessage(true));
    }
}

?>