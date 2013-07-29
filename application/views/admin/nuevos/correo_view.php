<?php $this->load->view('admin/common/header'); ?>



<div class="menu"><?php construyeMenu($rol); ?></div>
	<div id="body">
            <?php 
            $tmp = $this->phpsession->flashget('acierto');
            if(!empty($tmp)){ ?>
            <div class='alert alert-success'>
                <?php echo $tmp;?>
            </div>
            <?php
            }
            ?>
            
            <?php 
            $tmp = $this->phpsession->flashget('error');
            if(!empty($tmp)){ ?>
            <div class='alert alert-error'>
                <?php echo $tmp;?>
            </div>
            <?php
            }
            ?>
            
            <h2>Lista de Correos </h2>
            <?php echo form_open(current_url()); ?>    
                    <table class='table table-bordered table-hover'>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Sección</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="nombre"/></td>
                            <td><input type="text" name="direccion"/></td>
                            <td>
                                <select name='seccion'>
                                    <!--option value='direccion'>direccion</option-->
                                    <option value='ventas'>Ventas</option>
                                    <option value='quejas'>Quejas</option>
                                    <option value='asesorias'>Asesorias</option>
                                    <option value='mayoristas'>Mayoristas</option>
                                    <option value='franquicias'>Franquicias</option>
                                </select>
                            </td>
                            <td><input type="submit" value='agregar' /></td>
                        </tr>
			
			<?php
			if(!empty($correos)){ //print_r($correos);
                            foreach($correos as $correo){?>
                                <tr>
                                    <td><?php echo $correo['nombre'];?></td>
                                    <td><?php echo $correo['direccion'];?></td>
                                    <td><?php echo $correo['seccion'];?></td>
                                    <td><a href="<?php echo site_url('admin/correo/eliminar/'.$correo['idcorreo']);?>">Eliminar</a></td>
                                </tr>
			<?php
                            }
			}
			?>
                        
                   </table>
                   <?php echo form_close(); ?>
	</div>
<?php $this->load->view('admin/common/footer');?>