<?php 
$carro = $this->phpsession->get('contenidos','carro');
$total = $this->carro->total_articulos();
$subtotal = $this->carro->get_subtotal();
?>

<table style='width:90%;'>
    <tbody>
        <tr bgcolor="#FCDC2F">
            <td colspan="3">
                Productos(<span id="cart-articulos"><?php echo $total;?></span> Artículo<?php echo ($total != 1) ? 's' : '';?>)
                <span id='cart-load' class='pull-right'></span>
            </td>
        </tr>
        <?php
        if(!empty($carro)){
            foreach($carro as $k => $c){?>
        <tr>
            <td>
                <input  class='input-mini cart-qty' type="text" value="<?php echo $c['qty'];?>" data-id='<?php echo $k;?>' data-cartsize='pequenio' />
            </td>
            <td><?php echo $c['name'];?></td>
            <td>
                <?php echo $c['price'] * (125/100);?> MPX
                <br />
                <a href="#N" class='cart-remove' data-id='<?php echo $k;?>' data-cartsize='pequenio' >Quitar</a> 
            </td>
        </tr>
        <?php
            }
        }else{
        ?>
        <tr>
            <td colspan='3'> No hay productos en tu carrito.</td>
        </tr>
        <?php
        }
        ?>
        
        <tr bgcolor="#FCDC2F">
            <td align="right" colspan="2">Subtotal:  <span id="cart-subtotal"><?php echo $subtotal;?></span> MXP</td>
            <td><input class='btn btn-success btn-mini' type="button" onclick="window.location.href='<?php echo site_url('pedido/previo');?>'" value="Continuar" /></td>
        </tr>
    </tbody>
</table>
