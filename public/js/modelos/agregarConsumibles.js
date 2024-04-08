jQuery.noConflict();
jQuery(document).ready(function(){

    $("#agregarConsumible").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        var consumibles = new Array();

        $("input[name=consumible]:checked").each(function(){

            consumibles.push( $(this).attr('data-id') );

        });

        Swal.fire({

            title: 'Agregando Consumibles',
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
                    url: '/modelo/consumibles/agregar',
                    data:{

                        'modelo' : $("#idModelo").val(),
                        'consumibles' : consumibles,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Consumibles Agregados',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                $("#modalConsumible").css('display', 'none');
                                $('.modal-backdrop').remove();

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

                                window.location.href = '/modelos';

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