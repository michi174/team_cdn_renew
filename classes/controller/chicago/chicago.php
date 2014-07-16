<?php
namespace controller\chicago;

use wsc\controller\controller_abstract;

/**
 *
 * @author michi_000
 *        
 */
class chicago extends controller_abstract
{

    /**
     * (non-PHPdoc)
     *
     * @see \wsc\controller\controller_abstract::default_action()
     *
     */
    public function default_action()
    {
    	$view  = $this->createView();
    }
}

?>