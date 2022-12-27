<?php 
$tabela = 'pessoas';
require_once("../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];

$id = $_POST['id-provedor']; // id do PROVEDOR DA FAMILIA para ser inserido no cod_da_familia
$nome = $_POST['nome-dep'];
$cpf = $_POST['cpf-dep'];
$datanasc = $_POST['dtnas-dep'];
$sexo = $_POST['sexo-dep'];
$parentesco = $_POST['parentesco-dep'];

$racacor = $_POST['racacor-dep'];
$etnia = $_POST['etnia-dep'];
$religiao = $_POST['religiao-dep'];
$telefone = $_POST['telefone-dep'];
$pai = $_POST['pai-dep'];
$mae = $_POST['mae-dep'];
$tipodoc = $_POST['tipodoc-dep'];//
$docnum = $_POST['docnum-dep'];
$docorgao = $_POST['docorgao-dep'];
$docexpedicao = $_POST['docexpedicao-dep'];
$cartaovacina = $_POST['cartaovacina-dep'];
$cartaosus = $_POST['cartaosus-dep'];
$reservista = $_POST['reservista-dep'];
$clt = $_POST['clt-dep'];



//validar cpf
$query = $pdo->query("SELECT * FROM $tabela where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){//and $res[0]['id'] != $id
	$nome_pessoa = $res[0]['nome'];
	$cod_familiar = $res[0]['codfam'];
	echo 'CPF já Cadastrado em nome de '.$nome_pessoa;
	echo '. Código Familiar: '.$cod_familiar;
	exit();
}


$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, nomesocial = '', cpf = :cpf, datanasc = :datanasc, sexo = '$sexo', parentesco = '$parentesco', racacor = '$racacor', etnia = '$etnia', titular = 0, codfam = '$id', cidade = 0, bairro = 0, data_cad = curDate(), hora_cad = curTime(), tipodoc = '$tipodoc', docnum = :docnum, docorgao = '$docorgao', docexpedicao = '$docexpedicao', religiao = '$religiao', pai = :pai, mae = :mae, reservista = :reservista, clt = :clt, cartaosus = :cartaosus, cartaovacina = :cartaovacina, telefone = :telefone, endereco = '', id_usr_resp = '$id_usuario', ativo = 'Sim'");
	
$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":docnum", "$docnum");
$query->bindValue(":cartaovacina", "$cartaovacina");
$query->bindValue(":cartaosus", "$cartaosus");
$query->bindValue(":reservista", "$reservista");
$query->bindValue(":clt", "$clt");
$query->bindValue(":datanasc", "$datanasc");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":pai", "$pai");
$query->bindValue(":mae", "$mae");
$query->execute();

echo 'Inserido com Sucesso';

?>


