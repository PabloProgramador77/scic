jQuery.noConflict();
jQuery(document).ready(function(){

    //Precarga de datos de piezas
    $(".pieza").on('click', function(){

        $("#nombrePieza").val('');
        $("#idPieza").val('');

        if( $(this).is(':checked') ){

            $("#nombrePieza").val( $(this).val() );
            $("#idPieza").val( $(this).attr('data-id') );
            $("#agregar").attr('disabled', false);

        }else{

            $("#agregar").attr('disabled', true);

        }
        
    });

    $("#agregar").on('click', function(e){

        e.preventDefault();

        $("#agregar").attr('disabled', true);
        $("#cantidad").attr('disabled', true);

        Swal.fire({

            title: 'Agregando Piezas',
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
                    url: '/modelo/piezas',
                    data:{

                        'idModelo' : $("#idModelo").val(),
                        'idPieza' : $("#idPieza").val(),
                        'cantidad' : $("#cantidad").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Piezas Agregadas',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                $("#modalPiezas").css('display', 'none');
                                $(".modal-backdrop").remove();
                                $("input[type=checkbox][data-id=" + $("#idPieza").val() + "]").attr('disabled', true);

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

                                window.location.href = '/modelo/piezas/' + $("#idModelo").val();

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

                        window.location.href = '/modelo/piezas/' + $("#idModelo").val();

                    }

                });

            }

        });

    });

});