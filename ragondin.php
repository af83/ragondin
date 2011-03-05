<?php

require('toupti/middleware.php');
require('toupti/route.php');
require('toupti/request.php');
require('toupti/response.php');

Class Ragondin extends MiddlewareStack 
{
    private $routes = array();

    /**
     * construct a standard ragondin middleware stack.
     */
    function __construct()
    {
        parent::__construct();
        $this->route = new Route();
        $this->add(new HttpReqRes());
        $this->add(new RagondinRoute($this->route));
    }

    function get($key, $callback, $params = array())
    {
        $params['__callback'] = $callback;
        $this->route->add($key, $params);
    }
}

Class HttpReqRes extends Middleware {
    function run($req, $res)
    {
        $res = is_null($res) ? new TouptiResponse() : $res;
        $this->follow(new Request(), $res);
        $res->send();
    }
}

Class RagondinRoute extends Middleware {
    function __construct(Route $route)
    {
        $this->route = $route;
    }

    function run($req, $res)
    {
        $find = $this->route->find_route($req->original_uri);
        // scheme, params, route_path
        if(is_array($find[0]) && isset($find[0]['__callback']) && $find[0]['__callback'] instanceof Closure)
        {
            $req->params = array_merge($req->get(), $req->post(), $find[1]);
            $req->path_key = $find[2];
            $find[0]['__callback']($req, $res);
        }
        $this->follow($req, $res);
    }
}
