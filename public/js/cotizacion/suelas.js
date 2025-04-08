jQuery.noConflict();
jQuery(document).ready(function(){

    //Mostrando consumibles de modelo elegido
    $("#agregarConsumible").on('click', function(){

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
                                        '<td><input type="checkbox" id="todoSuelas" name="todoSuelas" checked></td>'+
                                        '<td><b>Suela</b></td>'+
                                        '<td><b>Precio</b></td>'+
                                        '<td><b>Descripción</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    delete respuesta.exito;

                    $("#suelas input").remove();

                    respuesta.suelas.forEach(function(suela){

                        html += '<tr>' +
                                    '<td><input type="checkbox" checked="true" name="suela" id="suela' + suela.id + '" class="form-control suela' + suela.id + '" value="' + suela.precio + '" data-id="' + suela.id + '" data-value="'+suela.nombre+'"></td>' +
                                    '<td>' + suela.nombre + '</td>' +
                                    '<td>' + suela.precio + '</td>' +
                                    '<td>$ ' + suela.descripcion + '</td>' +
                                '</tr>';

                    });

                    $("#contenedorSuelas").empty().append( html );

                    $("input[type=checkbox][name=suela]").on('click', function(){

                        $("input[type=checkbox][name=suela]").not(this).prop('checked', false);

                    });

                    /**Selección rapida de todo o nada */
                    $("#todoSuelas").on('click', function(){

                        if( $(this).prop('checked') ){

                            $("input[type=checkbox][name=suela]").prop('checked', true);         

                        }else{

                            $("input[type=checkbox][name=suela]").prop('checked', false);

                        }

                    });

                }else{

                    var html = '<thead>' +
                                    '<tr>' +
                                        '<td></td>'+
                                        '<td><b>Suela</b></td>'+
                                        '<td><b>Precio</b></td>'+
                                        '<td><b>Descripción</b></td>'+
                                    '</tr>'+
                                '</thead>';

                    html += '<tr><td colspan="4">Sin suelas. Presiona "Terminar" por favor.</td></tr>';

                    $("#contenedorSuelas").empty().append( html );

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
        var ganancia = parseFloat( $("#ganancia").val() );

        $("input[type=checkbox][name=suela]").each(function(){

            if( $(this).is(':checked') ){

                suelas += parseFloat( $(this).val() );

            }

        });

        console.log( total );

        document.getElementById('modalSuela').style.display = 'none';
        document.getElementById('modalSuela').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        $("#total").val( total.toFixed(4) );

        var piezas = new Array();
        var materiales = new Array();
        var costos = new Array();
        var costes = new Array();
        var consumibles = new Array();
        var suelas = new Array();
        var colores = new Array();

        $("input[name=pieza]:checked").each(function(){

            piezas.push( $(this).attr('id') );

            var valoresMaterial = $(".material" + $(this).attr('id') ).val().split(',');
            var colorMaterial = $('.colorPieza' + $(this).attr('id') ).val();

            materiales.push( valoresMaterial[2] );

            colores.push( colorMaterial );

        });

        $("input[name=costo]:checked").each(function(){

            costos.push( $(this).attr('data-id') );

        });

        $("input[name=coston]:checked").each(function(){

            costes.push( $(this).attr('data-id') );

        });

        $("input[name=consumible]:checked").each(function(){

            consumibles.push( $(this).attr('data-id') );

        });

        $("input[name=suela]:checked").each(function(){

            suelas.push( $(this).attr('data-id') );

        });

        let procesamiento;

        Swal.fire({

            title: 'Ingresa la descripción de la cotización del modelo',
            input: 'text',
            inputLabel: 'Descripción:',
            inputPlaceholder: 'Descripción breve',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
        
        }).then( (result) => {

            if( result.isConfirmed && result.value ){

                var descripcion = result.value;

                Swal.fire({

                    title: 'Ingresa el color del modelo en la cotización',
                    input: 'text',
                    inputLabel: 'Color(es):',
                    inputPlaceholder: 'Color(es)',
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',

                }).then( (resultado) => {

                    if( resultado.isConfirmed && resultado.value ){

                        var color = resultado.value;

                        if( $("#observaciones").val() === '' || $("#observaciones").val() === null ){

                            Swal.fire({

                                title: 'Ingresa las observaciones de la cotización',
                                input: 'text',
                                inputLabel: 'Observaciones:',
                                showCancelButton: true,
                                confirmButtonText: 'Guardar',
                                cancelButtonText: 'Cancelar',

                            }).then( (res)=>{

                                var observaciones = res.value;

                                if( res.isConfirmed && res.value ){

                                    Swal.fire({

                                        title: 'Registrando Cotización',
                                        html: 'Un momento por favor: <b></b>',
                                        timer: 9975,
                                        allowOutsideClick: false,
                                        didOpen: ()=>{
                            
                                            Swal.showLoading();
                                            const b = Swal.getHtmlContainer().querySelector('b');
                                            procesamiento = setInterval(()=>{
                            
                                                b.textContent = Swal.getTimerLeft();
                            
                                            }, 100);
                            
                                            $.ajax({
                            
                                                type: 'POST',
                                                url: '/cotizacion/agregar',
                                                data:{
                            
                                                    'cliente' : $("#idCliente").val(),
                                                    'modelo' : $("#modelo").val(),
                                                    'total' : $("#total").val(),
                                                    'piezas' : piezas,
                                                    'materiales' : materiales,
                                                    'costos' : costos,
                                                    'costes' : costes,
                                                    'consumibles' : consumibles,
                                                    'suelas' : suelas,
                                                    'colores' : colores,
                                                    'observaciones' : observaciones,
                                                    'descripcion' : descripcion,
                                                    'color' : color,
                            
                                                },
                                                dataType: 'json',
                                                encode: true
                            
                                            }).done(function(respuesta){
                            
                                                if( respuesta.exito ){
                            
                                                    Swal.fire({
                            
                                                        icon: 'success',
                                                        title: 'Cotización Registrada',
                                                        allowOutsideClick: false,
                                                        showConfirmButton: true
                            
                                                    }).then((resultado)=>{
                            
                                                        if( resultado.isConfirmed ){
                            
                                                            window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();
                            
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
                            
                                                            window.location.href = '/cotizador/cliente/'+$("#idCliente").val();
                            
                                                        }
                            
                                                    });
                            
                                                }
                            
                                            });
                            
                                        },
                                        willClose: ()=>{
                            
                                            clearInterval(procesamiento);
                            
                                        }
                            
                                    }).then((resultado)=>{
                            
                                        if( resultado.dismiss == Swal.DismissReason.timer ){
                            
                                            Swal.fire({
                            
                                                icon: 'warning',
                                                title: 'Hubo un inconveniente. Trata de nuevo.',
                                                allowOutsideClick: false,
                                                showConfirmButton: true
                            
                                            }).then((resultado)=>{
                            
                                                if( resultado.isConfirmed ){
                            
                                                    window.location.href = '/cotizador/cliente/'+$("#idCliente").val();
                            
                                                }
                            
                                            });
                            
                                        }
                            
                                    });

                                }

                            });

                        }else{

                            Swal.fire({

                                title: 'Registrando Cotización',
                                html: 'Un momento por favor: <b></b>',
                                timer: 9975,
                                allowOutsideClick: false,
                                didOpen: ()=>{
                    
                                    Swal.showLoading();
                                    const b = Swal.getHtmlContainer().querySelector('b');
                                    procesamiento = setInterval(()=>{
                    
                                        b.textContent = Swal.getTimerLeft();
                    
                                    }, 100);
                    
                                    $.ajax({
                    
                                        type: 'POST',
                                        url: '/cotizacion/agregar',
                                        data:{
                    
                                            'cliente' : $("#idCliente").val(),
                                            'modelo' : $("#modelo").val(),
                                            'total' : $("#total").val(),
                                            'piezas' : piezas,
                                            'materiales' : materiales,
                                            'costos' : costos,
                                            'costes' : costes,
                                            'consumibles' : consumibles,
                                            'suelas' : suelas,
                                            'colores' : colores,
                                            'observaciones' : $("#observaciones").val(),
                                            'descripcion' : descripcion,
                                            'color' : color,
                    
                                        },
                                        dataType: 'json',
                                        encode: true
                    
                                    }).done(function(respuesta){
                    
                                        if( respuesta.exito ){
                    
                                            Swal.fire({
                    
                                                icon: 'success',
                                                title: 'Cotización Registrada',
                                                allowOutsideClick: false,
                                                showConfirmButton: true
                    
                                            }).then((resultado)=>{
                    
                                                if( resultado.isConfirmed ){
                    
                                                    window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();
                    
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
                    
                                                    window.location.href = '/cotizador/cliente/'+$("#idCliente").val();
                    
                                                }
                    
                                            });
                    
                                        }
                    
                                    });
                    
                                },
                                willClose: ()=>{
                    
                                    clearInterval(procesamiento);
                    
                                }
                    
                            }).then((resultado)=>{
                    
                                if( resultado.dismiss == Swal.DismissReason.timer ){
                    
                                    Swal.fire({
                    
                                        icon: 'warning',
                                        title: 'Hubo un inconveniente. Trata de nuevo.',
                                        allowOutsideClick: false,
                                        showConfirmButton: true
                    
                                    }).then((resultado)=>{
                    
                                        if( resultado.isConfirmed ){
                    
                                            window.location.href = '/cotizador/cliente/'+$("#idCliente").val();
                    
                                        }
                    
                                    });
                    
                                }
                    
                            });

                        }

                    }

                });

            }

        });

    });

    $("#cancelarSuela").on('click', function(){

        document.getElementById('modalSuela').style.display = 'none';
        document.getElementById('modalSuela').classList.remove('show');
        document.querySelectorAll('.modal-backdrop').forEach( el => el.remove);

        document.getElementById('modalConsumible').style.display = 'block';
        document.getElementById('modalConsumible').classList.add('show');

    });

});