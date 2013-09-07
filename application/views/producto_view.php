<?php 
$data['lateral_izquierdo'] = 1;
$this->load->view('common/header',$data); ?>
<div class='pull-left' style='width:50%;'>
    <div class="descripcion">
        <h3><?php echo $producto['nombre'];?></h3>
        <div id="cuadro_generico">
            <p><strong>Información de los principales ingredientes:</strong></p>
            <p>
                <?php echo $producto['uso'];?>
            </p>
        </div>
        <br>
        <div id="cuadro_generico">
            <p><strong>Opinión de Expertos:</strong></p>
            <p>
                <?php echo $producto['experto'];?>
            </p>
        </div>
        <br>
        <div id="cuadro_generico">
            <p><strong>Comentarios al Producto:</strong></p>
            <p>
                <?php echo $producto['testimonio'];?>
            </p>
        </div>
        <br />
        <table class='table table-bordered'>
            <tr>
        <?php 
        $cont = 0;
        foreach ($presentaciones as $p) { ?>
                <td style='width:45%;'>
                
                    <h5 class="green_text font_130">
                        <?php echo $p['estado_fisico']; ?><br />
                        <?php echo $p['contenido_neto']; ?>
                    </h5>
                    <center>
                        <img width="176" height="176" alt="<?php echo $p['clave']; ?>" src="<?php echo base_url('productos_img/' . $p['imagen']); ?>">
                    </center>
                    <div class="cuadro_precio">
                            <strong style="margin-left:60px; margin-top:15px;">Precio:</strong> 
                            <span class="font_precio"><?php echo $p['precio_publico'] * (125/100);?> MXP</span><br>
                            <br>
                            <strong>No causa IVA</strong><br>
                            <strong>Código: <?php echo $p['clave'];?></strong><br>
                            <strong class="font_naranja">Ingredientes: </strong><br />
                            <?php echo $p['ingredientes'];?>
                            <br />
                            <a target="_blank" href="#N"><img border="0" src="<?php echo base_url('/img/ver_video.gif');?>"></a><br>
                    </div>
                    <a href="#N" class='btn btn-link cart-add' data-id='<?php echo $p['idPresentacion'];?>' data-qty='1' data-cartsize='pequenio' >Agregar a mi Carrito</a>
                
                </td>

        <?php
            $cont++;
            if($cont == 2){
                $cont = 0;
                echo '</tr>';
                echo '<tr>';
            }
        }


        if($cont == 1){ echo '<td>&nbsp;</td>'; }
        ?>

            </tr>
        </table>
    
    </div>

</div>
<?php 
$data['lateral_derecho'] = 1;
$this->load->view('common/footer',$data); ?>
