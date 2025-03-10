jQuery.noConflict();
jQuery(document).ready(function(){

    $("#registrarMaterial").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        Swal.fire({

            title: 'Agregando Material',
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
                    url: '/material/agregar',
                    data:{

                        'nombre' : $("#nombre").val(),
                        'concepto' : $("#concepto").val(),
                        'precio' : $("#precio").val(),
                        'proveedor' : $("#proveedor").val(),
                        'unidades' : $("#unidades").val(),
                        'hex' : $("#color").val(),
                        'color' : $("#nombreColor").val(),

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Material agregado',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,

                        }).then((resultado)=>{

                            if( resultado.dismiss == Swal.DismissReason.timer ){

                                var selectMaterials = document.getElementsByName('material');
                                var option = document.createElement('option');
                                option.value = $("#precio").val()+','+$("#unidades").val()+', '+respuesta.id+', '+$("#nombre").val()+', '+$("#concepto").val();
                                option.text = $("#concepto").val()+' '+$("#nombre").val()+' : $'+$("#precio").val();

                                for( var i = 0; i < selectMaterials.length; i++ ){

                                    selectMaterials[i].add( option.cloneNode( true ) );

                                }

                                $("#modalMaterial").css('display', 'none');
                                $(".modal-backdrop").remove();

                                $("#formMaterial").trigger('reset');

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

                                window.location.href = '/materiales';

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

                        window.location.href = '/materiales';

                    }

                });

            }

        });

    });
    
});