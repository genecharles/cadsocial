<?php 
$tabela = 'pessoas';
require_once("../../conexao.php");
error_reporting(0);

$nome = $_POST['nome-editar-dep'];
$nomesocial = $_POST['nomesocial-editar-dep'];
$sexo = $_POST['sexo-editar-dep'];
$racacor = $_POST['racacor-editar-dep'];
$etnia = $_POST['etnia-editar-dep'];
$religiao = $_POST['religiao-editar-dep'];
$datanasc = $_POST['datanasc-editar-dep'];//
$cpf = $_POST['cpf-editar-dep'];
$cartaovacina = $_POST['cartaovacina-editar-dep'];
$cartaosus = $_POST['cartaosus-editar-dep'];
$reservista = $_POST['reservista-editar-dep'];
$tipodoc = $_POST['tipodoc-editar-dep'];
$docnum = $_POST['docnum-editar-dep'];
$docorgao = $_POST['docorgao-editar-dep'];
$docexpedicao = $_POST['docexpedicao-editar-dep'];




$clt = $_POST['clt-editar-dep'];


$telefone = $_POST['telefone-editar-dep'];
$pai = $_POST['pai-editar-dep'];
$mae = $_POST['mae-editar-dep'];
//$cidade = $_POST['cidade-editar-dep'];//
//$bairro = $_POST['bairro-editar-dep'];//
//$endereco = $_POST['endereco-editar-dep'];//
//PARENTESCO
//DATA_HOJE
//HORA_HOJE
$id_usr_resp = $_POST['id_usr_resp-editar-dep'];
//ATIVO
$id = $_POST['id-editar-dep']; //24

echo "ID_DEP: ". $id;
exit();

//validar cpf
$query = $pdo->query("SELECT * FROM $tabela where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'CPF já Cadastrado, escolha Outro!';
	exit();
}


/*$query = $pdo->query("SELECT * FROM $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Email já Cadastrado, escolha Outro!';
	exit();
}
*/

if($id == ""){	
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, nomesocial = :nomesocial, sexo = '$sexo', racacor = '$racacor', etnia = '$etnia', religiao = '$religiao', datanasc = :datanasc, titular = 0,  cpf = :cpf, cartaovacina = :cartaovacina, cartaosus = :cartaosus, reservista = :reservist, tipodoc = '$tipodoc', docnum = :docnum, docorgao = '$docorgao', docexpedicao  = :docexpedicao, clt = :clt, telefone = :telefone, pai=:pai, mae = :mae, parentesco = 1, data_cad = curDate(), hora_cad = curTime(), id_usr_resp = '$id_usr_resp', ativo = 'Sim'");
	$acao = 'inserção';
	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, nomesocial = :nomesocial, sexo = '$sexo', racacor = '$racacor', etnia = '$etnia', religiao = '$religiao', datanasc = :datanasc, titular = 0,  cpf = :cpf, cartaovacina = :cartaovacina, cartaosus = :cartaosus, reservista = :reservist, tipodoc = '$tipodoc', docnum = :docnum, docorgao = '$docorgao', docexpedicao  = :docexpedicao, clt = :clt, telefone = :telefone, pai=:pai, mae = :mae, parentesco = 1, data_cad = curDate(), hora_cad = curTime(), id_usr_resp = '$id_usr_resp', ativo = 'Sim' where id = '$id'");
	$acao = 'edição';

	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":nomesocial", "$nomesocial");
$query->bindValue(":datanasc", "$datanasc");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":cartaovacina", "$cartaovacina");
$query->bindValue(":cartaosus", "$cartaosus");
$query->bindValue(":reservista", "$reservista");
$query->bindValue(":docnum", "$docnum");
$query->bindValue(":docexpedicao", "$docexpedicao");
$query->bindValue(":clt", "$clt");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":pai", "$pai");
$query->bindValue(":mae", "$mae");

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


echo 'Inserido com Sucesso'; 

?>