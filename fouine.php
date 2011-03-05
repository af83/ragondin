<?php

Class FouineTestCase extends UnitTestCase
{
    function setUp()
    {
        $this->fouine = new Fouine();
    }
}

Class Fouine {
    function __construct()
    {
        $this->ragondin = new Ragondin();
        $s = $this->ragondin->getStack();
        $reqres = new MockReqRes();
        $this->req = $reqres->req;
        $this->ragondin->replace($s[0], $reqres);
    }

    function get($url)
    {
        $this->req->original_uri = $url;
        $stack = $this->ragondin->getStack();
        $this->res = $stack[0]->res;
        $this->ragondin->run();
    }
}

Class MockReqRes extends Middleware {
    function __construct()
    {
        $this->req = new RequestMock();
        $this->res = new TouptiResponse();
    }
 
    function run($req, $res)
    {
        $this->follow($this->req, $this->res);
    }
}

Class RequestMock {
    function __construct()
    {
        $this->get = array();
        $this->post = array();
    }
    
    function post()
    {
        return $this->post;
    }

    function get()
    {
        return $this->get;
    }
}
