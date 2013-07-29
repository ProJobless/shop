<?php $this->load->view('admin/common/header');?>
	<div class="menu"><?php construyeMenu($rol); ?></div>
	<div id="body">
		
		<?php $ingles = TRUE; ?>
		<?php construyeMenuAltas($seccion,$rol);?>
		<?php construyeMenuConsultas($seccion,$rol);?>
		<?php $insert_message = $this->phpsession->flashget('insert_message');
			if(!empty($insert_message)){
			echo "<p>";
			echo $insert_message;
			echo "</p>";
			}
			?>
		<?php $update_message = $this->phpsession->flashget('update_message');
			if(!empty($update_message)){
			echo "<p>";
			echo $update_message;
			echo "</p>";
			}
			?>
		<?php if($this->phpsession->flashget('error_upload')){
				$errores = $this->phpsession->flashget('error_upload');
				foreach ($errores as $error){
					
					echo "<p><strong>";				
					echo $error;
					echo "</strong></p>";
					
				}
			}
			?>
		<?php pedidoVista($consulta,$consultaTres); 
		/*echo '<pre>';
		print_r($consultaTres->result_array());*/?>
		<?php 
		foreach($consultaDos->result() as $pedido){
			pedidoFormulario($pedido->Estado_idEstado,$pedido->idPedido,$pedido->nombre,$rol,$surtidores); 
		}
		?>
		<!--center><a href="<?php echo $_SERVER['HTTP_REFERER'];?>" >Regresar </a></center-->
		<p><?php echo validation_errors(); ?></p>
	</div>
<?php $this->load->view('admin/common/footer');?>