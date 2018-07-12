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

  <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> -->

    <link href="../img/templates/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="js/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <script src="js/funcionvalida.js"></script>

    <!-- styles -->
    <style type="text/css">
      span{color:#f00;}
      .form-signin {
        text-align: center;
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
    </style>
  </head>
  <body>
    <?php include "cabecera.php"; ?>
    <div class="container">
      <form name="formlogin" id="formlogin" class="form-signin" method="post" >
        <input type="hidden" name="Accion" id ="Accion" value="valida">
        <h2 class="form-signin-heading">Ingrese sus datos</h2>
        <input type="text" id="rut" name="rut" class="input-block-level" placeholder="Rut">
        <span class="help-block hidden" id="msgerror">Usuario no existe</span>
        <button class="btn btn-small btn-primary" type="button" id="entrar" name="entrar" >Entrar al sistema</button>
      </form>
    </div>
    <br>
    <div class="container" style="text-align:center">
      Escriba los datos como en el siguiente ejemplo:
      <h6><p><strong>Rut: 12345678-9</strong></p></h6>
      <hr>
    </div> 
    <footer class="footer">
      <div class="container" style="text-align:center">
        <p>&copy; Informática - UMCE 2018</p>
      </div>
    </footer>
  </body>
  </html>
