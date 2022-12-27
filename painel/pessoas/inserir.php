<?php 
$tabela = 'pessoas';
require_once("../../conexao.php");
error_reporting(0);

$nome = $_POST['nome'];
$nomesocial = $_POST['nomesocial'];
$sexo = $_POST['sexo'];
$racacor = $_POST['racacor'];
$etnia = $_POST['etnia'];
//TITULAR_PROVEDOR
$cpf = $_POST['cpf'];
$tipodoc = $_POST['tipodoc'];
$docnum = $_POST['docnum'];
$docorgao = $_POST['docorgao'];
$docexpedicao = $_POST['docexpedicao'];
$religiao = $_POST['religiao'];
$pai = $_POST['pai'];
$mae = $_POST['mae'];
$datanasc = $_POST['datanasc'];//
$reservista = $_POST['reservista'];
$clt = $_POST['clt'];
$cartaosus = $_POST['cartaosus'];
$cartaovacina = $_POST['cartaovacina'];
$telefone = $_POST['telefone'];
$cidade = $_POST['cidade'];//
$bairro = $_POST['bairro'];//
$endereco = $_POST['endereco'];//
//PARENTESCO
//DATA_HOJE
//HORA_HOJE
$id_usr_resp = $_POST['id_usr_resp'];
//ATIVO
$id = $_POST['id']; //24



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
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, nomesocial = :nomesocial, sexo = '$sexo', racacor = '$racacor', etnia = '$etnia', titular = 1, cpf = :cpf, tipodoc = '$tipodoc', docnum = :docnum, docorgao = '$docorgao', docexpedicao  = :docexpedicao, religiao = '$religiao', pai=:pai, mae = :mae, datanasc = :datanasc, reservista = :reservista, clt = :clt, cartaosus = :cartaosus, cartaovacina = :cartaovacina, telefone = :telefone, cidade = '$cidade', bairro = '$bairro', endereco = :endereco, parentesco = 1, data_cad = curDate(), hora_cad = curTime(), id_usr_resp = '$id_usr_resp', ativo = 'Não'");
	$acao = 'inserção';
	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, nomesocial = :nomesocial, sexo = '$sexo', racacor = '$racacor', etnia = '$etnia', titular = 1, cpf = :cpf, tipodoc = '$tipodoc', docnum = :docnum, docorgao = '$docorgao', docexpedicao  = :docexpedicao, religiao = '$religiao', pai=:pai, mae = :mae, datanasc = :datanasc, reservista = :reservista, clt = :clt, cartaosus = :cartaosus, cartaovacina = :cartaovacina, telefone = :telefone, cidade = '$cidade', bairro = '$bairro', endereco = :endereco, parentesco = 1, data_cad = curDate(), hora_cad = curTime(), id_usr_resp = '$id_usr_resp', ativo = 'Sim' where id = '$id'");
	$acao = 'edição';

	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":nomesocial", "$nomesocial");
$query->bindValue(":cpf", "$cpf");

$query->bindValue(":docnum", "$docnum");//
$query->bindValue(":docexpedicao", "$docexpedicao");//data emissao
$query->bindValue(":pai", "$pai");
$query->bindValue(":mae", "$mae");
$query->bindValue(":datanasc", "$datanasc");
$query->bindValue(":reservista", "$reservista");//
$query->bindValue(":clt", "$clt");
$query->bindValue(":cartaosus", "$cartaosus");//
$query->bindValue(":cartaovacina", "$cartaovacina");//
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");	

$query->execute();
$ult_id = $pdo->lastInsertId();


$query = $pdo->prepare("UPDATE $tabela SET codfam = '$ult_id' where id = '$ult_id'");
$query->execute();



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