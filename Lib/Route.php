<?php

class Route {

       private $url;
       private $routes = [];
       private $params = [];
       private $totalVerified = 0;

       public function __construct($url)
       {
              $this->url = $url;
       }

       public function __destruct()
       {
              $found = false;
              $total = count($this->routes);
              $i = 0;
              while ($found === false && $i < $total):
                     // Calcula o total de rotas verificadas
                     $this->totalVerified ++;                                          
                     $route = $this->routes[$i]['route'];
                     $callback = $this->routes[$i]['callback'];
                     if ($this->check($route)) {
                            $found = true;
                            $this->execute($callback);
                     }
                     $i ++;
              endwhile;
       }

       public function add($route, callable $callback)
       {
              $this->routes[] = [
                  'route'    => $route,
                  'callback' => $callback
              ];
       }

       public function check($rota)
       {
              $url = $this->url;
              $urlEx = explode('/', $url);
              $rotaEx = explode('/', $rota);
              if (count($urlEx) == count($rotaEx)):
                     foreach ($urlEx as $key => $value):
                            if (strpos($rotaEx[$key], '{') === 0):
                                   $this->setParam($rotaEx[$key], $value);
                                   $rotaEx[$key] = $value;
                            endif;
                     endforeach;

              endif;
              return implode('/', $rotaEx) == $url;
       }

       public function execute($callback)
       {
              // chama a callback
              if (is_array($callback)) {                     
                     $class = $callback[0];
                     $method = $callback[1];
                     if (is_object($class)) {
                            return $class->$method($this->params);
                     } else {
                            $obj = new $class;
                            return $obj->$method($this->params);
                     }
              } else {
                     return $callback($this->params);
              }
       }

       public function setParam($key, $value)
       {
              $name = str_replace(array('{', '}'), '', $key);
              $this->params[$name] = $value;
       }
}
