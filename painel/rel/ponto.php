<?php 
require_once("../../conexao.php");
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$funcionario = $_GET['funcionario'];

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));


$mes = utf8_encode(strftime('%B de %Y', strtotime($dataInicial)));
$texto_apuracao = 'FOLHA DE PONTO '.$mes; 

$query = $pdo->query("SELECT * FROM funcionarios where id = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_func = $res[0]['nome'];
$salario = $res[0]['salario'];
$valor_hora = $res[0]['valor_hora'];

if($valor_hora != "" and $valor_hora != "0.00"){
	$salario = number_format($valor_hora, 2, ',', '.'). ' HORA';
}else{
	$salario = number_format($salario, 2, ',', '.'). ' MÊS';
}

 ?>



 <!DOCTYPE html>
<html>
<head>
	<title>Folha de Ponto</title>

	<?php 
		if($relatorio_pdf != 'pdf'){
	 ?>
	<link rel="icon" href="<?php echo $url_sistema ?>/img/<?php echo $favicon ?>" type="image/x-icon">

	<?php } ?>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">


	<style>

		@page {
			margin: 0px;

		}

		body{
			margin-top:0px;
			font-family:Times, "Times New Roman", Georgia, serif;
		}


		<?php if($relatorio_pdf == 'pdf'){ ?>

			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;
				position:absolute;
				bottom:0;
			}

		<?php }else{ ?>
			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;

			}

		<?php } ?>

		.cabecalho {    
			padding:10px;
			margin-bottom:30px;
			width:100%;
			font-family:Times, "Times New Roman", Georgia, serif;
		}

		.titulo_cab{
			color:#0340a3;
			font-size:17px;
		}

		
		
		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}



		hr{
			margin:8px;
			padding:0px;
		}


		
		.area-cab{
			
			display:block;
			width:100%;
			height:10px;

		}

		
		.coluna{
			margin: 0px;
			float:left;
			height:23px;
		}

		.area-tab{
			
			display:block;
			width:100%;
			height:23px;

		}


		.imagem {
			width: 200px;
			position:absolute;
			right:20px;
			top:10px;
		}

		.titulo_img {
		position: absolute;
		margin-top: 10px;
		margin-left: 10px;
		
		}

		.data_img {
		position: absolute;
		margin-top: 40px;
		margin-left: 10px;
		border-bottom:1px solid #000;
		font-size: 10px;
		}

		.endereco {
		position: absolute;
		margin-top: 50px;
		margin-left: 10px;
		border-bottom:1px solid #000;
		font-size: 10px;
		}
		

	</style>


</head>
<body>	

		
		<div class="titulo_cab titulo_img"><u>Folha de Ponto</u></div>	
		<div class="data_img"><?php echo mb_strtoupper($data_hoje) ?></div>
		
		<?php 
			if($logo_rel != ''){
		 ?>
		<img class="imagem" src="<?php echo $url_sistema ?>img/<?php echo $logo_rel ?>" width="200px" height="60">

		<?php } ?>
	

	<br><br><br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" style="padding-top:10px ">

	<section class="area-cab">
			
		<div class="coluna" style="width:50%">
			<small><small><small><b>FUNCIONÁRIO <?php echo mb_strtoupper($nome_func) ?></b></small></small></small>
		</div>
		

		<div align="right" class="coluna" style="width:50%">
			<small><small><small>SALÁRIO R$ <?php echo mb_strtoupper($salario) ?></small></small></small>
		</div>

		
		
		</section>

		<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
		</div>

		<br>
	
	<?php 
	$query = $pdo->query("SELECT * FROM jornada where funcionario = '$funcionario' and data >= '$dataInicial' and data <= '$dataFinal' order by data asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){
		?>

		

	<small><small>
				<section class="area-tab" style="background-color: #f5f5f5;">
					
					<div class="linha-cab" style="padding-top: 0px;">
						<div class="coluna" style="width:15%">DATA</div>
						<div class="coluna" style="width:10%">ENTRADA</div>
						<div class="coluna" style="width:10%">ALMOÇO</div>
						<div class="coluna" style="width:10%">ALMOÇO</div>
						<div class="coluna" style="width:10%">SAÍDA</div>
						<div class="coluna" style="width:15%">TOTAL</div>
						<div align="center" class="coluna" style="width:10%">INTERVALO</div>
						<div align="center" class="coluna" style="width:20%">HORA EXTRA</div>

					</div>
					
				</section><small></small>

				<div class="cabecalho mb-1" style="border-bottom: solid 1px #e3e3e3;">
				</div>

				<?php
				 for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){}
					$id = $res[$i]['id'];
