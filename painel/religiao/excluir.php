<?php 
$tabela = 'religiao';
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];

//implementar no beneficiário
/*$query = $pdo->query("SELECT * FROM pessoa where religiao = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Esta cidade não pode ser excluída, primeiro exclua os bairros relacionados a ela para depois excluir esta cidade!';
	exit();
}*/

$pdo->query("DELETE FROM $tabela where id = '$id'");

echo 'Excluído com Sucesso';

//inserir log
$acao = 'exclusão';
$descricao = $nome;
$id_reg = $id;
require_once("../inserir-logs.php");

?>