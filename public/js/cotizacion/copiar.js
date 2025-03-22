jQuery.noConflict();
jQuery(document).ready(function(){

    $("#copiar").on('click', function(e){

        var cotizaciones = new Array();
        var cliente = $(this).attr('data-id');

        e.preventDefault();

        $("#cotizaciones input[name=cotizacion][type=checkbox]:checked").each(function(){

            cotizaciones.push( $(this).attr('data-id') );

        });

        if( cotizaciones.length <= 0 ){

            Swal.fire({

                icon: 'info',
                title: 'Elige las cotizaciones para copiar.',
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 1500,
                timerProgressBar: true,

            });

            setTimeout(()=>{
                location.href = '/cotizaciones/cliente/'+cliente;
            },1250);


        }else{

            console.log(cotizaciones);
        
            $(".cliente").on('click', function(e){

                e.preventDefault();

                var customer = $(this).attr('data-id');
            
                Swal.fire({

                    title: 'Copiando Cotizaciones',
                    html: 'Un momento por favor: <b></b>',
                    timer: 9975,
                    allowOutsideClick: false,
                    didOpen: ()=>{
    
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        procesamiento = setInterval(()=>{
    
                            b.textContent = Swal.getTimerLeft();
    
                        }, 100);
    
                        $.ajax({
    
                            type: 'POST',
                            url: '/cotizacion/copiar',
                            data:{
    
                                'cotizaciones' : cotizaciones,
                                'cliente' : cliente,
                                'customer' : customer,
    
                            },
                            dataType: 'json',
                            encode: true
    
                        }).done(function(respuesta){
    
                            if( respuesta.exito ){
    
                                clearInterval(procesamiento);
                                Swal.fire({
    
                                    icon: 'success',
                                    title: 'Cotizaciones copiadas exitosamente.',
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
    
                                }).then((resultado)=>{
    
                                    location.href = '/cotizaciones/cliente/'+cliente;
    
                                });
    
                            }else{
    
                                clearInterval(procesamiento);
                                Swal.fire({
    
                                    icon: 'error',
                                    title: 'Error al copiar las cotizaciones.',
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
    
                                }).then((resultado)=>{
    
                                    location.href = '/cotizaciones/cliente/'+cliente;
                                });
    
                            }
    
                        });
    
                    }
    
                });

            });

        }

    });

});