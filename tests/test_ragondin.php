<?php

class TestRagondin extends FouineTestCase
{
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

    public function testRoutePathParamsAsArgsAndGetParams()
    {
        $this->fouine->ragondin->get('say/:something', function($req, $res) {
            $res->body = $req->params['something'];
            $res->body .= $req->params['there'];
            $res->status = 200;
        });

        $this->fouine->req->get['there'] = ' is a get params';
        $this->fouine->get('/say/there');
        $this->assertEqual($this->fouine->res->body, 'there is a get params');
        $this->assertEqual($this->fouine->res->status, 200);
    }

    public function testRoutePathParamsAsArgsAndPostParams()
    {
        $this->fouine->ragondin->get('say/:something', function($req, $res) {
            $res->body = $req->params['something'];
            $res->body .= $req->params['there'];
            $res->status = 200;
        });

        $this->fouine->req->get['there'] = ' is a post params';
        $this->fouine->get('/say/there');
        $this->assertEqual($this->fouine->res->body, 'there is a post params');
        $this->assertEqual($this->fouine->res->status, 200);
    }
}
