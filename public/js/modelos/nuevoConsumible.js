jQuery.noConflict();
jQuery(document).ready(function(){

    $("#nuevoConsumible").on('click', function(){

        $("#modalConsumible").css('display', 'none');

    });

    $("#cancelarConsumible").on('click', function(){

        $("#modalNuevoConsumible").css('display', 'none');

        $("#modalConsumible").css('display', 'block');

    });

    $("#registrarConsumible").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        Swal.fire({

            title: 'Registrando Consumible',
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
                    url: '/consumible/agregar',
                    data:{

                        'nombre' : $("#nombreConsumible").val(),
                        'tipo' : $("#tipoConsumible").val(),
                        'precio' : $("#precioConsumible").val(),
                        'descripcion' : $("#descripcionConsumible").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Consumible Registrado',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/modelo/piezas/'+$("#idModelo").val();

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

                                window.location.href = '/modelo/piezas/'+$("#idModelo").val();

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

                        window.location.href = '/modelos';

                    }

                });

            }

        });

    });
    
});