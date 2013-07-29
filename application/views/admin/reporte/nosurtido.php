<?php $this->load->view('admin/common/header');?>
	<div class="menu"><?php construyeMenu($rol); ?></div>
	<div id="body">

		<?php echo form_open(current_url());?>
		Fecha de inicio:<input type="text" id="inicio" name="fecha_inicio" />
		Fecha de final:<input type="text" id="final" name="fecha_final" />
		<input type="submit" value="consultar" />
		<?php echo form_close();?>

		<p style="color: red;"><?php echo validation_errors(); ?></p>

		<?php if($mostrar == TRUE){?>
		<h2>Pedidos de <?php echo $_POST['fecha_inicio'];?> a <?php echo $_POST['fecha_final'];?></h2>
		<table class="consulta">
			<tr>
				<th>Fecha Pedido</th>
				<th>Número de Pedido</th>
				<th>Importe Pedido</th>
				<th>Importe Surtido</th>
				<th>Importe No Surtido</th>
				<th>% No surtido</th>
				<th>Comentario</th>
			</tr>
		<?php
		/*echo '<pre>';
		print_r($consulta->result_array());*/
			
			foreach($consulta->result() as $resultado){
				
				foreach($pedido[$resultado->Pedido_idPedido]['importe_pedido']->result() as $importe){
					$importe_total = $importe->total;
				}
				if( is_numeric($resultado->numero2) ){
					$importe_surtido = $resultado->numero2;
				}else{
					$importe_surtido = 123456789.00;
				}

				$nosurtido = $importe_total - $importe_surtido;

				$porcentaje = ($nosurtido*100)/$importe_total; 
				
				//				echo strtotime($resultado->fecha_aut) - strtotime($fecha_sig);
				?>
			<tr>
				<td><?php echo $resultado->fecha_pedido;?></td>
				<td><a href="<?php echo site_url('pedido/recibido/ver/'.$resultado->Pedido_idPedido);?>" target="_blank"><?php echo $resultado->Pedido_idPedido;?></a></td>
				<td><?php echo '$'.number_format($importe_total,2);?></td>
				<td><?php echo '$'.number_format($importe_surtido,2);?></td>
				<td><?php echo '$'.number_format($nosurtido,2);?></td>
				<td><?php echo number_format($porcentaje).'%';?></td>
				<td><?php echo $resultado->observaciones;?></td>
			</tr>

			<?php
			
			}?>
		</table>
			<?php
			
			/*echo '<pre>';
			print_r($consulta->result());*/
			
			?>
			
		<?php } ?>
	</div>
<?php $this->load->view('admin/common/footer');?>