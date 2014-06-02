<?php
namespace controller\menu_item;

use wsc\controller\controller_abstract;
use wsc\form\Form;
use wsc\form\element\Text;
use wsc\form\element\Select;
use wsc\application\Application;
use wsc\form\element\Submit;
use wsc\systemnotification\SystemNotification;

/**
 *
 * @author michi_000
 *        
 */
class menu_item extends controller_abstract
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
        $db     = Application::getInstance()->load("database");
        $view	= $this->createView();
        $notify = new SystemNotification();
        
        $menuitem   = new Form("menuitem");
        $menuitem->setAttribute("method", "post");
        $menuitem->setDefaultTable("areas");
        $menuitem->enableDBFunctions(Application::getInstance()->load("database"));
        $menuitem->setDBMod($menuitem::DB_INSERT);
        
        $name       = (new Text("pname"))->setDisplayName("Pluginname");
        $name->setLabel("Pluginname");
        $name->setTableField("name", "plugins");
        $name->setRequired();
        $name->setTableField("plugin_name");
        
        $disp_name  = new Text("disp_name");
        $disp_name->setDisplayName("Anzeigename");
        $disp_name->setLabel("Anzeigename");
        $disp_name->setRequired();
        $disp_name->setTableField("display_name");
        
        $style      = new Text("style");
        $style->setDisplayName("CSS Klasse");
        $style->setLabel("CSS Klasse");
        $style->setRequired();
        $style->setTableField("style_name");
        
        $sort       = new Text("sort");
        $sort->setDisplayName("Sortierung");
        $sort->setLabel("Sortierung");
        $sort->setRequired();
        $sort->setTableField("sort");
        
        $action     = new Text("action");
        $action->setDisplayName("Standardaktion");
        $action->setLabel("Standardaktion");
        $action->setTableField("default_action");
        
        
        $parent     = new Select("parent");
        $parent->setLabel("Elternelement");
        $parent->addOption("","Keines");
        $parent->setRequired();
        $parent->setTableField("parent");
        
        $sql_parent = "SELECT * FROM areas";
        $res_parent = $db->query($sql_parent) or die("SQL in Datei: " . __FILE__.__LINE__ . " " . $db->error);
        
        while(($row_parent = $res_parent->fetch_assoc()) == true)
        {
            $parent->addOption($row_parent['id'], $row_parent['display_name']);
        }
        
        $send   = new Submit("additem");
        $send->setAttribute("value", "Men&uuml;element erstellen");
        
        $menuitem
        ->add($name)
        ->add($disp_name)
        ->add($style)
        ->add($sort)
        ->add($action)
        ->add($parent)
        ->add($send);
        
        $this->view->assign("menuitem", $menuitem);
        
        
        if(isset($_POST['additem']))
        {
            
            
            if($menuitem->isValid())
            {
                $menuitem->addManualDBField("", "menu_item", 1);
                
                $saved  = $menuitem->executeDatabase();
                
                if($saved == true)
                {
                    $notify->addMessage("Die Daten wurde erfolgreich gespeichert.", "success");
                    $view->assign("valid", true);
                }

            }
            else
            {
                $message  = "Es sind folgende Fehler bei der Validierung aufgetreten:<br><dl>";
        
                foreach ($menuitem->getMessages() as $element => $messages)
                {
                    $element  = $menuitem->get($element)->getDisplayName();
                    $message  .= "<dt>".$element."</dt>";
        
                    foreach ($messages as $element_msg)
                    {
                        $message  .= "<dd>&bull;&nbsp;" . $element_msg . "</dd>";
                    }
                }
        
                $message  .= "</dl>";
        
                $notify->addMessage($message, "error");
            }
        }
        
        $view->assign(array(
            'notification'    => $notify->printMessage(true),
        ));
    }
}

?>