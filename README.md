Looks like

    require('ragondin.php');
    $ragondin = new Ragondin();
    $ragondin->get('/', function($req, $res) {
        $res->body = 'welcome';
        $res->status = 200;
    });
    $ragondin->run();
