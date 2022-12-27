<?php 
$tabela = 'cat_arquivos';
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];


$query = $pdo->query("SELECT * FROM grupo_arquivos where categoria = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Esta categoria não pode ser excluída, primeiro exclua os grupos relacionados a ela para depois excluir esta categoria!';
	exit();
}


$pdo->query("DELETE FROM $tabela where id = '$id'");

echo 'Excluído com Sucesso';

//inserir log
$acao = 'exclusão';
$descricao = $nome;
$id_reg = $id;
require_once("../inserir-logs.php");

?>