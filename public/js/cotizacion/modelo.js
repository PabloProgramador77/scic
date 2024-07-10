jQuery.noConflict();
jQuery(document).ready(function(){

    //Calculo de costo
    function calcularCosto( precio, cantidad ){

        return (precio * cantidad).toFixed(4);

    }

    $("#modelo").on('change', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/modelo/cotizacion',
            data:{

                'id' : $(this).val(),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){
            var filas = '<thead>' +
                            '<tr>' +
                                '<td></td>'+
                                '<td><b>Pieza</b></td>'+
                                '<td><b>Material</b></td>'+
                                '<td><b>Color</b></td>'+
                                '<td><b>Largo y Alto</b></td>'+
                                '<td><b>Piezas</b></td>'+
                                '<td><b>Área</b></td>'+
                                '<td><b>Cm2</b></td>'+
                                '<td><b>Dm</b></td>'+
                                '<td><b>Unidades</b></td>'+
                                '<td><b>MtsXPar</b></td>'+
                                '<td><b>Costo</b></td>'+
                            '</tr>'+
                        '</thead>';

            if( respuesta.exito ){

                if( respuesta.piezas.length > 0 && respuesta.materiales.length > 0 ){

                    var opcionesMateriales = '<option value="0, 0">Elige un material</option>';

                    respuesta.materiales.forEach( function(material){
                        opcionesMateriales += '<option style="background-color: '+material.hexColor+'" data-value="'+material.hexColor+'" value="' + material.precio + ', '+ material.unidades +', ' + material.id +'">' + material.nombre + ' - $' +material.precio + '</option>';
                    });

                    respuesta.piezas.forEach( function(pieza){

                        filas += '<tr>' +
                                    '<td><input type="checkbox" name="pieza" id="'+pieza.id+'" class="form-control pieza'+pieza.id+'"></td>' +
                                    '<td>' + pieza.nombre + '</td>' +
                                    '<td><select id="material'+pieza.id+'" name="material" class="form-control material'+pieza.id+'">' + opcionesMateriales + '</select></td>'+
                                    '<td><input type="color" name="colorPieza" id="colorPieza'+pieza.id+'" value="#FFFFFF" class="colorPieza'+pieza.id+'"></input></td>'+
                                    '<td>' + pieza.largo + ' X ' + pieza.alto + '</td>' +
                                    '<td>'+ pieza.cantidad +'</td>'+
                                    '<td>'+ (pieza.largo * pieza.alto).toFixed(4) +'</td>'+
                                    '<td>'+ ((pieza.largo * pieza.alto)*pieza.cantidad).toFixed(4) +'</td>'+
                                    '<td>'+ (((pieza.largo * pieza.alto)*pieza.cantidad)/100).toFixed(4) +'</td>'+
                                    '<td class="unidades'+pieza.id+'">0</td>'+
                                    '<td class="mts'+pieza.id+'">0</td>'+
                                    '<td class="bg-info costo'+pieza.id+'">0</td>'+
                                '</tr>';

                    });

                    $("#contenedorPiezas").empty().append( filas );

                    //Evento de selección de material
                    respuesta.piezas.forEach( function(pieza){

                        $('.material'+pieza.id).on('change', function(){

                            var valoresMaterial = $(this).val().split(',');
                            var precioMaterial = valoresMaterial[0]
                            var unidades = valoresMaterial[1];

                            var MtsXPar = ((pieza.largo * pieza.alto)*(pieza.cantidad)/(unidades*100));
                            var costo = calcularCosto( precioMaterial, MtsXPar );
                            
                            $('.unidades' + pieza.id).text(unidades);
                            $('.mts' + pieza.id).text( MtsXPar.toFixed(4) );
                            $('.costo' + pieza.id).text(costo);

                            var total = 0;

                            $('.bg-info').each(function(){

                                total += parseFloat( $(this).text() );

                            });

                            console.log( total );
                            $("#total").val( total.toFixed(4) );

                        });

                    });

                    //Evento de selección de pieza para el costo total
                    respuesta.piezas.forEach( function(pieza){

                        $('.pieza'+pieza.id).on('click', function(){

                            if( $(this).is(':checked') ){

                                var costo = parseFloat( $('.costo'+pieza.id).text() );
                                var total = parseFloat( $("#total").val() );

                                total += costo;

                                $("#total").val( total.toFixed(4) );

                            }else{

                                var costo = parseFloat( $('.costo'+pieza.id).text() );
                                var total = parseFloat( $("#total").val() );

                                total -= costo;

                                $("#total").val( total.toFixed(4) );

                            }

                        });

                    });

                    respuesta.piezas.forEach( function(pieza){

                        $('.material'+pieza.id).change(function(){

                            var color = $(this).find('option:selected').data('value');

                            $('.colorPieza'+pieza.id).val( color );

                        });

                    });

                    $("input[type=checkbox]").prop('checked', true);

                    $("#costos").attr('disabled', false);

                }else{

                    $("#contenedorPiezas").empty().append( filas );

                    Swal.fire({

                        icon: 'info',
                        title: 'Modelo sin piezas.',
                        allowOutsideClick: false,
                        showConfirmButton: true

                    });

                    $("#costos").attr('disabled', true);

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cotizacion';

                    }

                });

            }

        });

    });

});