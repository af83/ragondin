<?php

class TestRagondin extends UnitTestCase
{
    function setUp()
    {
        $this->fouine = new Fouine();
    }

    /**
     * A Ragondin should respond with 'welcome' on / using GET.
     */
    public function testRoutePath()
    {
        $this->fouine->ragondin->get('', function($req, $res)
        {
            $res->body = 'welcome';
            $res->status = 200;
        });
            
        $this->fouine->get('/');

        $this->assertEqual($this->fouine->res->body, 'welcome');
        $this->assertEqual($this->fouine->res->status, 200);
    }
}

Class Fouine {
    function __construct()
    {
        $this->ragondin = new Ragondin();
        $s = $this->ragondin->getStack();
        $this->ragondin->replace($s[0], new MockReqRes());
    }

    function get($url)
    {
        $stack = $this->ragondin->getStack();
        $stack[0]->req->original_uri = $url;
        $this->res = $stack[0]->res;
        $this->ragondin->run();
    }
}

Class MockReqRes extends Middleware {
    function __construct()
    {
        $this->req = new RequestMock();
        $this->req->method = 'GET';
        $this->res = new TouptiResponse();

        $this->req->post = array();
        $this->req->get = array();
    }

    function run($req, $res)
    {
        $this->follow($this->req, $this->res);
    }
}

Class RequestMock {
}
