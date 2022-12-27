<?php 
$tabela = 'cat_arquivos';
require_once("../../conexao.php");

$nome = $_POST['nome'];
$id = $_POST['id'];
$setor = $_POST['setor'];

//validar nome
$query = $pdo->query("SELECT * FROM $tabela where nome = '$nome' and setor = '$setor'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Categoria já Cadastrada, escolha Outra!';
	exit();
}

if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, setor = '$setor'");
	$acao = 'inserção';

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, setor = '$setor' WHERE id = '$id'");
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