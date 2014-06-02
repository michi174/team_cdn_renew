<?php
namespace subcontroller\informations;

use wsc\controller\Subcontroller_abstract;

/**
 *
 * @author michi_000
 *        
 */
class Informations extends Subcontroller_abstract
{
    public function runAfterMain()
    {
        $view   = $this->createView();
    }
}

?>