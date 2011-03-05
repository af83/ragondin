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
    public function testRootRoutePath()
    {
        $this->fouine->ragondin->get('', function($req, $res) {
            $res->body = 'welcome';
            $res->status = 200;
        });
            
        $this->fouine->get('/');

        $this->assertEqual($this->fouine->res->body, 'welcome');
        $this->assertEqual($this->fouine->res->status, 200);
    }
    public function testRoutePathParams()
    {
        $this->fouine->ragondin->get('say/:something', function($req, $res) {
            $res->body = $req->params['something'];
            $res->status = 200;
        });
            
        $this->fouine->get('/say/hello');

        $this->assertEqual($this->fouine->res->body, 'hello');
        $this->assertEqual($this->fouine->res->status, 200);
    }
    public function testRoutePathParamsAsArgs()
    {
        $this->fouine->ragondin->get('say/:something', function($req, $res) {
            $res->body = $req->params['something'];
            $res->status = 200;
        }, array(':something' => '\d+'));
            
        $this->fouine->get('/say/55');
        $this->assertEqual($this->fouine->res->body, '55');
        $this->assertEqual($this->fouine->res->status, 200);

        $this->expectException(new RouteNotFound('/say/no_way'));
        $this->fouine->get('/say/no_way');
    }
}

Class Fouine {
    function __construct()
    {
        $this->ragondin = new Ragondin();
        $s = $this->ragondin->getStack();
        $reqres = new MockReqRes();
        $this->req = $req->req;
        $this->ragondin->replace($s[0], $reqres);
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
