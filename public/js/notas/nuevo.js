jQuery.noConflict();
jQuery(document).ready(function(){

    $("#nota").on('click', function(e){

        var cotizaciones = new Array();

        e.preventDefault();

        $("input[name=cotizacion][type=checkbox]:checked").each(function(){

            cotizaciones.push( $(this).attr('data-id') );

        });

        if( cotizaciones.length <= 0 ){

            Swal.fire({

                icon: 'info',
                title: 'Elige las cotizaciones para la nueva nota.',
                showConfirmButton: true,
                allowOutsideClick: false,

            });   

        }else{

            Swal.fire({

                title: 'Creando Nota',
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
                        url: '/nota/agregar',
                        data:{
    
                            'cliente' : $("#idCliente").val(),
                            'cotizaciones' : cotizaciones,
    
                        },
                        dataType: 'json',
                        encode: true
    
                    }).done(function(respuesta){
    
                        if( respuesta.exito ){
    
                            Swal.fire({
    
                                icon: 'success',
                                title: 'Nota Creada',
                                allowOutsideClick: false,
                                showConfirmButton: true
    
                            }).then((resultado)=>{
    
                                if( resultado.isConfirmed ){
    
                                    window.location.href = '/nota/editar/'+respuesta.id+'/'+$("#idCliente").val();
    
                                }
    
                            });
    
                        }else{
    
                            Swal.fire({
    
                                icon: 'error',
                                title: respuesta.mensaje,
                                allowOutsideClick: false,
                                showConfirmButton: true
    
                            }).then((resultado)=>{
    
                                if( resultado.isConfirmed ){
    
                                    window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();
    
                                }
    
                            });
    
                        }
    
                    });
    
                },
                willClose: ()=>{
    
                    clearInterval(procesamiento);
    
                }
    
            }).then((resultado)=>{
    
                if( resultado.dismiss == Swal.DismissReason.timer ){
    
                    Swal.fire({
    
                        icon: 'warning',
                        title: 'Hubo un inconveniente. Trata de nuevo.',
                        allowOutsideClick: false,
                        showConfirmButton: true
    
                    }).then((resultado)=>{
    
                        if( resultado.isConfirmed ){
    
                            window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();
    
                        }
    
                    });
    
                }
    
            });

        }

    });

    $("input[name=cotizacion][type=checkbox]").on('click', function(){

        if( $(this).is(':checked') ){

            if( clientes.length > 0 ){

                if( clientes.indexOf( $(this).attr('data-value') ) === -1 ){

                    Swal.fire({
                        icon: 'info',
                        title: 'Elegiste una cotización que no es del mismo cliente.',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                    $(this).prop('checked', false);
    
                }else{
    
                    clientes.push( $(this).attr('data-value') );                
    
                }

            }else{

                clientes.push( $(this).attr('data-value') );

            }
            

        }else{

            var indice = clientes.indexOf( $(this).attr('data-value') );

            clientes.splice( indice, 1 );

        }

        console.log( clientes );

    });

});