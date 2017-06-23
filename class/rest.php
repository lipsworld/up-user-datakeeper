<?php

namespace UDK;


class REST{

    private $routes;
    private $namespace;

    public function initAction(){
        add_action( 'rest_api_init', function () {

            foreach($this->routes as $route){

                $args = [
                    'callback' => $route['callback'],
                    'methods' => $route['methods']
                ];
                register_rest_route( $route['namespace'], $route['route'], $args, $route['override']);
            }

        });
    }

    public function setNamespace($namespace){
        $this->namespace = $namespace;
    }

    public function addRoute($params){

        $defaults = [
            'namespace' => $this->namespace,
            'route' => '',
            // 'args' => [],
            'methods' => 'GET',
            // 'callback' => ''
            'override' => false
        ];

        $options = array_merge($defaults, $params);
        $o = $options;

        $this->routes[] = $o;
        
    
    }

}


?>