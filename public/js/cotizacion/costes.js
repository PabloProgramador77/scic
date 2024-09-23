jQuery.noConflict();
jQuery(document).ready(function(){

    //Mostrando costos de modelo elegido
    $("#agregar").on('click', function(){

        var modelo = $("#modelo").val();

        $.ajax({

            type: 'POST',
            url: '/modelo/costes/buscar',
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
                                        '<td><b>Descripción</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#costos input").remove();

                    respuesta.costos.forEach(function(costo){

                        html += '<tr>' +
                                    '<td><input type="checkbox" checked="true" name="coston" id="coston' + costo.id + '" class="form-control coston' + costo.id + '" value="' + costo.monto + '" data-id="' + costo.id + '"></td>' +
                                    '<td>' + costo.nombre + '</td>' +
                                    '<td>' + costo.descripcion + '</td>' +
                                    '<td>$ ' + costo.monto + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorCostes").empty().append( html );

                }else{

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>Costo</b></td>'+
                                        '<td><b>Descripción</b></td>'+
                                        '<td><b>Total</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    html += '<tr><td colspan="4">Sin costos neutros. Presiona "Continuar" por favor.</td></tr>';

                    $("#contenedorCostes").empty().append( html );

                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        $("#modalCostes").css('display', 'none');
                        $(".modal-backdrop").remove();

                    }

                });

            }

        });

    });

    //Agregando costos al precio unitario
    $("#agregarCoste").on('click', function(e){

        e.preventDefault();

        var costes = 0;
        var total = parseFloat( $("#total").val() );

        $("input[type=checkbox][name=coston]").each(function(){

            if( $(this).is(':checked') ){

                costes += parseFloat( $(this).val() );

            }

        });

        total += costes;

        console.log( total );

        document.getElementById('modalCostes').style.display = 'none';
        document.getElementById('modalCostes').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        $("#total").val( total.toFixed(4) );

        document.getElementById('modalConsumible').style.display = 'block';
        document.getElementById('modalConsumible').classList.add('show');

    });

    //Cerrando modal de COSTOS
    $("#cancelarCoste").on('click', function(){

        document.getElementById('modalCostes').style.display = 'none';
        document.getElementById('modalCostes').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalCostos').style.display = 'block';
        document.getElementById('modalCostos').classList.add('show');

    });

});