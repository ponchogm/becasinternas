<?php
//alumnoBeca
class AlumnoBecas{
    private $alumbeca_id;
    private $alumbeca_rut;
    private $alumbeca_apepat;
    private $alumbeca_apemat;
    private $alumbeca_nombres;
    private $alumbeca_sexo;
    private $alumbeca_correo;
    private $alumbeca_fono;
    private $alumbeca_fecha_postula;
    private $alumbeca_postulabeca;
    private $alumbeca_otrasbecas;
    private $alumbeca_codigocarr;
    private $alumbeca_nombrecarr;
    private $alumbeca_archivo_url;
    private $alumbeca_archivo_url2;
    private $alumbeca_archivo_fecha;
    
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