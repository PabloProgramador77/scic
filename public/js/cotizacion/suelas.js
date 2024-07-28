jQuery.noConflict();
jQuery(document).ready(function(){

    //Mostrando consumibles de modelo elegido
    $("#agregarConsumible").on('click', function(){

        var modelo = $("#modelo").val();

        $.ajax({

            type: 'POST',
            url: '/modelo/suelas/buscar',
            data:{

                'modelo' : modelo,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.suelas.length > 0 ){

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>Suela</b></td>'+
                                        '<td><b>Precio</b></td>'+
                                        '<td><b>Descripción</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#suelas input").remove();

                    respuesta.suelas.forEach(function(suela){

                        html += '<tr>' +
                                    '<td><input type="checkbox" checked="true" name="suela" id="suela' + suela.id + '" class="form-control suela' + suela.id + '" value="' + suela.precio + '" data-id="' + suela.id + '"></td>' +
                                    '<td>' + suela.nombre + '</td>' +
                                    '<td>' + suela.precio + '</td>' +
                                    '<td>$ ' + suela.descripcion + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorSuelas").empty().append( html );

                    $("#agregarSuela").attr('disabled', false);

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        $("#modalSuela").css('display', 'none');
                        $(".modal-backdrop").remove();

                    }

                });

            }

        });

    });

    //Agregando consumibles al precio unitario
    $("#agregarSuela").on('click', function(e){

        e.preventDefault();

        var suelas = 0;
        var total = parseFloat( $("#total").val() );

        $("input[type=checkbox][name=suela]").each(function(){

            if( $(this).is(':checked') ){

                suelas += parseFloat( $(this).val() );

            }

        });

        total += suelas;

        console.log( total );

        document.getElementById('modalSuela').style.display = 'none';
        document.getElementById('modalSuela').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        $("#total").val( total.toFixed(4) );

        var piezas = new Array();
        var materiales = new Array();
        var costos = new Array();
        var costes = new Array();
        var consumibles = new Array();
        var suelas = new Array();
        var colores = new Array();

        $("input[name=pieza]:checked").each(function(){

            piezas.push( $(this).attr('id') );

            var valoresMaterial = $(".material" + $(this).attr('id') ).val().split(',');
            var colorMaterial = $('.colorPieza' + $(this).attr('id') ).val();

            materiales.push( valoresMaterial[2] );

            colores.push( colorMaterial );

        });

        $("input[name=costo]:checked").each(function(){

            costos.push( $(this).attr('data-id') );

        });

        $("input[name=coston]:checked").each(function(){

            costes.push( $(this).attr('data-id') );

        });

        $("input[name=consumible]:checked").each(function(){

            consumibles.push( $(this).attr('data-id') );

        });

        $("input[name=suela]:checked").each(function(){

            suelas.push( $(this).attr('data-id') );

        });

        let procesamiento;

        Swal.fire({

            title: 'Registrando Cotización',
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
                    url: '/cotizacion/agregar',
                    data:{

                        'cliente' : $("#idCliente").val(),
                        'modelo' : $("#modelo").val(),
                        'total' : $("#total").val(),
                        'piezas' : piezas,
                        'materiales' : materiales,
                        'costos' : costos,
                        'costes' : costes,
                        'consumibles' : consumibles,
                        'suelas' : suelas,
                        'colores' : colores,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Cotización Registrada',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();

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

                                window.location.href = '/cotizador/cliente/'+$("#idCliente").val();

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

                        window.location.href = '/cotizador/cliente/'+$("#idCliente").val();

                    }

                });

            }

        });

    });

    $("#cancelarSuela").on('click', function(){

        document.getElementById('modalSuela').style.display = 'none';
        document.getElementById('modalSuela').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalConsumible').style.display = 'block';
        document.getElementById('modalConsumible').classList.add('show');

    });

});