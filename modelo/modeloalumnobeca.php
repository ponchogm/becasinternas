<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../config/config.php");

class ModelAlumnoBecas {
    private $pdo;
    public function __CONSTRUCT(){
        try{
            $this->pdo = new PDO("mysql:host=".HOST.";dbname=".DB, USERDB, PASSDB);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
     
    // Listado solo becacolaboración
    public function Listar($numpag){
        $CantidadMostrar=15;
        $jsonresponse = array();
        $compag         =(int)($numpag);
        $result = array();

        try{
            $respuesta = $this->contarTotal();
            $tot_reg = (int)$respuesta['total'];
            //var_dump($tot_reg);
            $reginicio = ($compag-1) * $CantidadMostrar;
            //var_dump($reginicio);

            $stm = $this->pdo->prepare("SELECT  al.id_alum, 
                                                al.rut_alum, 
                                                al.ap_pat_alum, 
                                                al.ap_mat_alum, 
                                                al.nombres_alum, 
                                                al.sexo_alum, 
                                                al.correo_alum,
                                                al.telefono_alum,
                                                al.fecha_postula,                                       
                                                al.postula_beca_alum, 
                                                al.otras_becas_alum,
                                                al.cod_carrera_alum
                                        FROM alumnos AS al
                                        WHERE al.postula_beca_alum = 'Beca de estudios' OR al.postula_beca_alum = 'Beca de almuerzo'
                                        ORDER BY al.rut_alum ASC 
                                        LIMIT ".$reginicio.",".$CantidadMostrar);

            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $archivos = array();
                $archivos[0]=null;$archivos[1]=null;
                $busq = new AlumnoBecas();
                    $busq->__SET('alumbeca_id', $r->id_alum);
                    $busq->__SET('alumbeca_rut', $r->rut_alum);
                    $busq->__SET('alumbeca_apepat', utf8_encode($r->ap_pat_alum));
                    $busq->__SET('alumbeca_apemat', utf8_encode($r->ap_mat_alum));
                    $busq->__SET('alumbeca_nombres', utf8_encode($r->nombres_alum));
                    $busq->__SET('alumbeca_sexo', $r->sexo_alum);
                    $busq->__SET('alumbeca_correo', $r->correo_alum);
                    $busq->__SET('alumbeca_fono', $r->telefono_alum);
                    $busq->__SET('alumbeca_fecha_postula', $r->fecha_postula);
                    $busq->__SET('alumbeca_postulabeca', $r->postula_beca_alum);
                    $busq->__SET('alumbeca_otrasbecas', $r->otras_becas_alum);
                    $busq->__SET('alumbeca_codigocarr', $r->cod_carrera_alum);
                
                $result[] = $busq->returnArray();
            }
            //var_dump($result);
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;
        }
        catch(Exception $e){
            die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar los Alumnos';
        }
    }
     // Armado del XLS de Excel
    public function Exporta(){
        $jsonresponse = array();

        try{
            $stm = $this->pdo->prepare("SELECT  al.rut_alum, 
                                                al.ap_pat_alum, 
                                                al.ap_mat_alum, 
                                                al.nombres_alum, 
                                                al.sexo_alum, 
                                                al.correo_alum,
                                                al.telefono_alum,
                                                al.fecha_postula,                                       
                                                al.postula_beca_alum, 
                                                al.otras_becas_alum,
                                                al.cod_carrera_alum,
                                                carr.nombre_car
                                                
                                        FROM alumnos as al, carreras as carr
                                        WHERE (al.postula_beca_alum = 'Beca de estudios' OR al.postula_beca_alum = 'Beca de almuerzo') AND  al.cod_carrera_alum = carr.codigo_car
                                        ORDER BY al.rut_alum");

            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new AlumnoBecasAlias();
                    $busq->__SET('Rut', $r->rut_alum);
                    $busq->__SET('Nombre', utf8_encode($r->nombres_alum)." ".utf8_encode($r->ap_pat_alum)." ".utf8_encode($r->ap_mat_alum));
                    $busq->__SET('Sexo', $r->sexo_alum);
                    $busq->__SET('Correo', $r->correo_alum);
                    $busq->__SET('Fono', $r->telefono_alum);
                    $busq->__SET('Fecha_postulacion', $r->fecha_postula);
                    $busq->__SET('Postula_beca', $r->postula_beca_alum);
                    $busq->__SET('Otras_becas', $r->otras_becas_alum);
                    $busq->__SET('Codigo_carrera', $r->cod_carrera_alum);
                    $busq->__SET('Nombre_carrera', $r->nombre_car);
                    
                $result[] = $busq->returnArray();
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;
        }
        catch(Exception $e){
            die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar los Estudiantes';
        }
    }
    //cuenta
    public function contarTotal(){
        $jsonresponse = array();
        try{
            $result = array();
            $rs_query = $this->pdo->prepare("SELECT COUNT(al.id_alum) AS cantidad 
                                                FROM alumnos AS al
                                                WHERE al.postula_beca_alum =  'Beca de estudios' OR al.postula_beca_alum = 'Beca de almuerzo' ");
            $rs_query->execute();
            $total_reg = $rs_query->fetch(PDO::FETCH_OBJ);
            /*var_dump($total_reg->cantidad);
            break;*/
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'correctamente';
            $jsonresponse['total'] = $total_reg->cantidad;
            return $jsonresponse;
            /*return $total_reg->cantidad;*/
        }
        catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al contar los Alumnos';
        }
    }

    // valida ingreso estudiantes a becacolaboracion
    public function Valida($rut){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT al.id_alum,
                                                al.rut_alum,
                                                al.ap_pat_alum,
                                                al.ap_mat_alum,
                                                al.nombres_alum,
                                                al.sexo_alum,
                                                al.postula_beca_alum
                                        FROM alumnos as al, carreras as carr
                                        WHERE al.rut_alum = ? AND  al.cod_carrera_alum = carr.codigo_car");
            $stm->execute(array($rut));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            if($r!= false){
                $busq = new AlumnoBecas();
                        $busq->__SET('alumbeca_id', $r->id_alum);
                        $busq->__SET('alumbeca_rut', $r->rut_alum);
                        $busq->__SET('alumbeca_apepat', $r->ap_pat_alum);
                        $busq->__SET('alumbeca_apemat', $r->ap_mat_alum);
                        $busq->__SET('alumbeca_nombres', $r->nombres_alum);
                        $busq->__SET('alumbeca_sexo', $r->sexo_alum);
                        $busq->__SET('alumbeca_postulabeca;', $r->postula_beca_alum);

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se valida alumno correctamente';
                $jsonresponse['datos'] = $busq->returnArray();
            }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'No Se obtuvo alumno correctamente';
                $jsonresponse['datos'] = null;
            }
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al validar alumno';             
        }
        return $jsonresponse;
    }
    // obtiene datos del estudiantes
    public function Obtener($rut){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT al.id_alum,
                                                al.rut_alum,
                                                al.ap_pat_alum,
                                                al.ap_mat_alum,
                                                al.nombres_alum,
                                                al.sexo_alum,
                                                al.correo_alum,
                                                al.telefono_alum,
                                                al.fecha_postula,
                                                al.postula_beca_alum,
                                                al.otras_becas_alum,
                                                al.cod_carrera_alum,
                                                carr.nombre_car
                                        FROM alumnos as al, carreras as carr
                                        WHERE al.rut_alum = ? 
                                        AND  al.cod_carrera_alum = carr.codigo_car");
            $stm->execute(array($rut));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            if($r!= false){
                /*$archivos = array();
                $archivos[0]=null;$archivos[1]=null;*/

                $busq = new AlumnoBecas();
                        $busq->__SET('alumbeca_id', $r->id_alum);
                        $busq->__SET('alumbeca_rut', $r->rut_alum);
                        $busq->__SET('alumbeca_apepat', $r->ap_pat_alum);
                        $busq->__SET('alumbeca_apemat', $r->ap_mat_alum);
                        $busq->__SET('alumbeca_nombres', $r->nombres_alum);
                        $busq->__SET('alumbeca_sexo', $r->sexo_alum);
                        $busq->__SET('alumbeca_correo', $r->correo_alum);
                        $busq->__SET('alumbeca_fono', $r->telefono_alum);

                        $fechaingreso = date_create($r->fecha_postula);
                        $busq->__SET('alumbeca_fecha_postula', date_format($fechaingreso,'d-m-Y'));
                        
                        $busq->__SET('alumbeca_postulabeca', $r->postula_beca_alum);//este es el valor que necesito rescatar al otro lado
                        $busq->__SET('alumbeca_otrasbecas', $r->otras_becas_alum);
                        $busq->__SET('alumbeca_codigocarr', $r->cod_carrera_alum);
                        $busq->__SET('alumbeca_nombrecarr', $r->nombre_car);

                        /*if($r->linkurl != null){
                            $archivos = explode(',',$r->linkurl);
                            $busq->__SET('alumbeca_archivo_url', $archivos[0]);
                            $busq->__SET('alumbeca_archivo_url2', $archivos[1]);
                        }else{*/
                            $busq->__SET('alumbeca_archivo_url', null);
                            $busq->__SET('alumbeca_archivo_url2', null);
                        /*}*/
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se obtuvo alumno correctamente';
                $jsonresponse['datos'] = $busq->returnArray();
            }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'No Se obtuvo alumno correctamente';
                $jsonresponse['datos'] = null;
            }
  
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener datos del alumno';             
        }
        return $jsonresponse;
    }
    // registra beca colaboracio, es un update a la tabla alumno
    public function Registrar(AlumnoBecas $data){
        $jsonresponse = array();
        $msg="";
        try{
            $sql = "UPDATE alumnos SET  telefono_alum = ?,
                                        correo_alum = ?,
                                        postula_beca_alum = ?,
                                        fecha_postula = now()
                    WHERE  id_alum = ? AND  rut_alum = ?";

            $stm=$this->pdo->prepare($sql)->execute(array($data->__GET('alumbeca_fono'),
                                                     $data->__GET('alumbeca_correo'),
                                                     $data->__GET('alumbeca_postulabeca'),
                                                     $data->__GET('alumbeca_id'),
                                                     $data->__GET('alumbeca_rut')
                                                        )
                                                    );
            if($stm==true){
                if($data->__GET('alumbeca_postulabeca')=='No postula'){
                    $msg="Registrado correctamente";
                    $respuestaelimina = $this->EliminarFiles($data->__GET('alumbeca_rut'));
                    /*var_dump($respuestaelimina);
                    break;*/
                }else{
                    //$msg="Continua Postulación subiendo archivos pdf";
                    $msg="Su postulación se ha ingresado correctamente, recuerde que debe imprimir su postulación";
                }
            }
            //var_dump($stm);
            //break;
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = $msg; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar la postulación';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
        }
        return $jsonresponse;
    }
    // sube archivos a carpeta adjuntos2 y guarda en tabla adjuntos
    public function RegistrarFiles(AlumnoBecas $data, $files){
        $jsonresponse = array();
        $modifica=false;
        $directorio='adjuntos2/';
        define ('RAIZ',$_SERVER['DOCUMENT_ROOT'].'/'.$directorio);
        
            $stm0 = $this->pdo->prepare("SELECT * FROM adjuntos WHERE rut_alum = ?");
            $stm0->execute(array($data->__GET('alumbeca_rut')));
            $r0 = $stm0->fetch(PDO::FETCH_OBJ);
            if($r0 !=false){
                $sql2="DELETE FROM adjuntos WHERE rut_alum = '".$data->__GET('alumbeca_rut')."'";
                $stm1 = $this->pdo->exec($sql2);
                //var_dump($stm1);
                $modifica = $stm1 > 0 ? true:false;
                $jsonresponse['modifica'] = $modifica;
            }
            $sql = "INSERT INTO  adjuntos (rut_alum, file_name, file_type, file_size, file_url, file_fecha) VALUES (?,?,?,?,?,now())";
            foreach($files as $key => $value){
                if($files[$key]) {
                    $dir=opendir(RAIZ);  //Abre directorio donde se guardaran archivos
                    $nom = ($key=="cedula") ? "cedula_":"registro_social_";  //crea nombre generico por rut y tipoarchivo
                    $destino = RAIZ.$nom.$_REQUEST['rut'].".pdf";  // crea url completa para guardar archivo
                    $origen = $_FILES[$key]["tmp_name"];  // orgine temporal del archivo
                    $urllink = $directorio.$nom.$_REQUEST['rut'].".pdf"; // url para base de datos

                    if(move_uploaded_file($origen, $destino)) {    // mueve el archivo a su destino
                        //echo "El archivo $urllink se ha almacenado en forma exitosa.<br>";
                        try{
                            $this->pdo->prepare($sql)->execute(array($data->__GET('alumbeca_rut'),
                                                                        $value["name"],
                                                                        $value["type"],
                                                                        $value["size"],
                                                                        $urllink
                                                                    )
                                                                );
                            $jsonresponse['success'] = true;
                            $jsonresponse['message'] = 'Archivos cargados correctamente';
                            
                            //$jsonresponse['messagebd'] = 'Archivos guardados correctamente';
                        } catch (PDOException $pdoException){
                             //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
                            $jsonresponse['success'] = false;
                            $jsonresponse['message'] = 'ERROR al subir Archivos'; 
                            //$jsonresponse['messagebd'] = 'Error al insertar los archivos';
                            $jsonresponse['errorQuery'] = $pdoException->getMessage();
                        }
                    } else {   
                        //echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                        $jsonresponse['success'] = false;
                        $jsonresponse['message'] = 'ERROR al subir Archivos'; 
                    }
                }
            }
            $correo = $this->EnviarEmail($data);
            $jsonresponse['email'] = $correo;
        return $jsonresponse;
    }
    // Elimina archivos del disco y de tabla adjunto cuando modifique a no postular
    public function EliminarFiles($rut){
        $jsonresponse = array();
        $elimina=false;
        $directorio='adjuntos2/';
        define ('RAIZ',$_SERVER['DOCUMENT_ROOT']);
        
            $stm0 = $this->pdo->prepare("SELECT GROUP_CONCAT( `file_url` ) as linkurl FROM adjuntos as adj WHERE adj.rut_alum = ?");
            $stm0->execute(array($rut));
            $r0 = $stm0->fetch(PDO::FETCH_OBJ);
            if($r0 !=false){
                //elimina los archivos fisico del disco si existen
                if($r0->linkurl != null){
                    $archivos = explode(',',$r0->linkurl);
                    $url1=RAIZ."/".$archivos[0];
                    $url2=RAIZ."/".$archivos[1];
                    if(file_exists($url1)){
                        /*echo "existe \n";
                        var_dump($archivos[0]);*/
                        unlink($url1);
                    }else{
                        //echo "no existe \n";
                    }
                    if(file_exists($url2)){
                        unlink($url2);
                        /*echo "existe 2 \n";
                        var_dump($archivos[1]);*/
                    }
                }
                //Elimina archivos de la base de datos , tabla adjuntos
                $sql2="DELETE FROM adjuntos WHERE rut_alum = '".$rut."'";
                $stm1 = $this->pdo->exec($sql2);
                //var_dump($stm1);
                $elimina = $stm1 > 0 ? true:false;

                $jsonresponse['existen'] = true;
                $jsonresponse['elimina'] = $elimina;
                $jsonresponse['message'] = 'eliminados'; 
            }else{
                $jsonresponse['existen'] = false;
                $jsonresponse['message'] = 'No existia archivos en disco';
            }
            
        return $jsonresponse;
    }
    // Funcion envia correos
    public function EnviarEmail(AlumnoBecas $data){
        $textosaludo="Estimada/o Estudiante";
        $textocuerpo="La Asistente Social revisará su postulación y de requerir alguna información adicional, se contactará con ud. <br><br>Los estudiantes que no sean seleccionados en una primera instancia, quedarán en la base de datos que se usará durante el 2018.<br><br> NO responda a este mensaje, es un envío automático. Si tiene alguna duda contacte a la Asistente Social de su carrera. <br><br> Atentamente.";
        $textofirma ="Subdepartamento de Servicios Estudiantiles<br>Universidad Metropolitana de Ciencias de la Educación<br>Teléfono 222412500";
        $mailcuerpo="<!DOCTYPE html><html lang='es'>
                    <head><meta charset='UTF-8'><title>mail</title></head>
                    <body><table style='font-size:16px;'>
                    <tr><td>".$textosaludo."</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td>".$textocuerpo."</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td>".$textofirma."</td></tr>
                    </table></body></html>";
        $mailremitente="bienestar.estudiantil@umce.cl";
        $mailnombreremite = "UMCE - Subdepartamento de Servicios Estudiantiles";
        $mailasunto ="Postulación Beca Colaboración";
        $subject_preferences = array(
            "input-charset" => 'utf-8',
            "output-charset" => 'utf-8',
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
        $nombre = $data->__GET('alumbeca_nombres')." ".$data->__GET('alumbeca_apepat')." ".$data->__GET('alumbeca_apemat');
        $para = $nombre.' <'.$data->__GET('alumbeca_correo').'>';

        $cabecera = "Content-type: text/html; charset=utf-8 \r\n";
        $cabecera .= "From: ".$mailnombreremite." <no-reply@umce.cl> \r\n";
        $cabecera .= "MIME-Version: 1.0 \r\n"; 
        $cabecera .= "Content-Transfer-Encoding: 8bit \r\n";
        $cabecera .= "Date: ".date("r (T)")." \r\n";
        $cabecera .= "Reply-To: no-reply@umce.cl \r\n";
        $cabecera .= "Return-path: no-reply@umce.cl\r\n";
        $cabecera .= iconv_mime_encode("Subject", $mailasunto, $subject_preferences);
        
        $enviogmail = $this->sendEmailLoginGmail($data,$mailasunto,$mailcuerpo,$mailremitente,$mailnombreremite,"");

        if($enviogmail){
            return true;
        }else{
            return mail($para,$mailasunto,$mailcuerpo,$cabecera);
        }
    }

    //Funcion envia email por login de cuenta gmail.
    function sendEmailLoginGmail(AlumnoBecas $data, $asunto,$mensaje,$mailremitente,$mailnombreremite,$bcc=''){  
        require_once('../phpmailer/class.phpmailer.php');
        require_once('../phpmailer/class.smtp.php');
            $phpmailer             = new PHPMailer(); 
            $to                    = trim($data->__GET('alumbeca_correo')); 
            $phpmailer->IsSMTP(); // telling the class to use SMTP
            //$phpmailer->SMTPDebug = 2;
            $phpmailer->SMTPAuth   = true;                  // enable SMTP authentication
            $phpmailer->Host = HOSTENVIO;
            $phpmailer->Port = HOSTPORTENVIO;
            $phpmailer->SMTPSecure = HOSTSMTPSEC; 
            $phpmailer->Username   = MAILENVIO; // Gmail account username
            $phpmailer->Password   = MAILENVIOPASS;        // Gmail account password
            if(trim($bcc) != ''){
                $phpmailer->AddBCC($bcc);
            }
            $phpmailer->SetFrom("no-reply@umce.cl",$mailnombreremite);  
            $phpmailer->AddReplyTo("no-reply@umce.cl","No responder");            
            $phpmailer->AddAddress($to, $data->__GET('alumbeca_nombres')." ".$data->__GET('alumbeca_apepat'));
            $phpmailer->Subject = $asunto;
            $phpmailer->MsgHTML($mensaje);
            $phpmailer->CharSet = 'UTF-8';
            
            if(!$phpmailer->Send()) {
               return false;
            }else{
                return true;
            }
        }

}
?>