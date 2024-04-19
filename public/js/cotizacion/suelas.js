jQuery.noConflict();
jQuery(document).ready(function(){

    //Mostrando consumibles de modelo elegido
    $("#suelas").on('click', function(){

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
                                    '<td><input type="checkbox" checked="true" name="suela" id="suela' + suela.id + '" class="form-control suela' + suela.id + '" value="' + suela.precio + '"></td>' +
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

        $("#modalSuela").css('display', 'none');
        $(".modal-backdrop").remove();

        $("#total").val( total.toFixed(4) );

    });

});