jQuery.noConflict();
jQuery(document).ready(function(){

    $('.costos').on('click', function(){

        var modelo = $(this).attr('data-value');
        var id = $(this).attr('data-id');

        $("#nombreModeloCosto").val( modelo );

        $.ajax({

            type: 'POST',
            url: '/modelo/costos',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.costos.length > 0 && respuesta.costes.length > 0 ){

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td><input type="checkbox" id="todoCostos" name="todoCostos" checked></td>'+
                                        '<td><b>Costo</b></td>'+
                                        '<td><b>Descripción</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#costos input").remove();

                    respuesta.costos.forEach(function(costo){

                        var checked = false;

                        respuesta.costes.forEach(function( coste ){

                            if( costo.id === coste.id ){
                                
                                checked = true;

                            }

                        });
                        
                        html += '<tr>' +
                                    '<td><input type="checkbox" ' + (checked ? 'checked="true"' : '') + ' name="costo" id="costo' + costo.id + '" class="form-control costo' + costo.id + '" data-id="' + costo.id + '"></td>' +
                                    '<td>' + costo.nombre + '</td>' +
                                    '<td>' + costo.descripcion + '</td>' +
                                    '<td>$ ' + costo.total + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorCostos").empty().append( html );

                    /**Selección rapida de todo o nada */
                    $("#todoCostos").on('click', function(){

                        if( $(this).prop('checked') ){

                            $("input[type=checkbox][name=costo]").prop('checked', true);         

                        }else{

                            $("input[type=checkbox][name=costo]").prop('checked', false);

                        }

                    });

                }else{

                    if( respuesta.costos.length > 0 ){

                        var html = '<thead>' +
                                    '<tr>' +
                                        '<td><input type="checkbox" id="todoCostos" name="todoCostos" checked></td>'+
                                        '<td><b>Costo</b></td>'+
                                        '<td><b>Descripción</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                        delete respuesta.exito;

                        respuesta.costos.forEach( function( costo ){

                            html += '<tr>' +
                                        '<td><input type="checkbox" checked="true" name="costo" id="costo' + costo.id + '" class="form-control costo' + costo.id + '" data-id="' + costo.id + '"></td>' +
                                        '<td>' + costo.nombre + '</td>' +
                                        '<td>' + costo.descripcion + '</td>' +
                                        '<td>$ ' + costo.total + '</td>' +
                                    '</tr>';
    
                        });

                        $("#contenedorCostos").empty().append( html );

                        /**Selección rapida de todo o nada */
                        $("#todoCostos").on('click', function(){

                            if( $(this).prop('checked') ){

                                $("input[type=checkbox][name=costo]").prop('checked', true);         

                            }else{

                                $("input[type=checkbox][name=costo]").prop('checked', false);

                            }

                        });

                    }else{

                        Swal.fire({

                            icon: 'warning',
                            title: 'Sin costos registrados. Registralos ahora.',
                            allowOutsideClick: false,
                            showConfirmButton: true
    
                        }).then((resultado)=>{
    
                            if( resultado.isConfirmed ){
    
                                window.location.href = '/costos';
    
                            }
    
                        });

                    }

                }

            }else{

                if( respuesta.url ){

                    Swal.fire({

                        icon: 'warning',
                        title: respuesta.mensaje,
                        allowOutsideClick: false,
                        showConfirmButton: true

                    }).then((resultado)=>{

                        if( resultado.isConfirmed ){

                            window.location.href = respuesta.url;

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

                            $("#modalCosto").css('display', 'none');
                            $(".modal-backdrop").remove();

                        }

                    });

                }

            }

        });

    });

});