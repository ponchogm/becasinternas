    function deshabilitabotones(){
        document.getElementById('enviar').style.display = 'none';
        document.getElementById('modificar').style.display = 'none';
        document.getElementById('reenviar').style.display = 'none';
    }
    function limpiaform(){
        $("#rut").val("");
        $("#becacolaboracion").val("");
        $("#correo").val("");
        $("#telefono").val("+569");
    }        
    function habilitaform(){
        $("#becacolaboracion").prop( "disabled", false );
        $("#correo").prop( "disabled", false );
        $("#telefono").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#becacolaboracion").prop( "disabled", true );
        $("#correo").prop( "disabled", true );
        $("#telefono").prop( "disabled", true );
    }
    function capaNoPostula(){
        $('#datosalumno').hide();
        $('#subearchivos').hide();
        $('#descripcion').hide();
        $('#botonenviar').hide();
        $('#mensajefinal').show();
        $('#salir').html("<a href='salir.php' class='btn btn-default' role='button' >Salir</a>");
    }
    function capaPostula(){
        $('#mensajefinal').hide();
        $('#descripcion').show();
        $('#datosalumno').show();
        $('#subearchivos').show();
        $('#botonenviar').show();
    }

    $(document).ready(function(){
        function validaModificaPostula(){
            //console.log(rut0);
            var datay = {"rut": rut0,
                        "Accion":"obtener"
                        };
            $.ajax({
                data: datay, 
                type: "POST",
                dataType: "json", 
                url: "controllers/controlalumnobeca.php",
            })
            .done(function(data,textStatus,jqXHR ) {
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                if(data.datos.alumbeca_otrasbecas == "No postula"){
                    capaNoPostula();
                }else{
                    capaPostula();
                    $('#datosalumno').html("");
                    tabla = '<tr><td> Rut: ' + data.datos.alumbeca_rut;
                    tabla += '</td><td>Nombre: '+data.datos.alumbeca_nombres + ' ' + data.datos.alumbeca_apepat + ' ' + data.datos.alumbeca_apemat;
                    tabla += '</td><td>Fecha de postulación: ' + data.datos.alumbeca_fecha_postula+'</td></tr>';
                    tabla += '<tr><td colspan="2">Correo: ' + data.datos.alumbeca_correo;
                    tabla += '</td><td>Teléfono: ' + data.datos.alumbeca_fono+'</td></tr>';
                    tabla += '<tr><td colspan="3">Carrera: ' + data.datos.alumbeca_nombrecarr + '</td></tr>';
                    tabla += '<tr><td colspan="3">Beca a la que postula: <b>' + data.datos.alumbeca_otrasbecas + '</b></td></tr>';
                    $('#datosalumno').append(tabla);
                    $("#email").val(data.datos.alumbeca_correo);
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
        //funcion para validar campos del formulario
        function validarFormulario(){
            var fileCedula = document.getElementById('cedula').value;
            var fileRegistro = document.getElementById('registrosocial').value;

            var extCedula = (fileCedula.substring(fileCedula.lastIndexOf("."))).toLowerCase();
            var extRegistro = (fileRegistro.substring(fileRegistro.lastIndexOf("."))).toLowerCase();

            var msgSelecionar = "ERROR: Se debe seleccionar un archivo pdf para completar su postulación";
            var msgExtension = "ERROR: Solo se pueden subir archivos con extensión PDF";
            var msgFileSize = "ERROR: El archivo no debe tener un tamaño superior a 2MB";
                //Test campo obligatorio
                if(fileCedula == ""){
                    alert(msgSelecionar);
                    document.getElementById('cedula').focus();
                    return false;
                }else {
                    var sizeCedula = document.getElementById('cedula').files[0].size;
                    if(sizeCedula > 2097152){
                        alert(msgFileSize);
                        document.getElementById('cedula').focus();
                        return false;
                    }
                }

                if(fileRegistro == "" ){
                    alert(msgSelecionar);
                    document.getElementById('registrosocial').focus();
                    return false;
                }else{
                    var sizeRegistro = document.getElementById('registrosocial').files[0].size;
                    if(sizeRegistro > 2097152){
                        alert(msgFileSize);
                        document.getElementById('registrosocial').focus();
                        return false;
                    }
                }

                if(extCedula != ".pdf"){
                    alert(msgExtension);
                    document.getElementById('cedula').focus();
                    return false;
                }else if(extRegistro != ".pdf"){
                    alert(msgExtension);
                    document.getElementById('registrosocial').focus();
                    return false;
                }
                return true;
            }         

        // implementacion boton para guardar el centro de costo
        $("#enviar").click(function(e){
            var $btn = $('#btn');
            var $data = $('.data');
            var $loader = $('.loader');

            e.preventDefault();
            $("#Accion").val("registrarfile");
            if(validarFormulario()==true){
                var formData = new FormData(document.getElementById("formularioarchivos"));
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json",
                    url: "controllers/controlalumnobeca.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
                        $('#ModalCargando').modal('show');
                        $('#ModalCargando').on('shown.bs.modal', function () {
                            $loader.show();
                        });
                    }
                })
                .done(function( data, textStatus, jqXHR ) {
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                    $('#ModalCargando').modal('hide');
                    $('#ModalCargando').on('hidden.bs.modal', function () {
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();
                        });
                    });
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
        $("#myModalLittle").on('hidden.bs.modal', function () {
            capaNoPostula();
        });
        
        //Cambia boton y habilita form para actualizar
        $("#modificar").click(function(e){
            e.preventDefault();
            habilitaform();
            deshabilitabotones();
            $('#enviar').text('Reingresar Postulación');  
            $('#enviar').show();
        });
        validaModificaPostula();
    });
