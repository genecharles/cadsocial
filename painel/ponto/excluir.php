<?php 
$tabela = 'jornada';
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];

$pdo->query("DELETE FROM $tabela where id = '$id'");

echo 'Excluído com Sucesso';

//inserir log
$acao = 'exclusão';
$descricao = $nome .' Ponto';
$id_reg = $id;
require_once("../inserir-logs.php");

?>