<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Author: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006
*/

function to_excel($query, $filename='exceloutput',$fields = false)
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
     
     $obj =& get_instance();
     
     if (!$fields) {
          $fields = $query->list_fields();
     }
     
     if ($query->num_rows() == 0) {
          echo '<p>The table appears to have no data.</p>';
     } else {
          foreach ($fields as $field) {
             $headers .= $field . "\t";
          }
         
          foreach ($query->result() as $row) {
               $line = '';
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = "\t";
                    } else {
                         $value = str_replace('"', '""', $value);
                         $value = '"' . $value . '"' . "\t";
                    }
                    $value1 = utf8_decode($value);
                    $line .= $value1;
               }
               $data .= trim($line)."\n";
          }
          
          $data = str_replace("\r","",$data);
           
          header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo "$headers\n$data";  
     }
}

function reporte_excel($query,$title,$num_data,$subtotal = false,$filename='reporte_excel'){

     $fields = $query->list_fields();

     if ($query->num_rows() == 0) {
          echo '<p>Error 2560: No se pudo crear la tabla de excel.Por favor contacte a su administrador.</p>';
     } else {
          header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$filename.xls");
          ?>
          <table border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                    <td height="29" colspan="<?php echo $num_data;?>" align="center"><h5><strong><?php echo $title;?></strong></h5></td>
               </tr>
               
            
               <tr bgcolor="#EEEEEE">
                    <?php foreach ($fields as $field) { ?>     
                    <td><b><?php echo $field;?></b></td>
                    <?php } ?>
               </tr>
               
               <?php
               foreach ($query->result() as $row) {?>
               <tr>
                    <?php
                    foreach($row as $value) {
                         if ((!isset($value)) OR ($value == "")) {
                              $value = " ";
                         } else {
                              $value = str_replace('"', '', $value);
                              //$value = '"' . $value . '"';
                         }
                    ?>
                    <td><?php echo ($value);?></td>
                    <?php
                    }?>
               </tr>
               <?php     
               }

               if($subtotal){
                    ?>
                    <tr>
                         <td colspan="<?php echo $num_data;?>"><?php echo ('Envío: $50');?></td>
                    </tr>
                    <tr>
                         <td colspan="<?php echo $num_data;?>">Importe Total: $<?php echo $subtotal;?></td>
                    </tr>
                    <?php
               }
               ?>

               
          </table>
               <?php
               
     }
}

function cliente_excel_html($query,$filename="reporte_excel"){
     header("Content-type: application/x-msdownload");
     header("Content-Disposition: attachment; filename=$filename.xls");?>
     <table>
          <tr>
               <th>Nombre(s)</th>
               <th>Apellidos</th>
               <th>E-mail</th>
               <th>Clave Cliente</th>
               <th>Contraseña</th>
               <th>Fecha Alta</th>
               <th>Calle </th>
               <th>Delegación o Municipio</th>
               <th>Código Postal</th>
               <th>Ciudad</th>
               <th>Estado</th>
               <th>País</th>
               <th>Activo</th>
          </tr>

     <?php
     foreach($query->result() as $cliente){?>
          <tr>
               <td><?php echo $cliente->nom_client;?></td>
               <td><?php echo $cliente->apellido;?></td>
               <td><?php echo $cliente->correo;?></td>
               <td><?php echo $cliente->abreviatura.''.$cliente->idCliente;?></td>
               <td><?php echo $cliente->contrasena;?></td>
               <td><?php echo $cliente->fecha;?></td>
               <td><?php echo $cliente->calle;?></td>
               <td><?php echo $cliente->delegacion;?></td>
               <td><?php echo $cliente->codigo_postal;?></td>
               <td><?php echo $cliente->ciudad;?></td>
               <td><?php echo $cliente->estado;?></td>
               <td><?php echo $cliente->pais;?></td>
               <td><?php echo $cliente->client_act;?></td>
          </tr>
     <?php } ?>
     </table>
<?php
}

function producto_excel_html($query,$filename="reporte_excel"){
     header("Content-type: application/x-msdownload");
     header("Content-Disposition: attachment; filename=$filename.xls");?>
     <table>
          <tr>
               <th>Categoría</th>
               <th>Subcategoría</th>
               <th>Producto</th>
               <th>Uso</th>
               <th>Presentación</th>
               <th>Clave Presentación</th>
               <th>Contenido Neto</th>
               <th>Grupo</th>
               <th>Ingredientes</th>
               <th>IVA</th>
               <th>Precio Público</th>
               <th>Activo</th>
          </tr>

     <?php
     foreach($query->result() as $cliente){?>
          <tr>
               <td><?php echo $cliente->catnombre;?></td>
               <td><?php echo $cliente->subcatnombre;?></td>
               <td><?php echo $cliente->produnombre;?></td>
               <td><?php echo $cliente->uso;?></td>
               <td><?php echo $cliente->estado_fisico;?></td>
               <td><?php echo $cliente->clave;?></td>
               <td><?php echo $cliente->contenido_neto;?></td>
               <td><?php echo $cliente->grupo;?></td>
               <td><?php echo $cliente->ingredientes;?></td>
               <td><?php echo $cliente->iva;?></td>
               <td><?php echo $cliente->precio_publico;?></td>
               <td><?php echo $cliente->active;?></td>
          </tr>
     <?php } ?>
     </table>
<?php
}

function reporte_excel_html($seccion,$rol,$consultaUno,$consultaDos,$consultaTres,$idioma = false,$filename="reporte_excel"){

     /*header("Content-type: application/x-msdownload");
     header("Content-Disposition: attachment; filename=$filename.xls");*/
     header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
     header("Expires: 0");
     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
     header("Content-Disposition: attachment; filename=\"".$filename.".xls\"");
     construyeFormularioEdicion2($seccion,$rol,$consultaUno,$consultaDos,$consultaTres,$idioma);

}

function reporte_excel_todos($arreglo,$filename="reporte_excel"){

     header("Content-type: application/x-msdownload");
     header("Content-Disposition: attachment; filename=$filename.xls");
     foreach($arreglo as $pedido){
          construyeFormularioEdicion2($pedido['seccion'],$pedido['rol'],$pedido['consultaUno'],$pedido['consultaDos'],$pedido['consultaTres']);
     }
     

}