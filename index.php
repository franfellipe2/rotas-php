<?php

require './Lib/autoload.php';

$rotas = new Route(isset($_GET['url']) ? $_GET['url'] : '/');
$rotas->add('/', function($p, $opts) {
       echo 'index';
       var_dump($opts);
}, ['teste', 'ok']);
$rotas->add('despesas/mercado/{nome}', function($params) {
       echo $sql = 'SELECT * FROM fornecedores WHERE nome = ' . $params['nome'];
});
$rotas->add('despesas/farmacia/{nome}', function($params) {
       echo $sql = 'SELECT * FROM farmacias WHERE nome = ' . $params['nome'];
});
$rotas->add('despesas/transporte/{nome}', function($params) {
       echo $sql = 'SELECT * FROM transportes WHERE nome = ' . $params['nome'];
});
if ($rotas->run() === false) {
       echo 'Erro 404: Pagina não encontrada!';
}