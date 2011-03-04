<?php
$root_path = dirname(__FILE__) . '/..';
require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');

require_once($root_path . '/ragondin.php');

// require_once($root_path . '/testcase.php');
// require_once($root_path . '/request.php');
// require_once($root_path . '/response.php');
// require_once($root_path . '/middleware.php');

class RagondinTestSuite extends TestSuite
{
    public function __construct()
    {
        parent::__construct('Ragondin');
        $test_dir = dirname(__FILE__);
        $this->addFile($test_dir .'/test_ragondin.php');
    }
}
