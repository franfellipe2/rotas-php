<?php

class Rotas {

       private $url;
       private $routes = [];
       private $params = [];
       private $found;
       private $totalVerified = 0;

       public function __construct($url)
       {
              $this->url = $url;
       }

       public function add($route, callable $callback)
       {
              $this->setRoute($route);
              // Verifica se não existe nenhuma rota encontrada
              if ($this->found != true) {
                     // incrementa a verificação de rotas
                     $this->totalVerified ++;
                     // Verifica as rotas
                     if ($this->check($route)) {
                            // chama a callback
                            $callback($this->params);
                            $this->found = true;
                     }
              }
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

       public function setParam($key, $value)
       {
              $name = str_replace(array('{', '}'), '', $key);
              $this->params[$name] = $value;
       }

       public function setRoute($route)
       {
              $this->routes[] = $route;
       }
}
