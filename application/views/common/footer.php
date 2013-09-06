<?php
if($lateral_derecho != 0){?>
<div class='pull-right' style='width:25%'>
    <?php $this->load->view('common/lateral_derecho'); ?>
</div>
<?php
}
?>
<div class='clearfix'></div>
<br />
<br />
<div id="footer">


    <div class="wrapper2_t">
        <a href="http://tecnobotanicademexico.com.mx/privacidad.html">Pol&iacute;tica de privacidad</a> | <a href="#N">Ofertas</a> | <a href="<?php echo site_url('cuenta');?>">Crear Cuenta</a> | <a href="<?php echo site_url('cuenta');?>">Entrar</a> <br />
        Copyright © 2013 C&iacute;rculo Saludable 
    </div>







</div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        //alert('hola');
        
        
        $(".no-enter").keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
                                
        $('.optgroup').click(function(){
            //alert('clicked');
            var id = $(this).attr('data-subcategoria');
            var mostrar = $(this).attr('data-show');
                                    
            if(mostrar == 'si'){
                $(this).html('-');
                $(this).attr('data-show','no');
                $(".some"+id).show();
            }else{
                $(this).html('+');
                $(this).attr('data-show','si');
                $(".some"+id).hide();
            }
                                   
        });
        
        $('.cart-add').click(function(){
            var id = $(this).attr('data-id');
            var qty = $(this).attr('data-qty');
            var size = $(this).attr('data-cartsize');
            
            $('#cart-load').html('<img src="<?php echo base_url('img/cart-load-small.gif');?>" alt="Cargando..." />');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('tienda/agregar_producto');?>",
                cache: false,
                data: {id: id, qty: qty, size: size}
            }).done(function( html ) {
                $("#error_ajax").css('display','none');
                $("#carro").html(html);
                $('#cart-load').html('');
                $('html, body').animate({scrollTop:0}, 'slow');
            }).fail(function(jqXHR, textStatus) {
                $("#error_ajax").html('Error de ejecución');
                $("#error_ajax").css('display','block');
                $('#cart-load').html('');
                //alert( "Falla en el sistema. Contacte a su administrador.");
            });
            
        });
        
        $('.cart-remove').live('click',function(){
            var id = $(this).attr('data-id');
            var size = $(this).attr('data-cartsize');
            $('#cart-load').html('<img src="<?php echo base_url('img/cart-load-small.gif');?>" alt="Cargando..." />');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('tienda/quitar_producto');?>",
                cache: false,
                data: {id: id, size: size}
            }).done(function( html ) {
                $("#error_ajax").css('display','none');
                $("#carro").html(html);
                $('#cart-load').html('');
            }).fail(function(jqXHR, textStatus) {
                $("#error_ajax").html('Error de ejecución');
                $("#error_ajax").css('display','block');
                $('#cart-load').html('');
                //alert( "Falla en el sistema. Contacte a su administrador.");
            });
            
        });
        
        $('.cart-qty').live('keyup',function(){
            var id = $(this).attr('data-id');
            var qty = $(this).val();
            var size = $(this).attr('data-cartsize');
            var url;
            $('#cart-load').html('<img src="<?php echo base_url('img/cart-load-small.gif');?>" alt="Cargando..." />');
            if(qty != ''){
                if(qty == 0){
                    //alert('quitar');
                    url = "<?php echo site_url('tienda/quitar_producto'); ?>";
                }else{
                    url = "<?php echo site_url('tienda/cambiar_producto'); ?>";
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    data: {id: id,qty: qty, size:size}
                }).done(function(html) {
                    $("#error_ajax").css('display','none');
                    if(qty == 0){
                        $("#carro").html(html);
                    }else{
                        $("#cart-articulos").load("<?php echo site_url('tienda/total_articulos');?>");
                        $("#cart-subtotal").load("<?php echo site_url('tienda/subtotal');?>");
                        if(size == 'mediano'){
                            $("#cart-row"+id).load("<?php echo site_url('tienda/row_suma');?>/"+id);
                        }
                        
                        $('#cart-load').html('');
                    }
                    
                }).fail(function(jqXHR, textStatus) {
                    $("#error_ajax").html('Error de ejecución');
                    $("#error_ajax").css('display','block');
                    $('#cart-load').html('');
                    //alert( "Falla en el sistema. Contacte a su administrador.");
                });
            }else{
                $('#cart-load').html('');
            }
            //$('#cart-load').html('');
        });
        
        $("#search-button").click(function(){
            var search = $("#search-input").val().replace(/ /g,'_').replace(/(Á|á)/g,'a').replace(/(É|é|Ë|ë)/g,'e').replace(/(Í|í|Ï|ï)/g,'i').replace(/(Ó|ó|ö|Ö)/g,'o').replace(/(Ú|ú|Ü|ü)/g,'u').replace(/(Ñ|ñ)/g,'n');
            if(search != ''){
                //alert(search);
                window.location.replace('<?php echo site_url('tienda/buscar/');?>/' + search);
            }
        });
        
        $("#search-input").keyup(function(event){
            if(event.keyCode == 13) {
                $("#search-button").click();
            }
        });
        
        
    });
</script>
</body>
</html>	
