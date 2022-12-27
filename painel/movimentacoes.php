<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'movimentacoes';

$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_hoje)));

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";

if(@$_SESSION['nivel_usuario'] != "Administrador" and @$_SESSION['nivel_usuario'] != "Gerente" and @$_SESSION['nivel_usuario'] != "Tesoureiro"){
	echo "<script>window.location='../index.php'</script>";
	exit();
}


?>

<input type="hidden" id="nome-busca">
<input type="hidden" id="tipo-busca">

<div style="background-color: white; padding:5px">
<small>
	<ul class="nav nav-tabs my-2" id="myTab" role="tablist">
		<li class="nav-item active" role="presentation">
			<a href="#" onclick="valorLanc('Caixa')" class="nav-link active" id="caixa-tab" data-toggle="tab" data-target="#caixa" type="button" role="tab" aria-controls="home" aria-selected="true">Caixa</a>
		</li>
		<li onclick="valorLanc('Cartão de Débito')" class="nav-item" role="presentation">
			<a href="#" class="nav-link" id="debito-tab" data-toggle="tab" data-target="#caixa" type="button" role="tab" aria-controls="profile" aria-selected="false">Cartão de Débito</a>
		</li>
		<li onclick="valorLanc('Cartão de Crédito')" class="nav-item" role="presentation">
			<a href="#" class="nav-link" id="credito-tab" data-toggle="tab" data-target="#caixa" type="button" role="tab" aria-controls="profile" aria-selected="false">Cartão de Crédito</a>
		</li>

		<?php 

		$query = $pdo->query("SELECT * from contas_banco order by nome asc");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res) > 0){
			for($i=0; $i < @count($res); $i++){
		foreach ($res[$i] as $key => $value){} ?>

			<li onclick="valorLanc('<?php echo $res[$i]['nome'] ?>')" class="nav-item" role="presentation">
			<a href="#" class="nav-link" id="credito-tab" data-toggle="tab" data-target="#caixa" type="button" role="tab" aria-controls="profile" aria-selected="false"><?php echo $res[$i]['nome'] ?></a>
		</li>

		<?php	}
		}

		 ?>

	</ul>
</small>
</div>

<div class="row" style="background-color: white; padding:20px">
	<div class="col-md-5">			

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Inicial" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:20px">
			<input type="date" class="form-control " name="data-inicial"  id="data-inicial-caixa" value="<?php echo date('Y-m-d') ?>" required>
		</div>

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Final" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:30px">
			<input type="date" class="form-control " name="data-final"  id="data-final-caixa" value="<?php echo date('Y-m-d') ?>" required>
		</div>
	</div>

		
<div class="col-md-2">	
		<div style="margin-top:5px;"> 
		<small >
			<a title="Contas à Pagar Vencidas" class="text-muted" href="#" onclick="valorData('<?php echo $data_ontem ?>', '<?php echo $data_ontem ?>')"><span>Ontem</span></a> / 
			<a title="Contas à Pagar Hoje" class="text-muted" href="#" onclick="valorData('<?php echo $data_hoje ?>', '<?php echo $data_hoje ?>')"><span>Hoje</span></a> / 
			<a title="Contas à Pagar Amanhã" class="text-muted" href="#" onclick="valorData('<?php echo $data_mes ?>', '<?php echo $data_hoje ?>')"><span>Mês</span></a>
		</small>
		</div>
	</div>

	<div class="col-md-3">	

		<div style="margin-top:5px; margin-left: 15px"> 
		<small>
					<a title="Movimentações de Entradas" class="verde" href="#" onclick="valorTipo('Entrada')"><span>Entradas</span></a> / 
					<a title="Movimentações de Saídas" class="text-danger" href="#" onclick="valorTipo('Saída')"><span>Saídas</span></a> 
					

			</small>
			</div>

		
	</div>

	<div align="right" class="col-md-2">
		<small><i class="fa fa-usd" id="icone_total"></i> <span class="text-dark">Total: <span class="" id="total_itens"></span></span></small>
	</div>
</div>


<div class="bs-example widget-shadow" style="padding:15px; margin-top:-5px" id="listar">
	
</div>



	<script type="text/javascript">var pag = "<?=$pag?>"</script>
	<script src="js/ajax.js"></script>

	<script type="text/javascript">
		
		$(document).ready( function () {
		$('#nome-busca').val('Caixa');	
		listar(); 

		});


		$('#data-inicial-caixa').change(function(){
			$('#tipo-busca').val('');
			listar();
		});

		$('#data-final-caixa').change(function(){						
			$('#tipo-busca').val('');
			listar();
		});	


function valorTipo(tipo){
	$('#tipo-busca').val(tipo);
	listar();
}

function valorLanc(lanc){
	$('#nome-busca').val(lanc);
	$('#tipo-busca').val('');
	listar();
}

function valorData(dataInicio, dataFinal){
	 $('#data-inicial-caixa').val(dataInicio);
	 $('#data-final-caixa').val(dataFinal);
	$('#tipo-busca').val('');
	listar();
}	

function listar(){	
	
	var tipo = $('#tipo-busca').val();
	var lancamento = $('#nome-busca').val();
	var dataInicial = $('#data-inicial-caixa').val();
	var dataFinal = $('#data-final-caixa').val();	

    $.ajax({

        url: pag + "/listar.php",
        method: 'POST',
        data: {tipo, lancamento, dataInicial, dataFinal},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
        }
    });
}






	</script>


