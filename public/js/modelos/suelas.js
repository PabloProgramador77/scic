jQuery.noConflict();
jQuery(document).ready(function(){

    $('.suelas').on('click', function(){

        var modelo = $(this).attr('data-value');
        var id = $(this).attr('data-id');

        $("#nombreModeloSuela").val( modelo );

        $.ajax({

            type: 'POST',
            url: '/modelo/suelas',
            data:{

                'id' : id,

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
                                    '<td><input type="checkbox" checked="true" name="suela" id="suela' + suela.id + '" class="form-control suela' + suela.id + '" data-id="' + suela.id + '"></td>' +
                                    '<td>' + suela.nombre + '</td>' +
                                    '<td>$ ' + suela.precio + '</td>' +
                                    '<td>' + suela.descripcion + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorSuelas").empty().append( html );

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