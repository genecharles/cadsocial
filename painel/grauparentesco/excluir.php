<?php 
$tabela = 'grauparentesco';
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];

//implementar no beneficiário
/*$query = $pdo->query("SELECT * FROM pessoa where grauparentesco = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Este Grau de Parentesco não pode ser excluído, o grau já está relacionado ao Beneficiário!';
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