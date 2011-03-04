<?php

require('toupti/middleware.php');

Class Ragondin extends MiddlewareStack 
{
    
    /**
     * construct a standard ragondin middleware stack.
     */
    function __construct()
    {
        parent::__construct();
        $this->add(new HttpReqRes());
        $this->add(new RagondinRoute());
        $this->add(new RagondinDispatch());
    }
}
