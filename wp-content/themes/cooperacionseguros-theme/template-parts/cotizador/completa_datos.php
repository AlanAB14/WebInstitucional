<?php 
    header("Content-type: application/json; charset=utf-8");
   
    $datos = json_decode(file_get_contents("php://input"), true);
    
    $action=$datos['action'];
    
    include_once "../../api/api.php";
    $token = encrypt_decrypt('decrypt', coopseg_get_local_token());
    $category=1;
    if($datos['action']=='buscarModelos'){
        $idMarca=$datos['idMarca'];
        $resultModelos = coopseg_vehicles_get_models($token, $category ,$idMarca);
        $Modelos = json_decode($resultModelos, true);
        $miRespuesta=array("respuesta"=>"ok", "datos"=>$datos['idMarca'], "modelos"=>$Modelos);
        echo json_encode($miRespuesta);
    }elseif($datos['action']=='buscarAños'){
        $resultAnios = coopseg_vehicles_get_years($token, $datos['idModelo']);
        $Anios = json_decode($resultAnios, true);
        $miRespuesta=array("respuesta"=>"ok", "datos"=>$datos['idModelo'], "anios"=>$Anios);
        echo json_encode($miRespuesta);
    }elseif($datos['action']=='buscarVersiones'){
        $resultVersiones = coopseg_vehicles_get_versions($token, $datos['idModelo'], $datos['idAnio']);
        $Versiones = json_decode($resultVersiones, true);
        $miRespuesta=array("respuesta"=>"ok", "versiones"=>$Versiones);
        echo json_encode($miRespuesta);
    }elseif($datos['action']=='buscarGNC'){
        $resultGNC = coopseg_vehicles_get_accesories($token, $datos['query']);
        $GNC = json_decode($resultGNC, true);
        $miRespuesta=array("respuesta"=>"ok", "gnc"=>$GNC);
        echo json_encode($miRespuesta);
    }elseif($datos['action']=='buscarLocalidades'){
        $resultLocalidades = coopseg_places_get_places_db('', 40, 1, 0);
        $Localidades = json_decode($resultLocalidades, true);
        $miRespuesta=array("respuesta"=>"ok", "localidades"=>$Localidades);
        echo json_encode($miRespuesta);
    }elseif($datos['action']=="buscarMarcas"){
        $nuevoData = coopseg_vehicles_get_brands($token, 1);
        $Marcas = json_decode($nuevoData, true);
        $miRespuesta=array("respuesta"=>"ok", "marcas"=>$Marcas);
        echo json_encode($miRespuesta);
    }elseif($datos['action']=='buscarPrecio'){
        $resultPrecio = coopseg_vehicles_get_quotes($token, $datos['anio'], $datos['codia'], $datos['codval'], $datos['zipCode'], $datos['gncDecimal']);
        $Precio = json_decode($resultPrecio, true);
        $miRespuesta=array("respuesta"=>"ok", "precio"=>$Precio);
        echo json_encode($miRespuesta);
    }elseif($datos['action']=='buscaDNI'){
        $miRespuesta='ok';
        echo json_encode($miRespuesta);
    }

    
?>

