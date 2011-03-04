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
        $this->fouine->ragondin->get('/', function($req, $res)
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
    function __construct() {
        $this->ragondin = new Ragondin();
        $this->ragondin->replace('HttpReqRes', 'MockReqRes');
    }
}
