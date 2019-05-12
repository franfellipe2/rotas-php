<?php

class Route {

       private $url;
       private $routes = [];
       private $params = [];
       private $totalRoutes = 0;
       private $found = false;

       public function __construct($url)
       {
              $this->url = $url;
       }

       /**
        * Verifica se alguma rota foi encontrada
        * Deve ser utilizado depois do método Run(), pois o método run é responsável por chamar a rota correta
        * @return bool
        */
       public function found(): bool
       {
              return $this->found;
       }

       /**
        * Utilizar no final do script para rodar a aplicação e entrar na rota correta 
        * exemplo: $routs = new Route();
        *          $routes->add('minha-rota/{meu-parametro}', function(){...});
        *          $routes->run();
        * @return type
        */
       public function run()
       {
              $i = 0;
              while (!$this->found && $i < $this->totalRoutes):
                     $route = $this->routes[$i]['route'];
                     if ($this->check($route)) {
                            $callback = $this->routes[$i]['callback'];
                            $options = $this->routes[$i]['options'];
                            $this->execute($callback, $options);
                            return $this->found = true;
                     }
                     $i ++;
              endwhile;
              return false;
       }

       public function add($route, callable $callback, $options = null)
       {
              $this->totalRoutes ++;
              $this->routes[] = [
                  'route'    => $route,
                  'callback' => $callback,
                  'options'  => $options
              ];
       }

       public function check($rota)
       {
              $url = $this->url;
              $urlEx = explode('/', $url);
              $rotaEx = explode('/', $rota);
              if (count($urlEx) == count($rotaEx)):
                     foreach ($urlEx as $key => $value):
                            if (strpos($rotaEx[$key], '{') === 0 && strrpos($rotaEx[$key], '}') !== false):
                                   $this->setParam($rotaEx[$key], $value);
                                   $rotaEx[$key] = $value;
                            endif;
                     endforeach;

              endif;
              return implode('/', $rotaEx) == $url;
       }

       private function execute($callback, $options = null)
       {
              // chama a callback
              if (is_array($callback)) {
                     $class = $callback[0];
                     $method = $callback[1];
                     if (is_object($class)) {
                            return $class->$method($this->params, $options);
                     } else {
                            $obj = new $class;
                            return $obj->$method($this->params, $options);
                     }
              } else {
                     return $callback($this->params, $options);
              }
       }

       public function setParam($key, $value)
       {
              $name = str_replace(array('{', '}'), '', $key);
              $this->params[$name] = $value;
       }
}
