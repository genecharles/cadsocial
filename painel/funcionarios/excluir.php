<?php 
$tabela = 'funcionarios';
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
$foto = $res[0]['foto'];
if($foto != "sem-perfil.jpg"){
	@unlink('../images/perfil/'.$foto);
}

$pdo->query("DELETE FROM $tabela where id = '$id'");
$pdo->query("DELETE FROM usuarios where id_usu = '$id'");

echo 'Excluído com Sucesso';

//inserir log
$acao = 'exclusão';
$descricao = $nome;
$id_reg = $id;
require_once("../inserir-logs.php");

?>