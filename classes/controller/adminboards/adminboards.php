<?php
namespace controller\adminboards;

use wsc\controller\controller_abstract;
use wsc\form\Form;
use wsc\form\element\Text;
use wsc\form\element\Select;
use wsc\form\element\Checkbox;
use wsc\form\element\Submit;
use model\areas\Areas;
use model\boards\Boards;
use wsc\functions\tools\Tools;
use wsc\systemnotification\SystemNotification;
use wsc\application\Application;

/**
 *
 * @author michi_000
 *        
 */
class adminboards extends controller_abstract
{

    /**
     * (non-PHPdoc)
     *
     * @see \wsc\controller\controller_abstract::default_action()
     *
     */
    public function default_action()
    {
    	
    }
    
    public function add_action()
    {
        $view   = $this->createView();
        $notify = new SystemNotification();
        
        $board  = new Form("add_board");
        $board->setAttribute("method", "post");
        $board->enableDBFunctions(Application::getInstance()->load("database"));
        $board->setDBMod($board::DB_INSERT);
        $board->setDefaultTable("boards");
        
        $name       = new Text("name");
        $name->setLabel("Boardname");
        $name->setTableField("name");
        $name->setRequired();
        $name->setDisplayName("Boardname");
        
        $area       = new Select("area");
        $area->setLabel("Bereich");
        $area->addOption("kein Bereich");
        $area->setTableField("areaId");
        $area->addOptionsFromDBQuery((new Areas())->getAllAreas(), "id", "display_name");
        
        $parent     = new Select("parent");
        $parent->setLabel("Elternelement");
        $parent->addOption("kein Element");
        $parent->setTableField("parentId");
        $parent->addOptionsFromDBQuery((new Boards())->allNotClosedForSubboards(), "id", "name");
        
        $topics     = new Checkbox("allow_topics");
        $topics->setLabel("Deaktiviere Themen im Board");
        $topics->setTableField("disableTopics");
        
        $subboards  = new Checkbox("allow_subboards");
        $subboards->setLabel("Deaktiviere Subboards");
        $subboards->setTableField("disableSubBoards");
        
        $desc       = new Text("description");
        $desc->setLabel("Beschreibung");
        $desc->setTableField("description");
        
        $submit     = new Submit("addboard");
        $submit->setAttribute("value", "Board erstellen");
        
        $board
        ->add($name)
        ->add($area)
        ->add($parent)
        ->add($topics)
        ->add($subboards)
        ->add($submit)
        ->add($desc);
        
        if(isset($_POST['addboard']))
        {
            if($board->isValid())
            {
                $saved  = $board->executeDatabase();
        
                if($saved == true)
                {
                    $notify->addMessage("Die Daten wurden erfolgreich gespeichert.", "success");
                    $view->assign("valid", true);
                }
            }
            else
            {
                $message  = Tools::getFormattedFormErrors($board);
                $notify->addMessage($message, "error");
            }
        }
        
        $view->assign("board", $board);
        $view->assign("notify", $notify->printMessage(true));
    }
}

?>