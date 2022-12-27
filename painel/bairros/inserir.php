<?php 
$tabela = 'bairros';
require_once("../../conexao.php");

$nome = $_POST['nome'];
$cidade = $_POST['cidade'];
$id = $_POST['id'];

//validar nome
$query = $pdo->query("SELECT * FROM $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id and $res[0]['cidade'] == $cidade){
	echo 'Bairro já Cadastrado nesta cidade, escolha Outro Bairro!';
	exit();	
}

if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, cidade = '$cidade', ativo = 'Sim'");
	$acao = 'inserção';

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, cidade = '$cidade' WHERE id = '$id'");
	$acao = 'edição';
}

$query->bindValue(":nome", "$nome");
$query->execute();
$ult_id = $pdo->lastInsertId();

if($ult_id == "" || $ult_id == 0){
	$ult_id = $id;
}

//inserir log
$acao = $acao;
$descricao = $nome;
$id_reg = $ult_id;
require_once("../inserir-logs.php");

echo 'Salvo com Sucesso'; 

?>