<?php
include ('seguridad3.php');
// Se crea formulario para postular a beca colaboracion 2018, basado en el formulario becas.php, fsegovia : 19122017
//$rut="18486804-0";
  $id=$_SESSION["id"];
  $rut=$_SESSION["rut"];
  $nombre = $_SESSION["nom"]." ".$_SESSION["apepat"]." ".$_SESSION["apemat"];
  $sexo=$_SESSION["sex"];
?>
<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Beneficios 2018 - Universidad Metropolitana de Ciencias de la Educación</title>
  <meta name="description" content="umce beneficios">
  <meta name="author" content="umce">
  <meta name="robots" content="noindex"/>
  <meta name="robots" content="nofollow">  

    <link href="img/templates/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="js/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <script type="text/javascript">
        var rut0='<?php echo $_SESSION["rut"]; ?>';
    </script>
    <script src="js/funcionesimprime.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){ 
         document.getElementById("logo").style.display = 'none'; 
      });
      function printDiv(imprimir) {
       /*document.getElementById('legend1').style.display = 'none'; 
       document.getElementById('msg-form').style.display = 'none';
       document.getElementById('legend2').style.display = 'block';*/
       document.getElementById("logo").style.display = 'block';
       var contenido= document.getElementById(imprimir).innerHTML;
       var contenidoOriginal= document.body.innerHTML;
       document.body.innerHTML = contenido;

       window.print();

       document.body.innerHTML = contenidoOriginal;
       document.getElementById("logo").style.display = 'none';
      }
    </script>

  </head>

  <body>
<?php include "cabecera.php"; ?>
    <!-- <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      h4.page-header{
        display: block;
        width: 100%;
        padding: 0;
        margin-bottom: 20px;
        font-size: 21px;
        line-height: 40px;
        color: #333;
        border: 0;
        border-bottom: 1px solid #E5E5E5;
        font-weight: normal;
      }
    </style>   -->
</head>
<body>
	<div class="container" id="container">

      <!-- Cabecera del formulario -->
      <div id="form">
        <div id="logo"><center><img src="img/templates/logo_umce_2018_290.jpg" class="img-rounded"></center></div>
      <p>
      <p>
      <div class="row-fluid">
      </br>
        <div span style="color:red" id="msg-form"><center><h7><strong>Tu postulación NO HA CONCLUIDO.</strong></h7></center></div>
        <p>
        <div id="legend1">
        <p>
        <p>
          <ul>
        Para terminar tu postulación debes incluír la siguiente documentación:
        <li>Fotocopia de tu cédula de identidad vigente</li>
        
        <li>Cartola de Registro Social de Hogares.</li>
        
        </ul>
      </div>
      <div id="legend2" style='display:none;'><center><h7><strong>Datos de Postulación</strong></h7></center></div>
      <p>
      <p>
      <p>
        <table class="table table-striped table-bordered">
          <tr>
            <td><p id="rut"></p></td>
            <td><p id="nombre"></p></td> 
            <td><p id="fecha"></p></td> 
          </tr>
          <tr>
            <td colspan="2"><p id="correo"></p></td> 
            <td><p id="telefono"></p></td> 
          </tr>
          <tr>
            <td colspan="3"><p id="carrera"></p></td> 
          </tr>
          <tr>
            <td colspan="3"><p id="beca"></p></td>
          </tr>
        </table>
      </br>
    </div>
	</div>
      <center><button type='submit' class='btn btn-primary' onclick="printDiv('form')">Imprimir</button></center>
<p>
<p>
      <div class="row-fluid">
        <div class="span2">&nbsp;</div>
        <div class="span8" style="text-align:center"><a href="salir3.php">Salir</a></div>
        <div class="span2">&nbsp;</div>
      </div>
      
	</div>
</body>
</html>