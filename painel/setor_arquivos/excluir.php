<?php 
$tabela = 'setor_arquivos';
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];


$query = $pdo->query("SELECT * FROM cat_arquivos where setor = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Este setor não pode ser excluído, primeiro exclua as categorias relacionadas a ele para depois excluir este setor!';
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