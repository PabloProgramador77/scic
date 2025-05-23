jQuery.noConflict();
jQuery(document).ready(function(){

    $("#agregarNum").on('click', function(e){

        if(  $("#dias").val() == 0 ){

            e.preventDefault();

            Swal.fire({

                icon: 'info',
                title: 'Elegir los días de entrega es obligatorio',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: false,

            });

            $("#dias").focus();

        }else{

            e.preventDefault();

            let procesamiento;
            var numeraciones = new Array();
            var descuentos = new Array();
            var pares = new Array();
            var montos = new Array();

            $("input[name=numeracion]").each(function(){

                var cantidad = 0;

                if( $(this).val() === '' || $(this).val() === null || $(this).val() === 0 ){

                    cantidad = 0;

                }else{

                    cantidad = $(this).val();

                }
                numeraciones.push({

                    'idNumeracion': $(this).attr('id'),
                    'idCotizacion' : $(this).attr('data-id'),
                    'cantidad' : cantidad,

                });

            });

            $("input[name=descuento]").each(function(){

                descuentos.push({

                    'idCotizacion' : $(this).attr('data-id'),
                    'idNota' : $(this).attr('id'),
                    'descuento' : $(this).val(),

                });

            });

            $("input[type=text][name=pares]").each(function(){

                pares.push({

                    'idNota' : $(this).attr('id'),
                    'idCotizacion' : $(this).attr('data-id'),
                    'pares' : $(this).val(),

                });

            });

            $("input[type=text][name=subtotal]").each(function(){

                montos.push({

                    'idNota' : $(this).attr('id'),
                    'idCotizacion' : $(this).attr('data-id'),
                    'monto' : $(this).val(),

                });

            });

            console.log( numeraciones );

            Swal.fire({

                title: 'Terminando Nota',
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
                        url: '/cotizacion/numeraciones',
                        data:{

                            'numeraciones' : numeraciones,
                            'pares' : pares,
                            'montos' : montos,
                            'descuentos' : descuentos,
                            'dias' : $("#dias").val(),

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

                                    window.location.href = '/nota/descargar/'+$("#idNota").val();

                                    setTimeout(()=>{

                                        window.location.href = '/notas/cliente/'+$("#idCliente").val();

                                    }, 3000);

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
    
});