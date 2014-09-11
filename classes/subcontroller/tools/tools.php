<?php
namespace subcontroller\tools;

use wsc\controller\Subcontroller_abstract;
use wsc\view\renderer\Tpl;

/**
 *
 * @author michi_000
 *        
 */
class tools extends Subcontroller_abstract
{
    public function runAfterMain()
    {
        $this->createView();
        $this->view->setRenderer(new Tpl());
    }
}

?>