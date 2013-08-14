<?php 
$mayor = $this->phpsession->get('datos','mayorista');
$carro = $this->phpsession->get('contenidos','carro');
$total = $this->carro->total_articulos();
//$subtotal = $this->carro->get_subtotal();
$iva = 0;
$precio = 0;
$subtotal = 0;
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
                $precio = $c['price'] * ($mayor['descuento']/100);
                //print_r($c);?>
        <tr>
            <td>
                <?php echo $c['qty'];?>
            </td>
            <td><?php echo $c['id'];?></td>
            <td><?php echo $c['name'];?></td>
            <td><?php echo $c['options']['estado_fisico'];?></td>
            <td><?php echo $c['options']['contenido_neto'];?></td>
            <td><?php echo ($c['options']['iva'] == 'NO') ? 'N.A.' : '16';?></td>
            <td><?php echo number_format($precio,2);?> MPX</td>
            <td>
                <span id='cart-row<?php echo $k;?>'><?php echo number_format($precio * $c['qty'],2);?></span> MPX
                
            </td>
        </tr>
        <?php
            $subtotal += $precio * $c['qty'];
            $iva += ($c['options']['iva'] == 'SI') ? ($precio * (16 / 100)) * $c['qty'] : 0;
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
            
        </tr>
        <tr bgcolor="#FCDC2F">
            <td align="right" colspan="8">Iva:  <span id="cart-iva"><?php echo number_format($iva,2);?></span> MXP</td>
            
        </tr>
        <tr bgcolor="#FCDC2F">
            <td align="right" colspan="8">Total:  <span id="cart-subtotal"><?php echo number_format($subtotal + $iva,2);?></span> MXP</td>
            
        </tr>
    </tbody>
</table>
<br />
