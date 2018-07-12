    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtRut = document.getElementById('rut').value;
            //var txtPassword = document.getElementById('password').value;
                // campo obligatorio
                if(txtRut == null || txtRut.length == 0 || /^\s+$/.test(txtRut)){
                    alert('ERROR: El campo rut no debe ir vacío o con espacios en blanco');
                    document.getElementById('rut').focus();
                    return false;
                }
                return true;
        }

        // implementacion button valida alumno
        $("#entrar").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formlogin").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });*/
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controlalumnobeca.php", 
                })
                .done(function( data, textStatus, jqXHR ) {
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                    if(data.datos != null ){
                        /*window.location.href="becacolaboracion.php";*/
                        window.location.href="becainterna.php";
                    }else{
                        $('#msgerror').removeClass("hidden");
                        $('#msgerror').html("Alumno no existe");
                    }

                   
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
        });
    });
