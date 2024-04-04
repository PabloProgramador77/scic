jQuery.noConflict();
jQuery(document).ready(function(){

    //Mostrando costos de modelo elegido
    $("#costos").on('click', function(){

        var modelo = $("#modelo").val();

        $.ajax({

            type: 'POST',
            url: '/modelo/costos/buscar',
            data:{

                'modelo' : modelo,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.costos.length > 0 ){

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>Costo</b></td>'+
                                        '<td><b>Tipo</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#costos input").remove();

                    respuesta.costos.forEach(function(costo){

                        html += '<tr>' +
                                    '<td><input type="checkbox" checked="true" name="costo" id="costo' + costo.id + '" class="form-control costo' + costo.id + '" value="' + costo.total + '"></td>' +
                                    '<td>' + costo.nombre + '</td>' +
                                    '<td>' + costo.tipo + '</td>' +
                                    '<td>$ ' + costo.total + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorCostos").empty().append( html );

                    $("#agregar").attr('disabled', false);

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        $("#modalCostos").css('display', 'none');
                        $(".modal-backdrop").remove();

                    }

                });

            }

        });

    });

    //Agregando costos al precio unitario
    $("#agregar").on('click', function(e){

        e.preventDefault();

        var costos = 0;
        var total = parseFloat( $("#total").val() );

        $("input[type=checkbox][name=costo]").each(function(){

            if( $(this).is(':checked') ){

                costos += parseFloat( $(this).val() );

            }

        });

        total += costos;

        $("#modalCostos").css('display', 'none');
        $(".modal-backdrop").remove();

        $("#total").val( total.toFixed(4) );

    });

});