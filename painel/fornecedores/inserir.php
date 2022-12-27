<?php 
$tabela = 'fornecedores';
require_once("../../conexao.php");

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$doc = $_POST['doc'];
$pessoa = $_POST['pessoa'];
$email = $_POST['email'];
$data_nasc = $_POST['data_nasc'];
$endereco = $_POST['endereco'];
$obs = $_POST['obs'];
$id = $_POST['id'];

if($pessoa == 'Jurídica'){
	$data_nasc = '0000-00-00';
}

//validar cpf
$query = $pdo->query("SELECT * FROM $tabela where doc = '$doc'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Documento já Cadastrado, escolha Outro!';
	exit();
}


$query = $pdo->query("SELECT * FROM $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Email já Cadastrado, escolha Outro!';
	exit();
}


if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, pessoa = '$pessoa', doc = :doc, telefone = :telefone, email = :email, endereco = :endereco, data_cad = curDate(), data_nasc = '$data_nasc', obs = :obs, ativo = 'Sim'");
	$acao = 'inserção';
	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, pessoa = '$pessoa', doc = :doc, telefone = :telefone, email = :email, endereco = :endereco, data_nasc = '$data_nasc', obs = :obs where id = '$id'");
	$acao = 'edição';

	
}

$query->bindValue(":nome", "$nome");
	$query->bindValue(":doc", "$doc");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":email", "$email");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":obs", "$obs");
	$query->execute();
	$ult_id = $pdo->lastInsertId();


if(@$ult_id == "" || @$ult_id == 0){
	$ult_id = $id;
}

//inserir log
$acao = $acao;
$descricao = $nome;
$id_reg = $ult_id;
require_once("../inserir-logs.php");

echo 'Salvo com Sucesso'; 

?>