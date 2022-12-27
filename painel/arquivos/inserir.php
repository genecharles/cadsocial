<?php 
$tabela = 'arquivos';
require_once("../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id_usuario'];


$descricao = $_POST['area'];
$numero = $_POST['numero'];
$nome = $_POST['nome'];
$setor = $_POST['setor'];
$categoria = $_POST['categoria'];
$grupo = $_POST['grupo'];
$fornecedor = $_POST['fornecedor'];
$cliente = $_POST['cliente'];
$funcionario = $_POST['funcionario'];
$vencimento = $_POST['vencimento'];
$id = $_POST['id'];


if($nome == ""){
	echo 'Preencha o nome do arquivo!';
	exit();
}

if($numero != ""){
//validar nome
$query = $pdo->query("SELECT * FROM $tabela where numero = '$numero'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Número de arquivo já Cadastrado, escolha Outro!';
	exit();
}
}


$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['arquivo'];
}else{
	$foto = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['arquivo']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../images/arquivos/' .$nome_img;

$imagem_temp = @$_FILES['arquivo']['tmp_name']; 

if(@$_FILES['arquivo']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == 'rar' or $ext == 'zip' or $ext == 'doc' or $ext == 'docx' or $ext == 'txt' or $ext == 'xlsx' or $ext == 'xlsm' or $ext == 'xls' or $ext == 'xml' ){ 

		if (@$_FILES['arquivo']['name'] != ""){

			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.png"){
				@unlink('images/arquivos/'.$foto);
			}

			$foto = $nome_img;
		}

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET numero = :numero, nome = :nome, descricao = :descricao, setor = '$setor', categoria = '$categoria', grupo = '$grupo', fornecedor = '$fornecedor', cliente = '$cliente', funcionario = '$funcionario', data_cad = curDate(), vencimento = '$vencimento', usuario_cad = '$id_usuario', arquivo = '$foto'");
	$acao = 'inserção';

}else{
	$query = $pdo->prepare("UPDATE $tabela SET numero = :numero, nome = :nome, descricao = :descricao, setor = '$setor', categoria = '$categoria', grupo = '$grupo', fornecedor = '$fornecedor', cliente = '$cliente', funcionario = '$funcionario', data_cad = curDate(), vencimento = '$vencimento', usuario_editou = '$id_usuario', arquivo = '$foto' where id = '$id'");
	$acao = 'edição';
	
}

$query->bindValue(":descricao", "$descricao");
$query->bindValue(":numero", "$numero");
$query->bindValue(":nome", "$nome");
$query->execute();
$ult_id = $pdo->lastInsertId();



if(@$ult_id == "" || @$ult_id == 0){
	$ult_id = $id;
}

//inserir log
$acao = $acao;
$descricao = $descricao;
$id_reg = $ult_id;
require_once("../inserir-logs.php");

echo 'Salvo com Sucesso'; 

?>