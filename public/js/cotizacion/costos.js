jQuery.noConflict();
jQuery(document).ready(function(){

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