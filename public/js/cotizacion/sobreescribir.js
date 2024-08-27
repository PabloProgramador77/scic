jQuery.noConflict();
jQuery( document ).ready( function(){

    $(".sobreescribir").on('click', function(e){

        e.preventDefault();

        var idModelo = $(this).attr('data-id');

        let procesamiento;

        Swal.fire({

            title: 'Sobreescribiendo Variante',
            html: 'Un momento por favor: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval(()=>{

                }, 100);

                $.ajax({

                    type: 'POST',
                    url: '/cotizacion/variante/sobreescribir',
                    data:{

                        'nombre' : $("#modeloVariante").val(),
                        'numero' : $("#numeroVariante").val(),
                        'descripcion' : $("#descripcionVariante").val(),
                        'variante' : $("#cadenaVariante").val(),
                        'id' : $("#idModeloVariante").val(),
                        'cotizacion' : $("#cotizacionVariante").val(),
                        'idModelo' : idModelo,

                    },
                    dataType: 'json',
                    encode: true,
                }).done( function( respuesta ){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Variante Guardada',
                            allowOutsideClick: false,
                            showConfirmButton: true,

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/cotizador/cliente/'+$("#idCliente").val();

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
        
                                window.location.href = '/cotizador/cliente/'+$("#idCliente").val();
        
                            }
        
                        });

                    }

                });

            },
            willClose: ()=>{

                clearInterval( procesamiento );

            }

        }).then( (resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Swal.fire({

                    icon: 'warning',
                    title: 'Hubo un inconveniente. Trata de nuevo.',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cotizador/cliente/'+$("#idCliente").val();

                    }

                });

            }

        });

    });

});