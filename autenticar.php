<?php
session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

/* define o prazo do cache em 120 minutos */
session_cache_expire(120);
$cache_expire = session_cache_expire();
/* inicia a sessão */

@session_start(); 
require_once("conexao.php");

$usuario = $_POST['usuario'];
$senha = md5($_POST['senha']);

$query = $pdo->query("SELECT * FROM usuarios where (email = '$usuario' or cpf = '$usuario') and senha_crip = '$senha'  and ativo = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){
	$_SESSION['id_usuario'] = $res[0]['id'];
	$_SESSION['nome_usuario'] = $res[0]['nome'];
	$_SESSION['cpf_usuario'] = $res[0]['cpf'];
	$_SESSION['nivel_usuario'] = $res[0]['nivel'];

	//inserir log
	$tabela = 'usuarios';
	$acao = 'login';
	$descricao = 'login';
	require_once("painel/inserir-logs.php");

	echo "<script>window.location='painel'</script>";
}else{
	echo "<script>window.alert('Dados Incorretos');</script>";
	echo "<script>window.location='index.php'</script>";
}	
 ?>
