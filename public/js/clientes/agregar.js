jQuery.noConflict();
jQuery(document).ready(function(){

    $("#registrar").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        Swal.fire({

            title: 'Registrando cliente',
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
                    url: '/cliente/agregar',
                    data:{

                        'numero' : $("#numero").val(),
                        'nombre' : $("#nombre").val(),
                        'telefono' : $("#telefono").val(),
                        'email' : $("#email").val(),
                        'estado' : $("#estado").val(),
                        'ciudad' : $("#ciudad").val(),
                        'colonia' : $("#colonia").val(),
                        'calle' : $("#calle").val(),
                        'exterior' : $("#exterior").val(),
                        'cp' : $("#cp").val(),
                        'empresa' : $("#empresa").val(),
                        'razon' : $("#razon").val(),
                        'rfc' : $("#rfc").val(),

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Cliente registrado',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/cotizaciones';

                            }

                        });

                    }else{

                        Swal.fire({

                            icon: 'warning',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/cotizaciones';

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

                    icon: 'error',
                    title: 'Hubo un inconveniente. Trata de nuevo.',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cotizaciones';

                    }

                });

            }

        });

    });
    
});