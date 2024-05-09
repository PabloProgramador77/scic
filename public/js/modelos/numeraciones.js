jQuery.noConflict();
jQuery(document).ready(function(){

    $('.numeraciones').on('click', function(){

        var modelo = $(this).attr('data-value');
        var id = $(this).attr('data-id');

        $("#nombreModeloNumeracion").val( modelo );

        $.ajax({

            type: 'POST',
            url: '/modelo/numeraciones',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.numeraciones.length > 0 ){

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>Numeración</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#numeraciones input").remove();

                    respuesta.numeraciones.forEach(function(numeracion){

                        html += '<tr>' +
                                    '<td><input type="checkbox" checked="true" name="numeracion" id="numeracion' + numeracion.id + '" class="form-control numeracion' + numeracion.id + '" data-id="' + numeracion.id + '"></td>' +
                                    '<td>' + numeracion.numero + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorNumeraciones").empty().append( html );

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

                            $("#modalSuela").css('display', 'none');
                            $(".modal-backdrop").remove();

                        }

                    });

                }

            }

        });

    });

});