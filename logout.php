<?php 
@session_start();

require_once("conexao.php");
//inserir log
	$tabela = 'usuarios';
	$acao = 'logout';
	$descricao = 'logout';
	require_once("painel/inserir-logs.php");
	
@session_destroy();

echo "<script>window.location='index.php'</script>";
 ?>