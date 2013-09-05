<?php $this->load->view('common/header');?>
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
            
            <h2>Subir Lista de nuevos precios </h2>
            <?php echo form_open_multipart(site_url('producto/subir_lista'));?>
		<input class="btn input-small" type="file" name="archivo" />
                <input class="btn btn-success" type="submit" value="Subir" />
            <?php echo form_close();?>
                
            <?php 
            $tmp = $this->phpsession->flashget('detalles');
            if(!empty($tmp)){ 
                if($tmp['procesados'] > 0){?>
                
                <p>Se han procesado <em><?php echo $tmp['procesados'];?></em> productos de los cuales <em><?php echo $tmp['actualizados'];?></em> se han actualizado con éxito y <em><?php echo $tmp['rechazados'];?></em> se han rechazado. </p>
                <p>La siguiente lista contiene detalles sobre los productos rechazados.</p>
                <table class="table table-bordered table-hover" style="width:50%;">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Detalle de Rechazo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tmp['rejected'] as $r){?>
                        <tr>
                            <td><?php echo $r['clave'];?></td>
                            <td><?php echo $r['error_detalle'];?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!--
                <pre>
                    <?php print_r($tmp);?>
                </pre>
                -->
                
                
            <?php
                }else{
                    echo '<p class="text-error">'.$tmp['mensaje'].'</p>';
                }
            }
            ?>
	</div>
<?php $this->load->view('common/footer');?>
