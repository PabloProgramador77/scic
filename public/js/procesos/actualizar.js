jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        Swal.fire({

            title: 'Actualizando proceso',
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
                    url: '/proceso/actualizar',
                    data:{

                        'nombre' : $("#nombreEditar").val(),
                        'orden' : $("#ordenEditar").val(),
                        'descripcion' : $("#descripcionEditar").val(),
                        'id' : $("#id").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        $("#actualizar").attr('disabled', true);

                        Swal.fire({

                            icon: 'success',
                            title: 'Proceso actualizado.',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/procesos';

                            }

                        });

                    }else{

                        $("#actualizar").attr('disabled', true);

                        Swal.fire({

                            icon: 'error',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/procesos';

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

                        window.location.href = '/procesos';

                    }

                });

            }

        });

    });

});