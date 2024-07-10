jQuery.noConflict();
jQuery(document).ready(function(){

    $("#envio").change(function(){

        if( $(this).val() === 'Envio cotizado'){

            $("#monto").attr('disabled', false);
            $("#monto").focus();

        }else{

            $("#monto").attr('disabled', true);

        }

    });

    $("#agregarImpuestos").on('click', function(e){

        e.preventDefault();

        let procesamiento;
        var iva = 'False';

        if( $("#iva").prop('checked') ){

            iva = 'True';

        }else{

            iva = 'False';

        }

        Swal.fire({

            title: 'Agregando extras',
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
                    url: '/nota/impuestos',
                    data:{

                        'iva' : iva,
                        'envio' : $("#envio").val(),
                        'monto' : $("#monto").val(),
                        'nota' : $("#idNota").val(),

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Extras agregados',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                // Ocultar el modal manualmente
                                document.getElementById("modalImpuesto").style.display = "none";
                                document.getElementById("modalImpuesto").classList.remove("show");

                                // Eliminar el backdrop manualmente
                                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

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