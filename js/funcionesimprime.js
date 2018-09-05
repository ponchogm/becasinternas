
    $(document).ready(function(){
       
         function imprimePostulacion(){
            console.log(rut0);
            var datay = {
                        "rut": rut0,
                        "Accion":"obtener"
                        };
            $.ajax({
                data: datay, 
                type: "POST",
                dataType: "json", 
                url: "controllers/controlalumnobeca.php",
            })
            .done(function(data,textStatus,jqXHR ) {
                 if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                   }
                    console.log(data.datos.alumbeca_rut);
                    console.log(data.datos.alumbeca_nombres+" "+data.datos.alumbeca_apepat+" "+data.datos.alumbeca_apemat);
                    //$('#msg-form').html("<b>Rut: </b>"+data.datos.alumbeca_rut);
                    //$('#legend1').hide(); //oculto mediante id
                    $('#rut').html("<b>Rut: </b>"+data.datos.alumbeca_rut);
                    $('#nombre').html("<b>Nombre: </b>"+data.datos.alumbeca_nombres+" "+data.datos.alumbeca_apepat+" "+data.datos.alumbeca_apemat);
                    $('#fecha').html("<b>Fecha de Postulación: </b>"+data.datos.alumbeca_fecha_postula);
                    $('#correo').html("<b>Correo: </b>"+data.datos.alumbeca_correo);
                    $('#telefono').html("<b>Teléfono: </b>"+data.datos.alumbeca_fono);
                    //$('#carrera').html("<b>Carrera: </b>"+data.datos.alumbeca_nombrecarr);
                    $('#carrera').html("<b>Carrera: </b>"+data.datos.alumbeca_codigocarr);
                    $('#beca').html("<b>Beca a la que postula: </b>"+data.datos.alumbeca_postulabeca);
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });                        
        }
        //funcion para validar campos del formulario
   
        imprimePostulacion();
    });
