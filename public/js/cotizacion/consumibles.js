jQuery.noConflict();
jQuery(document).ready(function(){

    //Mostrando consumibles de modelo elegido
    $("#consumibles").on('click', function(){

        var modelo = $("#modelo").val();

        $.ajax({

            type: 'POST',
            url: '/modelo/consumibles/buscar',
            data:{

                'modelo' : modelo,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.consumibles.length > 0 ){

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>consumible</b></td>'+
                                        '<td><b>Tipo</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#consumibles input").remove();

                    respuesta.consumibles.forEach(function(consumible){

                        html += '<tr>' +
                                    '<td><input type="checkbox" checked="true" name="consumible" id="consumible' + consumible.id + '" class="form-control consumible' + consumible.id + '" value="' + consumible.precio + '" data-id="' + consumible.id + '"></td>' +
                                    '<td>' + consumible.nombre + '</td>' +
                                    '<td>' + consumible.tipo + '</td>' +
                                    '<td>$ ' + consumible.precio + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorConsumibles").empty().append( html );

                    $("#agregarConsumible").attr('disabled', false);

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        $("#modalConsumible").css('display', 'none');
                        $(".modal-backdrop").remove();

                    }

                });

            }

        });

    });

    //Agregando consumibles al precio unitario
    $("#agregarConsumible").on('click', function(e){

        e.preventDefault();

        var consumibles = 0;
        var total = parseFloat( $("#total").val() );

        $("input[type=checkbox][name=consumible]").each(function(){

            if( $(this).is(':checked') ){

                consumibles += parseFloat( $(this).val() );

            }

        });

        total += consumibles;

        $("#modalConsumible").css('display', 'none');
        $(".modal-backdrop").remove();

        $("#total").val( total.toFixed(4) );

    });

});