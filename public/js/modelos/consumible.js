jQuery.noConflict();
jQuery(document).ready(function(){

    $('.consumibles').on('click', function(){

        var modelo = $(this).attr('data-value');
        var id = $(this).attr('data-id');

        $("#nombreModeloConsumible").val( modelo );

        $.ajax({

            type: 'POST',
            url: '/modelo/consumibles',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.consumibles.length > 0 ){

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>Consumible</b></td>'+
                                        '<td><b>Tipo</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#consumibles input").remove();

                    respuesta.consumibles.forEach(function(consumible){

                        html += '<tr>' +
                                    '<td><input type="checkbox" checked="true" name="consumible" id="consumible' + consumible.id + '" class="form-control consumible' + consumible.id + '" data-id="' + consumible.id + '"></td>' +
                                    '<td>' + consumible.nombre + '</td>' +
                                    '<td>' + consumible.tipo + '</td>' +
                                    '<td>$ ' + consumible.precio + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorConsumibles").empty().append( html );

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

                            $("#modalconsumible").css('display', 'none');
                            $(".modal-backdrop").remove();

                        }

                    });

                }

            }

        });

    });

});