jQuery.noConflict();
jQuery(document).ready(function(){

    $("#anticiparNota").on('click', function(e){

        e.preventDefault();

        var nota = $(this).attr('data-id');

        let procesamiento;

        Swal.fire({

            title: 'Cargando',
            html: 'Un momento por favor: <b></b>',
            timer: 19975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft();

                }, 100);

                $.ajax({

                    type: 'POST',
                    url: '/nota/anticipar',
                    data:{

                        'nota' : nota,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Datos de Producción de Nota Listos',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/notas/tabla/'+nota;
                            
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Hoja(s) Viajera(s) creada',
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                }).then( (resultado)=>{

                                    if( resultado.isConfirmed ){

                                        window.location.href = '/notas/viajera/'+nota;
                                        
                                    }

                                });

                            }

                        });

                    }else{

                        $("#anticiparNota").attr('disabled', true);

                        Swal.fire({

                            icon: 'error',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/notas/cliente/'+$("#idCliente").val();

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

                        window.location.href = '/notas/cliente/'+$("#idCliente").val();

                    }

                });

            }

        });

    });

});