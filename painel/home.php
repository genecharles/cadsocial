<?php 
require_once("verificar.php");
require_once("../conexao.php");

$totalClientes = 0;
$totalFuncionarios = 0;
$tarefasPendentes = 0;
$tarefasPendentesEscritorio = 0;
$totalTarefasHoje = 0;
$totalTarefasConcluidasHoje = 0;
$saldoDia = 0;
$saldoCaixaDia = 0;
$saldoDiaF = 0;
$saldoCaixaDiaF = 0;
$classe_saldo_caixa_dia = 'fundo-verde';
$porcentagemTarefas = 0;
$contasReceberVencidas = 0;
$contasPagarVencidas = 0;
$contasReceberHoje = 0;
$contasPagarHoje = 0;
$contasReceberPendentes = 0;
$totalContasPagasHoje = 0;
$totalContasRecebidasHoje = 0;
$porcentagemReceber = 0;
$porcentagemPagar = 0;
$totalContasPgHoje = 0;
$totalContasRbHoje = 0;

$query = $pdo->query("SELECT * FROM clientes where ativo = 'Sim' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalClientes = @count($res);

$query = $pdo->query("SELECT * FROM funcionarios ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalFuncionarios = @count($res);

$query = $pdo->query("SELECT * FROM tarefas where status = 'Agendada' and usuario = '$id_usu' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$tarefasPendentes = @count($res);

$query = $pdo->query("SELECT * FROM tarefas where status = 'Agendada' and data = curDate() ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$tarefasPendentesEscritorio = @count($res);


$query = $pdo->query("SELECT * FROM tarefas where data = curDate() and usuario = '$id_usu'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalTarefasHoje = @count($res);

$query = $pdo->query("SELECT * FROM tarefas where data = curDate() and usuario = '$id_usu'and status = 'Concluída'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalTarefasConcluidasHoje = @count($res);

if($totalTarefasConcluidasHoje > 0 and $totalTarefasHoje > 0){
	$porcentagemTarefas = ($totalTarefasConcluidasHoje / $totalTarefasHoje) * 100;
}



$query = $pdo->query("SELECT * FROM pagar where data_venc < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasPagarVencidas = @count($res);

$query = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasReceberVencidas = @count($res);


$query = $pdo->query("SELECT * FROM pagar where data_venc = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasPagarHoje = @count($res);

$query = $pdo->query("SELECT * FROM receber where data_venc = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasReceberHoje = @count($res);


$query = $pdo->query("SELECT * FROM receber where pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contasReceberPendentes = @count($res);


$query = $pdo->query("SELECT * FROM receber where data_venc = curDate() and pago = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalContasRecebidasHoje = @count($res);

$query = $pdo->query("SELECT * FROM pagar where data_venc = curDate() and pago = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalContasPagasHoje = @count($res);


$query = $pdo->query("SELECT * FROM receber where data_venc = curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalContasRbHoje = @count($res);

$query = $pdo->query("SELECT * FROM pagar where data_venc = curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalContasPgHoje = @count($res);

if($totalContasRecebidasHoje > 0 and $totalContasRbHoje > 0){
	$porcentagemReceber = ($totalContasRecebidasHoje / $totalContasRbHoje) * 100;
}


if($totalContasPagasHoje > 0 and $totalContasPgHoje > 0){
	$porcentagemPagar = ($totalContasPagasHoje / $totalContasPgHoje) * 100;
}


//TOTALIZAR SALDO DO DIA
$query_t = $pdo->query("SELECT * from movimentacoes where data = curDate()");
$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);
if(@count($res_t)>0){
	for($it=0; $it < @count($res_t); $it++){
		foreach ($res_t[$it] as $key => $value){}			

		if($res_t[$it]['tipo'] == 'Entrada'){
			$saldoDia += $res_t[$it]['valor'];
		}else{
			$saldoDia -= $res_t[$it]['valor'];
		}

		if($res_t[$it]['lancamento'] == 'Caixa'){
			if($res_t[$it]['tipo'] == 'Entrada'){
				$saldoCaixaDia += $res_t[$it]['valor'];
			}else{
				$saldoCaixaDia -= $res_t[$it]['valor'];
			}
		}
	}	

	if($saldoDia < 0){
		$classe_saldo_dia = 'fundo-vermelho';
	}else{
		$classe_saldo_dia = 'fundo-verde-escuro';
	}


	if($saldoCaixaDia < 0){
		$classe_saldo_caixa_dia = 'fundo-vermelho';
	}else{
		$classe_saldo_caixa_dia = 'fundo-verde-claro';
	}

	$saldoDiaF = number_format($saldoDia, 2, ',', '.');
	$saldoCaixaDiaF = number_format($saldoCaixaDia, 2, ',', '.');
}



//alimentar o gráfico de linhas 
$valor_pagar_dia = '';
$valor_pagar = 0;

$valor_receber_dia = '';
$valor_receber = 0;
for($i=0; $i < 6; $i++){
	$data_nova = date('Y-m-d', strtotime("-$i days",strtotime($data_atual)));
	$data_formatada = implode('/', array_reverse(explode('-', $data_nova)));

	$query = $pdo->query("SELECT * FROM pagar where data_pgto = '$data_nova' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		for($i2=0; $i2 < $total_reg; $i2++){
		foreach ($res[$i2] as $key => $value){}
			$valor_pagar += $res[$i2]['valor'];
		}
	}else{
		$valor_pagar = 0;
	}


	$query = $pdo->query("SELECT * FROM receber where data_pgto = '$data_nova' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		for($i2=0; $i2 < $total_reg; $i2++){
		foreach ($res[$i2] as $key => $value){}
			$valor_receber += $res[$i2]['valor'];
		}
	}else{
		$valor_receber = 0;
	}

	$data_dias = @$data_dias .$data_formatada . '-';
	$valor_pagar_dia = $valor_pagar_dia. @$valor_pagar . '-';
	$valor_receber_dia = $valor_receber_dia. @$valor_receber . '-';
	
	
}

$total_entradas_grafico = '';
$total_saidas_grafico = '';
//alimentar o gráfico de barras
for($i=1; $i <= 12; $i++){
	
	if($i < 10){
		$data_mes_atual = $ano_atual.'-0'.$i.'-01';
		$data_mes_final = $ano_atual.'-0'.$i.'-31';
	}else{
		$data_mes_atual = $ano_atual.'-'.$i.'-01';
		$data_mes_final = $ano_atual.'-'.$i.'-31';
	}

	$total_entradas = 0;
	$total_saidas = 0;

	$query_t = $pdo->query("SELECT * from movimentacoes where data >= '$data_mes_atual' and data <= '$data_mes_final'");
	$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res_t)>0){
		for($it=0; $it < @count($res_t); $it++){
			foreach ($res_t[$it] as $key => $value){}			

			if($res_t[$it]['tipo'] == 'Entrada'){
				$total_entradas += $res_t[$it]['valor'];
			}else{
				$total_saidas += $res_t[$it]['valor'];
			}

		}
	}

	$total_entradas_grafico = $total_entradas_grafico. @$total_entradas . '-';
	$total_saidas_grafico = $total_saidas_grafico. @$total_saidas . '-';

}

 ?>

<input type="hidden" value="<?php echo $data_dias ?>" id="valor_coluna">
<input type="hidden" value="<?php echo $valor_pagar_dia ?>" id="valor_pagar_dia">
<input type="hidden" value="<?php echo $valor_receber_dia ?>" id="valor_receber_dia">

<input type="hidden" value="<?php echo $total_entradas_grafico ?>" id="total_entradas_grafico">
<input type="hidden" value="<?php echo $total_saidas_grafico ?>" id="total_saidas_grafico">

<div class="main-page">
	<div class="col_3">

		<a href="index.php?pagina=agenda">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-clock-o dollar1 icon-rounded"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><big><?php echo $tarefasPendentes ?></big></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Minhas Tarefas Pendentes</small></span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=agenda">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-laptop user1 icon-rounded"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><big><?php echo $tarefasPendentesEscritorio ?></big></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Tarefas Escritório Hoje</small></span>
				</div>
			</div>
		</div>
		</a>


		<a href="index.php?pagina=movimentacoes" class="<?php echo $esc_rh ?>">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-money <?php echo $classe_saldo_dia ?> icon-rounded"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><?php echo $saldoDiaF ?></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>R$ Saldo do Dia</small></span>
				</div>
			</div>
		</div>
		</a>

	
		
		<a href="index.php?pagina=movimentacoes" class="<?php echo $esc_rh ?>">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-money <?php echo $classe_saldo_caixa_dia ?> icon-rounded"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><?php echo $saldoCaixaDiaF ?></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>R$ Saldo do Caixa no Dia</small></span>
				</div>
			</div>
		</div>
		</a>


		<a href="index.php?pagina=clientes">
		<div class="col-md-3 widget <?php echo $classe_widget ?>">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-users user2 icon-rounded"></i>
        		</div>
        		<div class="col-md-8">
        			<h5 class="valor_card"><strong><?php echo $totalClientes ?></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Total Clientes Escritório</small></span>
				</div>
			</div>			
		</div>
		</a>


		
		
		<a href="index.php?pagina=receber" class="<?php echo $esc_rh ?>">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-money <?php echo $classe_saldo_dia ?> icon-verde"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><?php echo $contasReceberHoje ?></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Contas à Receber Hoje</small></span>
				</div>
			</div>
		</div>
		</a>

	
		
		<a href="index.php?pagina=pagar" class="<?php echo $esc_rh ?>">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-money <?php echo $classe_saldo_caixa_dia ?> icon-vermelho"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><?php echo $contasPagarHoje ?></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Contas à Pagar Hoje</small></span>
				</div>
			</div>
		</div>
		</a>



		<a href="index.php?pagina=receber" class="<?php echo $esc_rh ?>">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-money dollar1 icon-rounded"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><big><?php echo $contasReceberVencidas ?></big></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Contar à Receber Vencidas</small></span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=pagar" class="<?php echo $esc_rh ?>">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-money user1 icon-rounded"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><big><?php echo $contasPagarVencidas ?></big></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Contas à Pagar Vencidas</small></span>
				</div>
			</div>
		</div>
		</a>


		<a href="index.php?pagina=funcionarios" class="<?php echo $esc_tes ?>">
		<div class="col-md-3 widget">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-users user2 icon-azul"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><big><?php echo $totalFuncionarios ?></big></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Total Funcionários Escritório</small></span>
				</div>
			</div>			
		</div>
		</a>


		<a href="index.php?pagina=receber" class="<?php echo $esc_gerente ?> <?php echo $esc_admin ?> <?php echo $esc_rh ?> <?php echo $esc_sec ?> <?php echo $esc_recep ?>">
		<div class="col-md-3 widget">
			<div class="r3_counter_box">
				<div class="row">
        		<div class="col-md-4">
        			<i class="pull-left fa fa-money user2 icon-verde"></i>
        		</div>
        		<div class="col-md-8">
        			<h5><strong><big><?php echo $contasReceberPendentes ?></big></strong></h5>
        		</div>
        		</div>
        		
        		<hr style="margin-top:-2px; margin-bottom: 3px">   
				
				<div class="stats" align="center">					
					<span><small>Contas à Receber Pedentes</small></span>
				</div>
			</div>			
		</div>
		</a>


		<div class="clearfix"> </div>
	</div>



	<div class="row-one widgettable">
		<div class="col-md-8 content-top-2 card">
			<div class="agileinfo-cdr">
				<div class="card-header">
					<h3>Pagar e Receber</h3>
				</div>

				<div id="Linegraph" style="width: 98%; height: 350px">
				</div>

			</div>
		</div>
		<div class="col-md-4 stat">

			<a href="index.php?pagina=agenda">
				<div class="content-top-1">
					<div class="col-md-6 top-content">
						<h5>Tarefas Concluídas</h5>
						<label><?php echo $totalTarefasConcluidasHoje ?> de <?php echo $totalTarefasHoje ?></label>
					</div>
					<div class="col-md-6 top-content1">	   
						<div id="demo-pie-1" class="pie-title-center" data-percent="<?php echo $porcentagemTarefas ?>"> <span class="pie-value"></span> </div>
					</div>
					<div class="clearfix"> </div>
				</div>
			</a>

			<a href="index.php?pagina=receber">
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Contas à Receber Hoje</h5>
					<label><?php echo $totalContasRecebidasHoje ?> de <?php echo $totalContasRbHoje ?></label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-2" class="pie-title-center" data-percent="<?php echo $porcentagemReceber ?>"> <span class="pie-value"></span> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</a>

			<a href="index.php?pagina=pagar">
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Contas à Pagar Hoje</h5>
					<label><?php echo $totalContasPagasHoje ?> de <?php echo $totalContasPgHoje ?></label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-3" class="pie-title-center" data-percent="<?php echo $porcentagemPagar ?>"> <span class="pie-value"></span> </div>
				</div>
				 <div class="clearfix"> </div>
				</div>
			</a>
		</div>
		
		<div class="clearfix"> </div>
	</div>

	<div class="row-one widgettable">
		<div class="col-md-8 content-top-2 card" style="padding:20px">
			<div class="card-header">
				<h3>Entradas e Saídas</h3>
			</div>			
				<canvas id="canvas" style="width: 100%; height:450px;"></canvas>
				
		</div>	



		<div class="col-md-4 stat">
			<div class="card">
				<div class="card-body card-padding">
					<div class="">
						<header class="widget-header">
							<h4 class="widget-title">Últimos Logs</h4>
						</header>
						<hr class="widget-separator">
						<div class="widget-body">
							<div class="streamline">

								<?php 
								$query = $pdo->query("SELECT * FROM logs ORDER BY id desc limit 6");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$total_reg = @count($res);
								if($total_reg > 0){

									for($i=0; $i < $total_reg; $i++){
										foreach ($res[$i] as $key => $value){}

										$hora = $res[$i]['hora'];
										$usuario = $res[$i]['usuario'];

										$agora = date('H:i:s');


										$tempo_minutos = gmdate('i', strtotime( $agora ) - strtotime( $hora ) );
										$tempo_hora = gmdate('H', strtotime( $agora ) - strtotime( $hora ) );


										if($tempo_hora < 10){
											$tempo_horaF = str_replace('0', '', $tempo_hora);
										}else{
											$tempo_horaF = $tempo_hora;
										}

										if($tempo_hora == "00"){
											$tempo = $tempo_minutos . ' Minutos ';
										}else if ($tempo_hora == "01"){
											$tempo = $tempo_horaF . ' Hora ';
										}else{
											$tempo = $tempo_horaF . ' Horas ';
										}




										$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
										$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
										if(@count($res2) > 0){
											$nome_usu = $res2[0]['nome'];
										}else{
											$nome_usu = 'Sem Usuário';
										}

										if($i == 0){
											$classe="sl-primary";
										}else if($i == 1){
											$classe="sl-danger";
										}else if($i == 2){
											$classe="sl-success";
										}else if($i == 3){
											$classe="sl-content";
										}else if($i == 4){
											$classe="sl-primary";
										}else{
											$classe="sl-warning";
										}
										?>


										<div class="sl-item <?php echo $classe ?>">
											<div class="sl-content">
												<small class="text-muted"><?php echo $tempo ?> Atrás</small>
												<p style="font-size: 13px"><?php echo $nome_usu ?> - <?php echo $res[$i]['tabela'] ?> / <?php echo $res[$i]['acao'] ?></p>
											</div>
										</div>

									<?php } } ?>


								</div>
							</div>

						</div>
					</div>
				</div>
			</div>	

		<div class="clearfix"> </div>
	</div>

	
	

	</div>



	<!-- GRAFICO DE LINHA -->
	<script type="text/javascript">
		$(document).ready(function() {

		var valor_col_graf_linha = $('#valor_coluna').val()
    	var colunas_graf_linha = valor_col_graf_linha.split("-");

    	var valor_linha_graf_linha_pagar = $('#valor_pagar_dia').val()
    	var linha_graf_linha_pagar = valor_linha_graf_linha_pagar.split("-");

    	var valor_linha_graf_linha_receber = $('#valor_receber_dia').val()
    	var linha_graf_linha_receber = valor_linha_graf_linha_receber.split("-");

    	
    	var maior_valor_linha_pagar = Math.max(...linha_graf_linha_pagar);
    	var maior_valor_linha_receber = Math.max(...linha_graf_linha_receber);
    	var maior_valor = Math.max(maior_valor_linha_pagar, maior_valor_linha_receber);
    	maior_valor = parseFloat(maior_valor) + 100;
    	
    	var menor_valor_linha_pagar = Math.min(...linha_graf_linha_pagar);
    	var menor_valor_linha_receber = Math.min(...linha_graf_linha_receber);
    	var menor_valor = Math.max(menor_valor_linha_pagar, menor_valor_linha_receber);

		var dadosReceber = {
    		linecolor: "green",
    		title: "Conta à Receber",
    		values: [
    		{ X: colunas_graf_linha[5], Y: linha_graf_linha_receber[5] },
    		{ X: colunas_graf_linha[4], Y: linha_graf_linha_receber[4] },
    		{ X: colunas_graf_linha[3], Y: linha_graf_linha_receber[3] },
    		{ X: colunas_graf_linha[2], Y: linha_graf_linha_receber[2] },
    		{ X: colunas_graf_linha[1], Y: linha_graf_linha_receber[1] },
    		{ X: colunas_graf_linha[0], Y: linha_graf_linha_receber[0] },
    		
    		]
    	};
    	var dadosPagar = {
    		linecolor: "#da2a2a",
    		title: "Conta à Pagar",
    		values: [
    		{ X: colunas_graf_linha[5], Y: linha_graf_linha_pagar[5] },
    		{ X: colunas_graf_linha[4], Y: linha_graf_linha_pagar[4] },
    		{ X: colunas_graf_linha[3], Y: linha_graf_linha_pagar[3] },
    		{ X: colunas_graf_linha[2], Y: linha_graf_linha_pagar[2] },
    		{ X: colunas_graf_linha[1], Y: linha_graf_linha_pagar[1] },
    		{ X: colunas_graf_linha[0], Y: linha_graf_linha_pagar[0] },
    		
    		]
    	};


    	var dataRangeLinha = {
    		linecolor: "transparent",
    		title: "",
    		values: [
    		{ X: colunas_graf_linha[5], Y: menor_valor },
    		{ X: colunas_graf_linha[4], Y: menor_valor },
    		{ X: colunas_graf_linha[3], Y: menor_valor },
    		{ X: colunas_graf_linha[2], Y: menor_valor },
    		{ X: colunas_graf_linha[1], Y: menor_valor },
    		{ X: colunas_graf_linha[0], Y: maior_valor },
    		
    		]
    	};

		
		$("#Linegraph").SimpleChart({
    			ChartType: "Line",
    			toolwidth: "50",
    			toolheight: "25",
    			axiscolor: "#E6E6E6",
    			textcolor: "#6E6E6E",
    			showlegends: true,
    			data: [dadosPagar, dadosReceber, dataRangeLinha],
    			legendsize: "30",
    			legendposition: 'bottom',
    			xaxislabel: 'Data',
    			title: 'Demonstrativo de Contas',
    			yaxislabel: 'Total de Contas R$',
    			responsive: true,
    		});

	})
	
	</script>


	<!-- GRAFICO DE BARRAS -->
	<script type="text/javascript">
		$(document).ready(function() {

			var valor_graf_barra_saidas = $('#total_saidas_grafico').val()
    		var total_saidas = valor_graf_barra_saidas.split("-");

    		var valor_graf_barra_entradas = $('#total_entradas_grafico').val()
    		var total_entradas = valor_graf_barra_entradas.split("-");


				var color = Chart.helpers.color;
				var barChartData = {
					labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
					datasets: [{
						label: 'Entradas',
						backgroundColor: color('green').alpha(0.5).rgbString(),
						borderColor: 'green',
						borderWidth: 1,
						data: [
						total_entradas[0],
						total_entradas[1],
						total_entradas[2],
						total_entradas[3],
						total_entradas[4],
						total_entradas[5],
						total_entradas[6],
						total_entradas[7],
						total_entradas[8],
						total_entradas[9],
						total_entradas[10],
						total_entradas[11],
						total_entradas[12],
						]
					}, {
						label: 'Saídas',
						backgroundColor: color('red').alpha(0.5).rgbString(),
						borderColor: 'red',
						borderWidth: 1,
						data: [
						total_saidas[0],
						total_saidas[1],
						total_saidas[2],
						total_saidas[3],
						total_saidas[4],
						total_saidas[5],
						total_saidas[6],
						total_saidas[7],
						total_saidas[8],
						total_saidas[9],
						total_saidas[10],
						total_saidas[11],
						total_saidas[12],
						]
					}]

				};

			var ctx = document.getElementById("canvas").getContext("2d");
					window.myBar = new Chart(ctx, {
						type: 'bar',
						data: barChartData,
						options: {
							responsive: true,
							legend: {
								position: 'top',
							},
							title: {
								display: true,
								text: 'Comparativo de Movimentações'
							}
						}
					});

	})
	
	</script>