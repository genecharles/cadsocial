<?php 
$tabela = 'tarefas';
require_once("../../conexao.php");

@session_start();
$id_usuario = @$_SESSION['id_usuario'];

$titulo = $_POST['titulo'];
$data = $_POST['data'];
$hora = $_POST['hora'];
$descricao = $_POST['descricao'];
$obs = $_POST['area'];
$id = $_POST['id'];


//validar cpf
$query = $pdo->query("SELECT * FROM $tabela where data = '$data' and hora = '$hora' and usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Este horário não está disponível!';
	exit();
}


if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET titulo = :titulo, descricao = :descricao, hora = '$hora', data = '$data', usuario = '$id_usuario', usuario_lanc = '$id_usuario', status = 'Agendada', obs = :obs");
	$acao = 'inserção';
	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET titulo = :titulo, descricao = :descricao, hora = '$hora', data = '$data', usuario = '$id_usuario', obs = :obs where id = '$id'");
	$acao = 'edição';

	
}

$query->bindValue(":titulo", "$titulo");
	$query->bindValue(":descricao", "$descricao");
	$query->bindValue(":obs", "$obs");
	$query->execute();
	$ult_id = $pdo->lastInsertId();


if(@$ult_id == "" || @$ult_id == 0){
	$ult_id = $id;
}

//inserir log
$acao = $acao;
$descricao = $titulo;
$id_reg = $ult_id;
require_once("../inserir-logs.php");

echo 'Salvo com Sucesso'; 

?>