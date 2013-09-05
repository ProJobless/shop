<?php 
$carro = $this->phpsession->get('contenidos','carro');
$total = $this->carro->total_articulos();
$subtotal = $this->carro->get_subtotal();
?>

<table style='width:90%;'>
    <tbody>
        <tr bgcolor="#FCDC2F">
            <td colspan="8">
                Productos(<span id="cart-articulos"><?php echo $total;?></span> Artículo<?php echo ($total != 1) ? 's' : '';?>)
                <span id='cart-load' class='pull-right'></span>
            </td>
        </tr>
        <tr>
            <td>Cantidad</td>
            <td>Código</td>
            <td>Nombre Producto</td>
            <td>Estado Físico</td>
            <td>Contenido Neto</td>
            <td>IVA</td>
            <td>Precio Catálogo</td>
            <td>Importe</td>
        </tr>
        <?php
        if(!empty($carro)){
            foreach($carro as $k => $c){
                //print_r($c);?>
        <tr>
            <td>
                <input  class='input-mini cart-qty' type="text" value="<?php echo $c['qty'];?>" data-id='<?php echo $k;?>' data-cartsize='mediano' />
            </td>
            <td><?php echo $c['id'];?></td>
            <td><?php echo $c['name'];?></td>
            <td><?php echo $c['options']['estado_fisico'];?></td>
            <td><?php echo $c['options']['contenido_neto'];?></td>
            <td><?php echo ($c['options']['contenido_neto'] == 'NO') ? 'N.A.' : '16';?></td>
            <td><?php echo number_format($c['price'] * (125/100),2);?> MPX</td>
            <td>
                <span id='cart-row<?php echo $k;?>'><?php echo number_format(($c['price'] * (125/100)) * $c['qty'],2);?></span> MPX
                <br />
                <a href="#N" class='cart-remove' data-id='<?php echo $k;?>' data-cartsize='mediano' >Quitar</a> 
            </td>
        </tr>
        <?php
            }
        }else{
        ?>
        <tr>
            <td colspan='8'> No hay productos en tu carrito.</td>
        </tr>
        <?php
        }
        ?>
        
        <tr bgcolor="#FCDC2F">
            <td align="right" colspan="8">Subtotal:  <span id="cart-subtotal"><?php echo number_format($subtotal,2);?></span> MXP</td>
            <td></td>
        </tr>
    </tbody>
</table>
<br />


<div class='btn-group pull-right'>
    
    
    <?php
    $user = $this->phpsession->get('datos','usuario');
    if(!empty($user)){?>
        <a href="<?php echo site_url('tienda/vaciar_carro');?>" class='btn pull-left' type="button">Cancelar</a>
        <a href="<?php echo site_url('pedido/confirmar');?>" class='btn btn-success' type="button">Continuar</a>
    <?php
    }else{?>
        <a href="<?php echo site_url('cuenta');?>" class='btn btn-success' type="button">Iniciar Sesión</a>
    <?php
    }
    ?>
    
</div>
