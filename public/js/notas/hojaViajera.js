jQuery.noConflict();
jQuery(document).ready(function(){

    $("#viajeras").on('click', function(e){

        e.preventDefault();

        var nota = $(this).attr('data-id');

        let procesamiento;

        Swal.fire({

            title: 'Buscando',
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
                    url: '/nota/viajera',
                    data:{

                        'nota' : nota,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Hoja Viajera Encontrada',
                            allowOutsideClick: false,
                            textConfirmButton: 'Descargar',
                            showConfirmButton: true,

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/notas/viajera/'+nota;

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