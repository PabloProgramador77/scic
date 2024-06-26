jQuery.noConflict();
jQuery(document).ready(function(){

    $(".cliente").on('click', function(e){

        e.preventDefault();

        var idCliente = $(this).attr('data-id');
        var piezas = new Array();
        var costos = new Array();
        var consumibles = new Array();
        var suelas = new Array();
        var materiales = new Array();

        $("input[name=pieza]:checked").each(function(){

            piezas.push( $(this).attr('id') );

            var valoresMaterial = $(".material" + $(this).attr('id') ).val().split(',');

            materiales.push( valoresMaterial[2] );

        });

        $("input[name=costo]:checked").each(function(){

            costos.push( $(this).attr('data-id') );

        });

        $("input[name=consumible]:checked").each(function(){

            consumibles.push( $(this).attr('data-id') );

        });

        $("input[name=suela]:checked").each(function(){

            suelas.push( $(this).attr('data-id') );

        });

        Swal.fire({

            title: 'Asignando Nota',
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
                    url: '/cotizacion/cliente',
                    data:{

                        'cliente' : idCliente,
                        'modelo' : $("#modelo").val(),
                        'total' : $("#total").val(),
                        'piezas' : piezas,
                        'materiales' : materiales,
                        'costos' : costos,
                        'consumibles' : consumibles,
                        'suelas' : suelas,

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

                                window.location.href = '/cotizaciones';

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

                    icon: 'warning',
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