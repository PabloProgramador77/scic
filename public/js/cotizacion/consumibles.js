jQuery.noConflict();
jQuery(document).ready(function(){

    //Mostrando consumibles de modelo elegido
    $("#agregarCoste").on('click', function(){

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
                                        '<td><b>Consumible</b></td>'+
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

                }else{

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>Consumible</b></td>'+
                                        '<td><b>Tipo</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    html += '<tr><td colspan="4">Sin consumibles. Presiona "Continuar" por favor.</td></tr>';

                    $("#contenedorConsumibles").empty().append( html );

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

        console.log( total );

        document.getElementById('modalConsumible').style.display = 'none';
        document.getElementById('modalConsumible').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        $("#total").val( total.toFixed(4) );

        document.getElementById('modalSuela').style.display = 'block';
        document.getElementById('modalSuela').classList.add('show');
    });

    $("#cancelarConsumible").on('click', function(){

        document.getElementById('modalConsumible').style.display = 'none';
        document.getElementById('modalConsumible').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalCostes').style.display = 'block';
        document.getElementById('modalCostes').classList.add('show');

    });

});