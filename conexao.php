<?php 
date_default_timezone_set('America/Boa_Vista');

/*$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/cadsocial/";
}*/

// conexao local
	$usuario = 'root';
	$senha = '';
	$banco = 'cadsocial';
	$servidor = 'localhost';

try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor", "$usuario", "$senha");
} catch (Exception $e) {
	echo 'Erro ao conectar com o banco de dados! <br>';
	echo $e;
}


//VARIAVEIS GLOBAIS DO SISTEMA
$nome_sistema = 'CADASTRO SOCIAL';
$email_adm = 'administrador@gmail.com';



//inserir registros na tabela config
$query = $pdo->query("SELECT * FROM config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg == 0){
	$pdo->query("INSERT INTO config SET nome = '$nome_sistema', email_adm = '$email_adm', logs = 'Sim', logo = 'logo.png', favicon = 'favicon.ico', logo_rel = 'logo.jpg', dias_limpar_logs = 40, relatorio_pdf = 'pdf' ");
}


//VARIAVEIS DE CONFIGURAÇÕES DA TABELA CONFIG
$query = $pdo->query("SELECT * FROM config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$logs = $res[0]['logs'];
$nome_sistema = $res[0]['nome'];
$email_adm = $res[0]['email_adm'];
$tel_sistema = $res[0]['telefone'];
$end_sistema = $res[0]['endereco'];
$logo = $res[0]['logo'];
$favicon = $res[0]['favicon'];
$logo_rel = $res[0]['logo_rel'];
$dias_limpar_logs = $res[0]['dias_limpar_logs'];
$relatorio_pdf = $res[0]['relatorio_pdf'];
 ?>
