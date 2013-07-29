</div><!--/row-->

      <hr>
<footer>
        <p class='span5'>&copy; Asesores Herbolarios 2012</p>
        <p class='span3'>Recomendamos utilizar <a href='https://www.google.com/intl/es/chrome/browser/?hl=es' target='_blank'> Google Chrome</a> para asegurar una experiencia óptima.</p>
        <p class='span5'> <span class='pull-right'>Administrado por <a href='http://www.estrategiasdigitales.com.mx' target='_blank'> SMA Estrategias Digitales</a></span></p>
 </footer>
</div><!--/.fluid-container-->

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
        
        
        
        
    });
</script>
  </body>
</html>