$data = $res[$i]['data'];
$entrada = $res[$i]['entrada'];
$entrada_almoco = $res[$i]['entrada_almoco'];
$saida_almoco = $res[$i]['saida_almoco'];
$saida = $res[$i]['saida'];
$total_horas = $res[$i]['total_horas'];
$hora_extra = $res[$i]['hora_extra'];
$folga = $res[$i]['folga'];
$falta = $res[$i]['falta'];
$feriado = $res[$i]['feriado'];
$intervalo = $res[$i]['intervalo'];

$dataF = implode('/', array_reverse(explode('-', $data)));
$entrada = date("H:i", strtotime($entrada));
$entrada_almoco = date("H:i", strtotime($entrada_almoco));
$saida_almoco = date("H:i", strtotime($saida_almoco));
$saida = date("H:i", strtotime($saida));
$total_horas = date("H:i", strtotime($total_horas));
$hora_extra = date("H:i", strtotime($hora_extra));
$intervalo = date("H:i", strtotime($intervalo));

$classe_linha = '';

if($hora_extra != '00:00'){
	$classe_extra = 'text-danger';
}else{
	$classe_extra = '';
}

if($folga != ""){
	$entrada = 'Folga';
	$entrada_almoco = 'Folga';
	$saida_almoco = '';
	$saida = 'Folga';
	$total_horas = 'Folga';
	$hora_extra = 'Folga';
	$classe_linha = 'text-primary';
}

if($falta != ""){
	$entrada = 'Falta';
	$entrada_almoco = 'Falta';
	$saida_almoco = '';
	$saida = 'Falta';
	$total_horas = 'Falta';
	$hora_extra = 'Falta';
	$classe_linha = 'text-danger';
}


if($feriado != ""){
	$entrada = 'Feriado';
	$entrada_almoco = 'Feriado';
	$saida_almoco = '';
	$saida = 'Feriado';
	$total_horas = 'Feriado';
	$hora_extra = 'Feriado';
	$classe_linha = 'verde';
}


					
				?>
				<small>
				<section class="area-tab" style="padding-top:0px">					
					<div class="linha-cab <?php echo $classe_linha ?> <?php echo $inativa ?>">				
						<div class="coluna" style="width:15%"><?php echo $dataF ?></div>

						<div class="coluna" style="width:10%"><?php echo $entrada ?></div>

						<div class="coluna" style="width:10%"><?php echo $entrada_almoco ?></div>

							<div class="coluna" style="width:10%"><?php echo $saida_almoco ?></div>

						<div class="coluna" style="width:10%"><?php echo $saida ?></div>

						<div class="coluna" style="width:15%"><?php echo $total_horas ?></div>		

						<div align="center" class="coluna" style="width:10%"><?php echo $intervalo ?></div>		

						<div align="center" class="coluna <?php echo $classe_extra ?>" style="width:20%"><?php echo $hora_extra ?></div>		

		

					</div>
				</section>
				</small>
				<div class="cabecalho" style="border-bottom: solid 1px #e3e3e3;">
				</div>

			<?php } ?>

			</small>



		</div>


		<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
		</div>


	<?php }else{
		echo '<div style="margin:8px"><small><small>Sem Registros no banco de dados!</small></small></div>';
	} ?>


	<br><br>
	<div class="col-md-12 p-2">
			<div class="" align="center">

				________________________________________________________<br>
				<span class=""> <small><small><small><?php echo mb_strtoupper($texto_apuracao) ?></small></small></small>  </span>

			</div>
		</div>
		




	<div class="footer"  align="center">
		<span style="font-size:10px"><?php echo $end_sistema ?> Tel: <?php echo $tel_sistema ?></span> 
	</div>



</body>
</html>