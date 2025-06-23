jQuery.noConflict();
jQuery(document).ready(function(){

    $("#preeliminar").on('click', function(e){

        e.preventDefault();

        var suelas = 0;
        var total = parseFloat( $("#total").val() );
        var ganancia = parseFloat( $("#ganancia").val() );
        var cliente = $("#cliente").val();
        var modelo = $("#modelo option:selected").attr('data-value').split(',');
        var observaciones = $("#observaciones").val();

        $("input[type=checkbox][name=suela]").each(function(){

            if( $(this).is(':checked') ){

                suelas += parseFloat( $(this).val() );

            }

        });

        total += suelas;
        total += ganancia;

        console.log( total );

        $("#total").val( total.toFixed(4) );

        var piezas = new Array();
        var materiales = new Array();
        var costos = new Array();
        var costes = new Array();
        var consumibles = new Array();
        var suelas = new Array();
        var colores = new Array();
        var conceptos = new Array();
        var precios = new Array();
        var unidades = new Array();

        $("input[name=pieza][type=checkbox]:checked").each(function(){

            console.log( $(this).attr('data-id') );
            var valoresPiezas = $(this).val().split(',');
            console.log( valoresPiezas );
            piezas.push( valoresPiezas );

            var valoresMaterial = $('select[name=material][data-id='+$(this).attr('data-id')+']').val().split(',');
            console.log( valoresMaterial );
            var colorMaterial = $('select[name=colorPieza][data-id='+$(this).attr('data-id')+']' ).val();
            console.log( colorMaterial );

            materiales.push( valoresMaterial[3] );
            conceptos.push ( valoresMaterial[4] );
            precios.push( valoresMaterial[0] );
            unidades.push( valoresMaterial[1] );

            colores.push( colorMaterial );

        });

        $("input[name=costo]:checked").each(function(){

            costos.push( $(this).attr('data-id') );

        });

        $("input[name=coston]:checked").each(function(){

            costes.push( $(this).attr('data-id') );

        });

        $("input[name=consumible]:checked").each(function(){

            var valores = $(this).attr('data-value').split(',');
            consumibles.push( valores );

        });

        $("input[name=suela]:checked").each(function(){

            var id = $(this).attr('id');

            colorPiso = $("input[type=text][name=colorSuelaPiso][id="+id+"]").val();
            colorCuna = $("input[type=text][name=colorSuelaCuna][id="+id+"]").val();

            suelas.push( $(this).attr('data-value') );

        });

        console.log( modelo );

        //Despliegue de información
        $("#clientePreeliminar").val( cliente );
        $("#modeloPreeliminar").val( modelo[0] +'-'+ modelo[1] );
        $("#totalPreeliminar").val( total );
        $("#observacionesPreeliminar").val( observaciones );
        $("#hormaPreeliminar").val( modelo[2] );

        $("#suelaPreeliminar").val( suelas.join(',')+' '+colorPiso+' '+colorCuna );
        $("#coloresPreeliminar").val( colores.join(',') );

        $("#PreeliminarPiezas").empty();

        var html = '<tr><th>Pieza</th><th>Material</th><th>Color</th><th>Cantidad</th><th>Alto x Largo</th><th>Costo</th></tr>';

        piezas.forEach( function( pieza, i){

            html += '<tr>';
            html += '<td>'+pieza[0]+'</td>';
            html += '<td>'+conceptos[i]+' '+materiales[i]+'</td>';
            html += '<td>'+(colores[i] ? colores[i] : '')+'</td>';
            html += '<td>'+pieza[1]+'</td>';
            html += '<td>'+pieza[2]+' x '+pieza[3]+'</td>';
            html += '<td>$ '+( ( ( pieza[2]*pieza[3] ) * ( pieza[1] ) / (unidades[i]*100) ) * precios[i] ).toFixed(4)+'</td>';
            html += '</tr>';

        });

        $("#PreeliminarPiezas").append( html );

        $("#PreeliminarConsumibles").empty();

        html = '';
        html += '<tr><th>Tipo</th><th>Insumo/Consumible</th><th>Importe</th></tr>';

        consumibles.forEach( function( consumible){

            html += '<tr>';
            html += '<td>'+consumible[0]+'</td>';
            html += '<td>'+consumible[1]+'</td>';
            html += '<td>$ '+consumible[2]+'</td>';
            html += '</tr>';

        });

        $("#PreeliminarConsumibles").append( html );
        
    });

});