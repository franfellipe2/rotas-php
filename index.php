<?php

require './Lib/autoload.php';
$pessoas = [];
$pessoas[1] = new stdClass();
$pessoas[1]->nome = 'Francisco da silva filho';
$pessoas[1]->idade = '41';
$pessoas[2] = new stdClass();
$pessoas[2]->nome = 'Maria';
$pessoas[2]->idade = '35';
$pessoas[3] = new stdClass();
$pessoas[3]->nome = 'Roberto';
$pessoas[3]->idade = '38';


$rotas = new Route(isset($_GET['url']) ? $_GET['url'] : '/');
$rotas->add('/', function($p, $opts) {
       echo 'index';
       var_dump($opts);
}, ['teste', 'ok']);

$rotas->add('despesas/pessoa/{codigo}', function($params, $pessoas) {
       var_dump($pessoas[$params['codigo']]);
}, $pessoas);

$rotas->add('despesas/farmacia/{nome}', function($params) {
       echo $sql = 'SELECT * FROM farmacias WHERE nome = ' . $params['nome'];
});
$rotas->add('despesas/transporte/{nome}', function($params) {
       echo $sql = 'SELECT * FROM transportes WHERE nome = ' . $params['nome'];
});

if ($rotas->run() === false) {
       echo 'Erro 404: Pagina não encontrada!';
}
