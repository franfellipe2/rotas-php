<?php

require './Lib/autoload.php';

$rotas = new Rotas(isset($_GET['url']) ? $_GET['url'] : '/');
$rotas->add('/', function($params) {
       echo 'index';
});
$rotas->add('despesas/mercado/{nome}', function($params) {
       echo $sql = 'SELECT * FROM fornecedores WHERE nome = ' . $params['nome'];
});
$rotas->add('despesas/farmacia/{nome}', function($params) {
       echo $sql = 'SELECT * FROM fornecedores WHERE nome = ' . $params['nome'];
});
$rotas->add('despesas/transporte/{nome}', function($params) {
       echo $sql = 'SELECT * FROM fornecedores WHERE nome = ' . $params['nome'];
});
