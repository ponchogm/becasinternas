<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/entidadalumnobeca.php';
require_once '../modelo/modeloalumnobeca.php';
require_once '../modelo/entidadalumnobecaalias.php';

// Logica
$alum = new AlumnoBecas();
$modelAlum = new ModelAlumnoBecas();

if(isset($_REQUEST['Accion'])){
    switch($_REQUEST['Accion']){
        case 'valida': //OK
            $jsondata = $modelAlum->Valida($_REQUEST['rut']);
                $_SESSION["autentica"] = "YEP";
                $_SESSION["id"] = $jsondata["datos"]["alumbeca_id"];
                $_SESSION["rut"] = $jsondata["datos"]["alumbeca_rut"];
                $_SESSION["apepat"] = $jsondata["datos"]["alumbeca_apepat"];
                $_SESSION["apemat"] = $jsondata["datos"]["alumbeca_apemat"];
                $_SESSION["nom"] = $jsondata["datos"]["alumbeca_nombres"];
                $_SESSION["sex"] = $jsondata["datos"]["alumbeca_sexo"];
                $_SESSION['instante']   = time();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);  
            break;
        
        case 'registrar': //OK
            $alum->__SET('alumbeca_id',         $_REQUEST['id']);
            $alum->__SET('alumbeca_rut',        $_REQUEST['rut']);
            $alum->__SET('alumbeca_postulabeca', $_REQUEST['becainterna']);
            $alum->__SET('alumbeca_correo',     $_REQUEST['correo']);
            $alum->__SET('alumbeca_fono',       $_REQUEST['telefono']);
            $jsondata = $modelAlum->Registrar($alum);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
        
        case 'obtener': //OK
            $jsondata = $modelAlum->Obtener($_REQUEST['rut']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar': //OK
            $jsondata = $modelAlum->Listar($_REQUEST['numpag']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
            
        case 'contar': //OK
            $jsondata = $modelAlum->contarTotal();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'exporta': //OK
            $jsondata = $modelAlum->Exporta();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
            /*
        case 'registrarfile': //OK y envio EMAIL
            $alum->__SET('alumbeca_id',         $_REQUEST['id']);
            $alum->__SET('alumbeca_rut',        $_REQUEST['rut']);
            $alum->__SET('alumbeca_nombres',    $_SESSION["nom"]);
            $alum->__SET('alumbeca_apemat',     $_SESSION["apepat"]);
            $alum->__SET('alumbeca_apepat',     $_SESSION["apemat"]);
            $alum->__SET('alumbeca_correo',     $_REQUEST['email']);
            $jsondata = $modelAlum->RegistrarFiles($alum,$_FILES);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminafile': //OK y envio EMAIL
            $alum->__SET('alumbeca_rut',        $_REQUEST['rut']);
            $jsondata = $modelAlum->EliminarFiles($_REQUEST['rut']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break; 
            */ 
    }
}

?>