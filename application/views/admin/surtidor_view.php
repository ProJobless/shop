<?php $this->load->view('admin/common/header'); ?>
<div id="body">
	<div class="menu"><?php construyeMenu($rol); ?></div>
	<div align="center">
		<?php 
		$tmp = $this->phpsession->flashget('acierto');
		if(!empty($tmp)){?>
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert">×</a>
				<?php echo ($tmp); ?>
			</div>
		<?php
		}
		?>

		<?php 
		$tmp = validation_errors();
		if(!empty($tmp)){?>
			<div class="alert alert-error">
				<a href="#" class="close" data-dismiss="alert">×</a>
				<?php echo (validation_errors()); ?>
			</div>
		<?php
		}
		?>

		
		
		<?php echo form_open(current_url());?>

		<?php
		if($accion == 'alta'){
		?>
			<font size="3" face="Geneva, Arial, Helvetica, sans-serif" color="#000033">
				<strong>Alta de surtidores</strong>
			</font>
			<table class="table table-hover table-bordered" style="width:400px;">
				<tr>
					<td>Nombre Completo:</td>
					<td><input type="text" name="nombre" value="<?php echo set_value('nombre'); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Guardar" class="btn btn-primary" /></td>
				</tr>
			</table>
		<?php
		}elseif($accion =='editar'){?>

			<p>
				<a class="btn btn-small" href="<?php echo site_url('admin/surtidor/editar/');?>"><i class="icon-list"></i>Regresar a Lista</a>
			</p>
			<?php
			if(!empty($surtidor)){?>
				<font size="3" face="Geneva, Arial, Helvetica, sans-serif" color="#000033">
					<strong>Edición de surtidor</strong>
				</font>
				<input type="hidden" value="<?php echo $surtidor['idsurtidor'];?>" name="id" />
				<table class="table table-hover table-bordered" style="width:400px;">
					<tr>
						<td>Nombre:</td>
						<td><input type="text" name="nombre" value="<?php echo $surtidor['nombre']; ?>" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Guardar" class="btn btn-primary" /></td>
					</tr>
				</table>
			<?php
			}
			?>
			
		<?php	
		}elseif($accion == 'lista'){?>
			
			<div id="pull-right">
				<a href="<?php echo site_url('admin/surtidor/alta');?>" class="btn btn-small" ><i class="icon-plus"></i> Añadir un Surtidor </a>
			</div>
			<?php
			echo $this->pagination->create_links();
			?>
			<font size="3" face="Geneva, Arial, Helvetica, sans-serif" color="#000033">
				<strong>Lista de surtidores</strong>
			</font>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Nombre Completo</th>
						<th>Editar</th>
						<th>Eliminar</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach($surtidores as $surtidor){
					?>
					<tr>
						<td><?php echo $surtidor['nombre'];?></td>
						<td><a class="btn btn-small" href="<?php echo site_url('admin/surtidor/editar/'.$surtidor['idsurtidor']);?>"><i class="icon-pencil"></i></a></td>
						<td><a class="btn btn-small" href="<?php echo site_url('admin/surtidor/borrar/'.$surtidor['idsurtidor']);?>"><i class="icon-trash"></i></a></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<!--<pre>
				<?php print_r($productos);?>
			</pre>-->
		<?php
		} 
		?>

		<?php echo form_close();?>
	</div>
</div>

</body>
</html>