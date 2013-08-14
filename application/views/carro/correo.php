<?php
$mayor = $this->phpsession->get('datos', $usuario);
$carro = $this->phpsession->get('contenidos', 'carro');
$total = $this->carro->total_articulos();
//$subtotal = $this->carro->get_subtotal();
$iva = 0;
$precio = 0;
$subtotal = 0;
$largo=(!empty($mayor['promocion']))?10:8;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Shop | Some</title>
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <style>
            td {
                vertical-align: top;
            }
        </style>    




    </head>
    <body>
        <div class='container' style='margin-top:15px; width:85%; min-width: 1100px'>

            <div id='imagenes' style='height:200px;'>
                    <img src='<?php echo base_url('img/banner-correo.jpg');?>' alt='Pedido Enviado' />
            </div>
            <table style='width:90%;'>
                <tbody>
                    <tr bgcolor="#FCDC2F">
                        <td colspan="<?php echo $largo;?>">
                            Productos(<span id="cart-articulos"><?php echo $total; ?></span> Artículo<?php echo ($total != 1) ? 's' : ''; ?>)
                            <span id='cart-load' class='pull-right'></span>
                        </td>
                    </tr>
                    <tr>
                        <?php 
                        if(!empty($mayor['promocion'])){?>
                        <td>Total de Piezas</td>
                        <td>Cantidad con Costo</td>
                        <td>Cantidad sin Costo</td>
                        <?php    
                        }else{?>
                        <td>Cantidad</td>
                        <?php
                        }
                        ?>
                        
                        <td>Código</td>
                        <td>Nombre Producto</td>
                        <td>Estado Físico</td>
                        <td>Contenido Neto</td>
                        <td>IVA</td>
                        <td>Precio Catálogo</td>
                        <td>Importe</td>
                    </tr>
                    <?php
                    if (!empty($carro)) {
                        foreach ($carro as $k => $c) {
                            $precio = $c['price'] * ($mayor['descuento'] / 100);
                            $sin_costo = ($c['qty'] > 1) ? floor($c['qty']/2) : 0;
                            //print_r($c);
                            ?>
                            <tr>
                                
                                <?php 
                                if(!empty($mayor['promocion'])){?>
                                
                                <td><?php echo $c['qty'] + $sin_costo;?></td>
                                      <td>
                                           <?php echo $c['qty'];?>
                                       </td>
                                <td><?php echo $sin_costo;?></td>
                                <?php    
                                }else{?>
                                <td>
                                    <?php echo $c['qty']; ?>
                                </td>
                                <?php
                                }
                                ?>
                                
                                <td><?php echo $c['id']; ?></td>
                                <td><?php echo $c['name']; ?></td>
                                <td><?php echo $c['options']['estado_fisico']; ?></td>
                                <td><?php echo $c['options']['contenido_neto']; ?></td>
                                <td><?php echo ($c['options']['iva'] == 'NO') ? 'N.A.' : '16'; ?></td>
                                <td><?php echo number_format($precio, 2); ?> MPX</td>
                                <td>
                                    <span id='cart-row<?php echo $k; ?>'><?php echo number_format($precio * $c['qty'], 2); ?></span> MPX

                                </td>
                            </tr>
                            <?php
                            $subtotal += $precio * $c['qty'];
                            $iva += ($c['options']['iva'] == 'SI') ? ($precio * (16 / 100)) * $c['qty']: 0;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan='<?php echo $largo;?>'> No hay productos en tu carrito.</td>
                        </tr>
                        <?php
                    }
                    ?>

                    <tr bgcolor="#FCDC2F">
                        <td align="right" colspan="<?php echo $largo;?>">Subtotal:  <span id="cart-subtotal"><?php echo number_format($subtotal, 2); ?></span> MXP</td>

                    </tr>
                    <tr bgcolor="#FCDC2F">
                        <td align="right" colspan="<?php echo $largo;?>">Iva:  <span id="cart-iva"><?php echo number_format($iva, 2); ?></span> MXP</td>

                    </tr>
                    <tr bgcolor="#FCDC2F">
                        <td align="right" colspan="<?php echo $largo;?>">Total:  <span id="cart-subtotal"><?php echo number_format($subtotal + $iva, 2); ?></span> MXP</td>

                    </tr>
                </tbody>
            </table>
            <br />
            <div class='clearfix'></div>
            <br />
            <br />
            <div id="footer">
                <p>Muchas gracias por realizar tu pedido con nostros. En breve una persona se comunicará contigo.</p>
                <p>Copyright © 2013 Tecnobotánica de México </p>
            </div>
        </div>
    </body>
</html>	
