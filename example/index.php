<?php    

require('../ragondin.php');

$ragondin = new Ragondin();

$ragondin->get('', function($req, $res) {
               $res->body = 'welcome';
               $res->set_status(200);
               });

$ragondin->get('hello', function($req, $res) {
               $res->body = 'Hello world';
               $res->set_status(200);
               });

$ragondin->get('hello/:pouet', function($req, $res) {
               $res->body = 'Hello coucou';
               $res->set_status(200);
               var_dump($req);
               }, array(':pouet' => '\w+'));

$ragondin->run();

