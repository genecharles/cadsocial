<?php 
require_once("../../conexao.php");
$pagina = 'movimentacoes';
$data_atual = date('Y-m-d');
$total_valor = 0;

$dataInicial = @$_POST['dataInicial'];
$dataFinal = @$_POST['dataFinal'];
$tipo = '%'.@$_POST['tipo'].'%';
$lancamento = @$_POST['lancamento'];

if($lancamento == ""){
	$lancamento = 'Caixa';
}

$total_saldo_geral = 0;
$total_saldo_geralF = 0;
$classe_saldo_geral = '';
//TRAZER O SALDO GERAL
$query_t = $pdo->query("SELECT * from $pagina where lancamento = '$lancamento' order by id desc");
$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);
if(@count($res_t)>0){
	for($it=0; $it < @count($res_t); $it++){
		foreach ($res_t[$it] as $key => $value){} 

			$data_primeiro_reg = $res_t[$it]['data'];	

		if($res_t[$it]['tipo'] == 'Entrada'){
			$total_saldo_geral += $res_t[$it]['valor'];
		}else{
			$total_saldo_geral -= $res_t[$it]['valor'];
		}
	}

	if($total_saldo_geral < 0){
		$classe_saldo_geral = 'text-danger';
	}else{
		$classe_saldo_geral = 'verde';
	}

	$total_saldo_geralF = number_format($total_saldo_geral, 2, ',', '.');
}

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * from $pagina where (data >= '$dataInicial' and data <= '$dataFinal') and lancamento = '$lancamento' and tipo LIKE '$tipo' order by data asc, id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				<th>Data</th>
				<th class="esc">Movimento</th> 
				<th class="esc">Lançamento</th> 
				<th class="esc">Usuário</th>
				<th>Valor</th>
				<th>Saldo</th>				
				
			</tr> 
		</thead> 
		<tbody> 
HTML;

$total_saldo = 0;
$total_saldoF = 0;

for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$data = $res[$i]['data'];
$movimento = $res[$i]['movimento'];
$valor = $res[$i]['valor'];
$lanc = $res[$i]['lancamento'];
$usuario = $res[$i]['usuario'];
$tip = $res[$i]['tipo'];

$dataF = implode('/', array_reverse(explode('-', $data)));
$valorF = number_format($valor, 2, ',', '.');


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu = $res2[0]['nome'];
}else{
	$nome_usu = 'Sem Usuário';
}



		$total_saldo_periodo = 0;
		$total_saldo_periodoF = 0;
		$contador = $i + 1;

		//TRAZER O SALDO PERIODO
		$query_t = $pdo->query("SELECT * from $pagina where lancamento = '$lancamento' and data >= '$data_primeiro_reg' and data <= '$data' order by data asc, id asc");
		$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res_t)>0){
			for($it=0; $it < @count($res_t) and $id != $res_t[$it]['id']; $it++){
				foreach ($res_t[$it] as $key => $value){} 

					if($res_t[$it]['tipo'] == 'Entrada'){
						$total_saldo_periodo += $res_t[$it]['valor'];
					}else{
						$total_saldo_periodo -= $res_t[$it]['valor'];
					}
				}
			}


			if($tip == 'Entrada'){
				$classe = 'verde';
				$total_saldo += $valor;
				$total_saldo_periodo = $total_saldo_periodo + $valor;
				$classe_linha = '';

			}else{
				$classe = 'text-danger';
				$classe_linha = 'text-danger';
				$total_saldo -= $valor;
				$total_saldo_periodo = $total_saldo_periodo - $valor;
			}

			if($total_saldo < 0){
				$classe_saldo = 'text-danger';
			}else{
				$classe_saldo = 'verde';
			}

			if($total_saldo_periodo < 0){
				$classe_saldo_periodo = 'text-danger';
			}else{
				$classe_saldo_periodo = 'verde';
			}

			$total_saldoF = number_format($total_saldo, 2, ',', '.');
			$total_saldo_periodoF = number_format($total_saldo_periodo, 2, ',', '.');



echo <<<HTML
			<tr class="{$classe_linha}"> 
				<td >{$dataF}</td>	
				<td class="esc">{$movimento}</td>
				<td class="esc">{$lanc}</td>
				<td class="esc">{$nome_usu}</td>
				<td class="{$classe}">R$ {$valor}</td>		
				<td class="{$classe_saldo_periodo}">R$ {$total_saldo_periodoF}</td>
				
			</tr> 
HTML;
}
echo <<<HTML
		</tbody> 
	</table>

	<div align="right" style="margin-top:15px; background:white; padding-top:10px">
		Saldo do Período: <span class="{$classe_saldo}">R$ {$total_saldoF}</span><br>
		</div>
</small>
HTML;
}else{
	echo 'Não possui nenhum registro cadastrado!';
}

?>


<script type="text/javascript">


	$(document).ready( function () {
	    $('#tabela').DataTable({
	    	"ordering": false,
	    	"stateSave": true,
	    });

	    $('#tabela_filter label input').focus();
	    
	    	$('#total_itens').removeClass();
			$('#icone_total').removeClass();


			var classe_saldo_geral = '<?=$classe_saldo_geral?>';

			$('#total_itens').addClass(classe_saldo_geral);
			$('#icone_total').addClass('fa fa-usd');
			$('#icone_total').addClass(classe_saldo_geral);
			$('#total_itens').text('R$ <?=$total_saldo_geralF?>');
	} );

	

</script>



