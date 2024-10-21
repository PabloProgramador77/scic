jQuery.noConflict();
jQuery(document).ready(function(){

    //Calculo de costo
    function calcularCosto( precio, cantidad ){

        return (precio * cantidad).toFixed(4);

    }

    $("#modelo").on('change', function(e){

        e.preventDefault();

        if( $(this).val() !== 'default' ){

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

                    if( respuesta.modelo.descripcion !== '' || respuesta.modelo.descripcion !== null ){

                        $("#descripcion").val( respuesta.modelo.descripcion );

                    }else{

                        $("#descripcion").val( 'Sin descripción disponible' );

                    }
                    
    
                    if( respuesta.piezas.length > 0 && respuesta.materiales.length > 0 ){
    
                        var opcionesMateriales = '<option value="0, 0">Elige un material</option>';
    
                        respuesta.materiales.forEach( function(material){
                            opcionesMateriales += '<option value="' + material.precio + ', '+ material.unidades +', ' + material.id +', '+material.nombre+', '+material.concepto+'">'+ material.concepto + ' ' + material.nombre + ' : $' +material.precio + '</option>';
                        });
    
                        respuesta.piezas.forEach( function(pieza){
    
                            filas += '<tr>' +
                                        '<td><input type="checkbox" name="pieza" id="'+pieza.id+'" class="form-control pieza'+pieza.id+'" data-value="'+pieza.nombre+', '+pieza.cantidad+', '+pieza.alto+', '+pieza.largo+'"></td>' +
                                        '<td>' + pieza.nombre + '</td>' +
                                        '<td><select id="material'+pieza.id+'" name="material" class="form-control material'+pieza.id+'">' + opcionesMateriales + '</select></td>'+
                                        '<td><select name="colorPieza" id="color'+pieza.id+'" class="form-control colorPieza'+pieza.id+'"></select></td>'+
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
                                var precioMaterial = parseFloat( valoresMaterial[0] );
                                var unidades = parseFloat( valoresMaterial[1] );
                                var material = valoresMaterial[3];
    
                                var MtsXPar = ((pieza.largo * pieza.alto)*(pieza.cantidad)/(unidades*100));
                                var costo = calcularCosto( precioMaterial, MtsXPar );
                                
                                $('.unidades' + pieza.id).text(unidades);
                                $('.mts' + pieza.id).text( MtsXPar.toFixed(4) );
                                $('.costo' + pieza.id).text(costo);
    
                                var total = 0;
    
                                $('.bg-info').each(function(){
    
                                    var valor = parseFloat( $(this).text() );
    
                                    if( !isNaN( valor ) ){
                                        
                                        total += valor;
    
                                    }
    
                                });
    
                                console.log( total );
                                $("#total").val( total.toFixed(4) );
    
                                $.ajax({
    
                                    type: 'POST',
                                    url: '/material/colores',
                                    data:{
    
                                        'material' : material,
    
                                    },
                                    dataType: 'json',
                                    encode: true,
    
                                }).done(function(respuesta){
    
                                    if( respuesta.exito ){
    
                                        if( respuesta.colores.length > 0 ){
    
                                            var opcionesColores = '';
    
                                            respuesta.colores.forEach(function(color){
    
                                                if( color.hexColor !== null ){
    
                                                    opcionesColores += '<option value="'+color.color+'" style="background-color: '+color.hexColor+';">'+color.color+'</option>'
    
                                                }
    
                                            });
    
                                            $('.colorPieza'+pieza.id).empty();
                                            $('.colorPieza'+pieza.id).append( opcionesColores );
    
                                        }else{
    
                                            Swal.fire({
    
                                                icon: 'info',
                                                title: 'Sin colores registrados',
                                                allowOutsideClick: false,
                                                showConfirmButton: true
                    
                                            });
                                            
                                        }
    
                                    }else{
    
                                        Swal.fire({
    
                                            icon: 'error',
                                            title: respuesta.mensaje,
                                            allowOutsideClick: false,
                                            showConfirmButton: true
                
                                        });
    
                                    }
    
                                });
    
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

        }else{

            Swal.fire({
                icon: 'info',
                title: 'Elige un modelo por favor',
                allowOutsideClick: false,
                showConfirmButton: true,
            });

        }

    });

});