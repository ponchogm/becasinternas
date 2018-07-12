<?php
//alumnoBecaAlias
class AlumnoBecasAlias{
    /*private $alumbeca_id;*/
    private $Rut;
    private $Nombre;
    private $Sexo;
    private $Correo;
    private $Fono;
    private $Fecha_postulacion;
    private $Postula_beca;
    private $Otras_becas;
    private $Codigo_carrera;
    private $Nombre_carrera;
    private $Cedula;
    private $Registro_social;
    /*private $alumbeca_archivo_fecha;*/
    
    public function __GET($k){
        return $this->$k;
    }

    public function __SET($k, $v){
        return $this->$k = $v;
    }

    public function returnArray(){
    	return get_object_vars($this);
    }    
}
?>