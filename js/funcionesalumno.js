     function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ';';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '";';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var f = new Date();
    var fileName = f.getDate() + "-" + (f.getMonth() +1) + "-" + f.getFullYear()+" ";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/xls;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
     var getlista = function (pag){
            gettotal(pag);
                    var datax = {
                        "numpag":pag,
                        "Accion":"listar"
                    };
                    $.ajax({
                        data: datax, 
                        type: "GET",
                        dataType: "json", 
                        url: "controllers/controlalumnobeca.php",
                    })
                    .done(function( data, textStatus, jqXHR ) {
                       
                        $("#listaalumnos").html("");
                        if ( console && console.log ) {
                            console.log( " data success : "+ data.success 
                                        + " \n data msg : "+ data.message 
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                        for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                //console.log('id: '+data.datos[i].serv_id + ' nombre: '+data.datos[i].serv_nombre);
                                fila = '<tr><td>'+ data.datos[i].alumbeca_rut +'</td>';
                                fila += '<td>' + data.datos[i].alumbeca_nombres + ' '+ data.datos[i].alumbeca_apepat + ' ' + data.datos[i].alumbeca_apemat +'</td>';
                                fila += '<td>'+ data.datos[i].alumbeca_codigocarr +'</td>';
                                fila += '<td>'+ data.datos[i].alumbeca_fecha_postula +'</td>';
                                fila += '<td>'+ data.datos[i].alumbeca_postulabeca +'</td>';
                                
                            $("#listaalumnos").append(fila);
                        }
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( " La solicitud getlista ha fallado,  textStatus : " +  textStatus 
                                        + " \n errorThrown : "+ errorThrown
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                    });
    }

       var getexcel = function (){
                    var datax = {

                        "Accion":"exporta"
                    };
                    $.ajax({
                        data: datax, 
                        type: "GET",
                        dataType: "json", 
                        url: "controllers/controlalumnobeca.php",
                    })
                    .done(function( data, textStatus, jqXHR ) {
                       
                        /*$("#listaalumnos").html("");*/
                        if ( console && console.log ) {
                            console.log( " data success : "+ data.success 
                                        + " \n data msg : "+ data.message 
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                        JSONToCSVConvertor(data.datos, "Informe Becas Internas", true);
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( " La solicitud getlista ha fallado,  textStatus : " +  textStatus 
                                        + " \n errorThrown : "+ errorThrown
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                    });
    }
                
    var gettotal = function (pag){
            var cantidadMostrar = 10;  // total de numeros a mostrar de paginas 
            var registroPorPagina = 15; //total registro por pagina, debe coincidir con el modelo.listar
            var compag = pag;
            console.log("pagina : "+compag);
                    var datax = {
                        "Accion":"contar"
                    }
                    $.ajax({
                        data: datax, 
                        type: "GET",
                        dataType: "json", 
                        url: "controllers/controlalumnobeca.php",
                    })
                    .done(function( data, textStatus, jqXHR ) {
                       $("#paginador").html("");
                        if ( console && console.log ) {
                            console.log( " data success gettotal : "+ data.success 
                                        + " \n data msg : "+ data.message 
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                        if(data.total > registroPorPagina){
                                console.log("Total de registros :"+ data.total);
                            // calcula total numero de paginas segun totalregistro dividos por numero de reg. por pagina.
                            totalPag = Math.ceil(data.total/registroPorPagina);
                                console.log("total paginas : "+totalPag);

                            //calcula incremento para boton siguiente
                            IncrimentNum =((compag +1)<=totalPag) ? (compag +1) : 1;
                                console.log("incremento: "+IncrimentNum);
                            //calcula decremento  para boton anterior
                            DecrementNum =(compag -1) < 1 ?  1 : (compag -1);
                                console.log("decremento: "+DecrementNum);
                            if(totalPag<cantidadMostrar){
                                cantidadMostrar=totalPag;
                            }
                            // valida primera pagina y deshabilita anterior
                            if(pag == 1 ){
                                pagina = "<li class='disabled'><a href='#'><span aria-hidden='true'>&laquo;</span></a></li>";
                            }else{
                                pagina = "<li><a href='#' onclick='getlista(" + DecrementNum + ")'><span aria-hidden='true'>&laquo;</span></a></li>";
                            }
                            console.log("calculo ceil : " + (Math.ceil(cantidadMostrar/2)-1));
                            //valida y calcula desde hasta para paginador segun pagina actual
                            desde=compag-(Math.ceil(cantidadMostrar/2)-1); //42 - 4   => ((10/2)-1) 
                            hasta=compag+(Math.ceil(cantidadMostrar/2)); //42 + 5   => ((10/2)-1)
                            console.log("desde ceil: "+desde);
                            console.log("hasta ceil: "+hasta);                       
                            //valida desde si menor a 1 y hasta menor a cantidadMostrar (siempre mostrar diez numeros de paginas)
                            desde = (desde < 1) ? 1 : desde;
                            hasta = (hasta < cantidadMostrar) ? cantidadMostrar : hasta;

                            console.log("desde : " + desde);
                            console.log("hasta : " + hasta);

                            // valida y calcula ultimas 10 paginas del paginador
                            desde = (hasta > totalPag) ? totalPag - (cantidadMostrar-1) : desde;
                            hasta = (hasta > totalPag) ? totalPag : hasta;
                            
                            console.log("desde fin : " + desde);
                            console.log("hasta fin : " + hasta);
                            // dibuja  numeros de paginas en paginador
                            for(i=desde; i<= hasta; i++){
                                //Se valida la paginacion total de registros
                                if(i <= totalPag){
                                    //Validamos la pag activo
                                    if(i==compag){
                                        pagina+="<li class='active'><a href='#'>"+i+"</a></li>";
                                    }else {
                                        pagina += "<li><a href='#' onclick='getlista("+i+")'>"+i+"</a></li>";
                                    }
                                }
                            }
                            console.log(pagina);
                            // valida ultima pagina y deshabilita siguiente
                            if(pag == totalPag ){
                                pagina += "<li class='disabled'><a href='#'><span aria-hidden='true'>&raquo;</span></a></li>";
                            }else{
                                pagina+= "<li><a href='#' onclick='getlista(" + IncrimentNum + ")'><span aria-hidden='true'>&raquo;</span></a></li>";
                            }
                             $("#paginador").html("");
                             $("#paginador").append(pagina);
                         }
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( " La solicitud getlista ha fallado,  textStatus : " +  textStatus 
                                        + " \n errorThrown : "+ errorThrown
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                    });
                }
    
    var buscaRut = function (rut){

                    var datax = {
                        "rut":rut,
                        "Accion":"obtener"
                    };
                    $.ajax({
                        data: datax, 
                        type: "GET",
                        dataType: "json", 
                        url: "controllers/controlalumnobeca.php",
                    })
                    .done(function( data, textStatus, jqXHR ) {
                       
                        $("#listaalumnos").html("");
                        if ( console && console.log ) {
                            console.log( " buscaRut data success : "+ data.success 
                                        + " \n data msg : "+ data.message 
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                        if (data.datos != null){
        
                                fila = '<tr><td>'+ data.datos.alumbeca_rut +'</td>';
                                fila += '<td>' + data.datos.alumbeca_nombres + ' '+ data.datos.alumbeca_apepat + ' ' + data.datos.alumbeca_apemat +'</td>';
                                fila += '<td>'+ data.datos.alumbeca_codigocarr +'</td>';
                                fila += '<td>'+ data.datos.alumbeca_fecha_postula +'</td>';
                                fila += '<td>'+ data.datos.alumbeca_postulabeca +'</td>';    

                            $("#listaalumnos").append(fila);
                        }else{
                            fila = '<tr><td colspan="3">El rut ingresado no se encuentra en la base de datos ó está mal escrito</td></tr>';
                            $("#listaalumnos").append(fila);
                        }
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( " La solicitud getlista ha fallado,  textStatus : " +  textStatus 
                                        + " \n errorThrown : "+ errorThrown
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                    });
    }
    $(document).ready(function(){
        getlista(1);
        
        $("#filtrar").on("keydown",function(e){
            if(e.which == 13){      
                e.preventDefault();
                numRut = $("#filtrar").val().trim();
                if(numRut==''){
                    getlista(1);
                }else{
                    buscaRut(numRut);
                }    
            }
            if(e.which == 8){ 
                getlista(1);     
            }             
        });

        $('button').click(function(){
        
            getexcel();
        });

    });
