jQuery.noConflict();
jQuery(document).ready(function(){

    $('.costes').on('click', function(){

        var modelo = $(this).attr('data-value');
        var id = $(this).attr('data-id');

        $("#nombreModeloCoste").val( modelo );

        $.ajax({

            type: 'POST',
            url: '/modelo/costes',
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
                                        '<td></td>'+
                                        '<td><b>Costo</b></td>'+
                                        '<td><b>Descripción</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#costes input").remove();

                    respuesta.costos.forEach(function(costo){

                        var checked = false;

                        respuesta.costes.forEach(function( coste ){

                            if( costo.id === coste.id ){
                                
                                checked = true;

                            }

                        });
                        
                        html += '<tr>' +
                                    '<td><input type="checkbox" ' + (checked ? 'checked="true"' : '') + ' name="coston" id="coston' + costo.id + '" class="form-control coston' + costo.id + '" data-id="' + costo.id + '"></td>' +
                                    '<td>' + costo.nombre + '</td>' +
                                    '<td>' + costo.descripcion + '</td>' +
                                    '<td>$ ' + costo.monto + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorCostes").empty().append( html );

                }else{

                    if( respuesta.costos.length > 0 ){

                        respuesta.costos.forEach( function( costo ){

                            html += '<tr>' +
                                        '<td><input type="checkbox" checked="true" name="coston" id="coston' + costo.id + '" class="form-control coston' + costo.id + '" data-id="' + costo.id + '"></td>' +
                                        '<td>' + costo.nombre + '</td>' +
                                        '<td>' + costo.descripcion + '</td>' +
                                        '<td>$ ' + costo.monto + '</td>' +
                                    '</tr>';
    
                        });

                        $("#contenedorCostes").empty().append( html );

                    }else{

                        Swal.fire({

                            icon: 'warning',
                            title: 'Sin costos neutros registrados. Registralos ahora.',
                            allowOutsideClick: false,
                            showConfirmButton: true
    
                        }).then((resultado)=>{
    
                            if( resultado.isConfirmed ){
    
                                window.location.href = '/costes';
    
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

                            $("#modalCoste").css('display', 'none');
                            $(".modal-backdrop").remove();

                        }

                    });

                }

            }

        });

    });

});