
<?php
    $urlImg="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador_precios.css">

<?php  include 'barra_ingreso.php' ;?>
<?php  include 'menu_bar.php' ;?>
<?php

    if(isset($_COOKIE['datosVehiculo'])){
        $datosVehiculo = stripslashes($_COOKIE['datosVehiculo']);;
        $datosVehiculo = json_decode($datosVehiculo, true);
        
        $idMarca = $datosVehiculo['idMarca'];
        $marca = $datosVehiculo['marca'];
        $idModelo = $datosVehiculo['idModelo'];
        $modelo = $datosVehiculo['modelo'];
        $anio = $datosVehiculo['agno'];
        $idVersion = $datosVehiculo['idVersion'];
        $arrayVersion = explode(",", $idVersion);
        $codval = $arrayVersion[0];
        $codia = $arrayVersion[1];
        $zipCode = $datosVehiculo['zipCode'];
        $gncDecimal = $datosVehiculo['idGnc'];
        $version = $datosVehiculo['version'];
        $gncOpcion = $datosVehiculo['gnc'];
        $localidad = $datosVehiculo['localidad'];

        $leyenda = $marca." ".$modelo." DE ".$anio;
        
        $seleccionLocalidad = explode(",", $localidad);
        
        $userZipCode = $seleccionLocalidad[2];
        $userCity = $seleccionLocalidad[0];
        $userState = $seleccionLocalidad[1];           
    }
    if(isset($_COOKIE['datosPersonales'])){
        $datosPersonales = stripslashes($_COOKIE['datosPersonales']);;
        $datosPersonales = json_decode($datosPersonales, true);
        $nombre = $datosPersonales['nombre'];
        $mail = $datosPersonales['mail'];
        $telefono = $datosPersonales['telefono'];
        
    }

    $data = [
        'userName' => $nombre,
        'userEmail' => $mail,
        'userZip' => $userZipCode,
        'userIdCity' => $zipCode,
        'userCity' => $userCity,
        'userState' => $userState,
        'vehicleBrand' => $marca,
        'vehicleBrandId' => $idMarca,
        'vehicleModel' => $modelo,
        'vehicleModelId' => $idModelo,
        'vehicleGnc' => $gncOpcion,
        'vehicleGncId' => $gncDecimal,
        'vehicleGncValue' => $gncDecimal,
        'vehicleYear' => $anio,
        'codInfoAuto' => $codia,
        'codval' => $codval,
        'vehicleValue' => 0,
        'vehicleVersion' => $version,
    ];
    
    $guid = $_REQUEST['guid'] ?? get_query_var('guid');
    $quote = Quote::create_quote("seguro-de-autos-y-pick-ups", $data);
    
    
    $rates = Quote::get_vehicle_rates($quote);
    
    if(!$rates){
    ?>
        <div class="mensaje">
            <div class="sinCotizacion">
                    Lo sentimos, en este momento no tenemos coberturas para tu <span><?php echo $leyenda ;?></span>
                    . Si tenés alguna duda, puedes ponerte en contacto con nosotros.
            </div>   
        </div>
       
    <?php 
    }else{
      $file = 'plans-cars.json';
      ['assistances' => $assistances, 'coverages' => $coverages, 'benefits' => $benefits, 'plans' => $plansData] = json_decode(file_get_contents(get_template_directory() . '/data/' . $file), true);
      ['ap' => $ap, 'plans' => $plans, 'recommended' => $recommended, 'full' => $full] = $rates;

      $priceBasic = number_format(($plans->{$recommended['basic']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
      $priceMedium = number_format(($plans->{$recommended['medium']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
      if (isset($recommended['full'])) {
        $priceFull = number_format(($plans->{$recommended['full']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
      }else{
        $priceFull = 0.00;
      }
     
    
    $quote['answers']['vehicleVersion'] = $version;
    $segTransportados = $ap->premioMensual ?? 0;
    $sumaAsegurada = $plans->{$recommended['medium']}->suma + $plans->{$recommended['medium']}->sumaAccesorio;
    
    $nroGuid = $quote['guid'];
    $quote['answers']['vehicleValue'] = $sumaAsegurada;

    $quote = Quote::save_quote($nroGuid, $quote);
    
       
    ?>
    
    <section class="precios-conteiner">
          <div class="data-plan">
            <div class="pasos">
                <img src=<?php echo $urlImg . "auto_paso1.png"; ?> alt="" class="img_pasos1" id="img1">
                <img src=<?php echo $urlImg . "persona_paso2.png"; ?> alt="" class="img_pasos2" id="img2">
                <img src= <?php echo $urlImg . "pesos_paso3_activo.png";?>  alt="" class="img_pasos3">
            </div>
            <div class="titData">
                Seleccioná un plan
            </div>
            <div class="auto-data">
                <div>PARA TU <?php  echo $leyenda; ?>    </div>
                <div>Suma asegurada: $<?php echo $sumaAsegurada; ?> | Cuota mensual: $0,00</div>
            </div>
        </div>
        <div class="sel-plan">
            <form action="/wordpress/cotizador/" method="POST"> 
                <div>
                    <span class="titData">Plan esencial</span> 
                    <div class="boxPrecio">
                        <span class="tit-precio" id="precioBasico"> $<?php  echo $priceBasic ;?> </span>
                    </div>
                    <span class="txt-precio">por mes</span>
                    <div class="servicios">
                        <span class="tit-servicios">Servicio de grúa</span>
                        <span class="text-servicios ">200 km (400 km efectivos)</span>
                        <span class="tit-servicios">Coberturas</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Responsabilidad Civil</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida total por incendio</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida parcial por incendio</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida total por robo y/o hurto</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Pérdida parcial por robo y/o hurto</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Destrucción total por accidente</span>
                        <span class="text-servicios text-servicios-cancel last-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Daños parciales por accidente</span>
                        <span class="tit-servicios">Beneficios exclusivos</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Reposición a nuevo de la unidad</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Reposición a nuevo de las cubiertas</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Daños por granizo</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Reposición de parabrisas o luneta</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Rotura de cristales laterales y/o</span>
                        <span class="text-servicios text-servicios-cancel">cerraduras de puerta</span>
                        <span class="text-servicios text-servicios-cancel last-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Franquicia para daños parciales</span>
                        <span class="tit-servicios last-tit">Protejé a tu familia</span>
                        <div class="check-cobertura">
                            <input 
                                type="checkbox" 
                                name="pack1" 
                                id="packBasico" 
                                checked 
                                value=" <?php echo $segTransportados;  ?> "
                                onclick="checkPackBasico();" 
                            >
                            <label for="pack1" >Incluir cobertura para</label>
                            <span class="text-servicios"> pasajeros transportados</span>
                        </div>
                        <div class="btn-contrata">
                            <button 
                                id="btnCotizaBasic"
                                class="btnCotiza" 
                                type="submit"
                                value="<?php echo $recommended['basic'] ; ?>"
                                onclick="envioPlan('1');"
                                >
                                CONTRATÁ
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="titData">Plan superior</span> 
                    <div class="boxPrecio">
                        <span class="tit-precio" id="precioMedium"> $<?php  echo $priceMedium ;?> </span>
                    </div>
                    <span class="txt-precio">por mes</span>
                    <div class="servicios">
                        <span class="tit-servicios">Servicio de grúa</span>
                        <span class="text-servicios ">200 km (400 km efectivos)</span>
                        <span class="tit-servicios">Coberturas</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Responsabilidad Civil</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida total por incendio</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida parcial por incendio</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida total por robo y/o hurto</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida parcial por robo y/o hurto</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Destrucción total por accidente</span>
                        <span class="text-servicios text-servicios-cancel last-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Daños parciales por accidente</span>
                        <span class="tit-servicios">Beneficios exclusivos</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Reposición a nuevo de la unidad</span>
                        <span class="text-servicios text-servicios-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Reposición a nuevo de las cubiertas</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Daños por granizo</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Reposición de parabrisas o luneta</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Rotura de cristales laterales y/o</span>
                        <span class="text-servicios text-servicios-cancel">cerraduras de puerta</span>
                        <span class="text-servicios text-servicios-cancel last-cancel"><img src="<?php echo $urlImg . "cancel.png"; ?>" alt="">Franquicia para daños parciales</span>
                        <span class="tit-servicios last-tit">Protejé a tu familia</span>
                        <div class="check-cobertura">
                        <input 
                            type="checkbox" 
                            name="pack1" 
                            id="packSuperior" 
                            checked
                            value=" <?php echo $segTransportados;  ?> "
                            onclick="checkPackSup();" 
                        >
                            <label for="pack1" >Incluir cobertura para</label>
                            <span class="text-servicios"> pasajeros transportados</span>
                        </div>
                        <div class="btn-contrata">
                            <button 
                                id="btnCotizaMedium"
                                class="btnCotiza" 
                                type="submit"
                                value="<?php echo $recommended['medium'] ; ?>"
                                onclick="envioPlan('2');"
                                >
                                CONTRATÁ
                            </button>
                        </div>
                    </div>
                </div>
                <div class="exclusive">
                    <span class="titData">Plan exclusivo</span> 
                    <div class="boxPrecio">
                        <span class="tit-precio" id="precioFull"> $<?php echo $priceFull ;?> </span>
                    </div>
                    <span class="txt-precio">por mes</span>
                    <div class="servicios">
                        <span class="tit-servicios th-tit">Servicio de grúa</span>
                        <!-- <span class="text-servicios ">200 km (400 km efectivos)</span> -->
                        <select 
                            name="km-grua" 
                            class="selectores" 
                            id="km-grua" 
                            onchange="selectGrua();" 
                            data-full= <?php  echo json_encode($full); ?>
                            data-plans = <?php echo json_encode($plans);   ?> 
                        >
                            <?php if (!empty($full['limited300'])) : ?>
                                <option name="fulltier" value="limited300">300km (600km efectivos)</option>
                            <?php endif; ?>
                            <?php if (!empty($full['limited400'])) : ?>
                                <option name="fulltier" value="limited400" selected>400km (800km efectivos)</option>
                            <?php endif; ?>
                            <?php if (!empty($full['unlimited'])) : ?>
                                <option name="fulltier" value="unlimited">Ilimitada</option>
                            <?php endif; ?>
                        </select>
                        <span class="tit-servicios">Coberturas</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Responsabilidad Civil</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida total por incendio</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida parcial por incendio</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida total por robo y/o hurto</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Pérdida parcial por robo y/o hurto</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Destrucción total por accidente</span>
                        <span class="text-servicios last-cancel"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Daños parciales por accidente</span>
                        <span class="tit-servicios">Beneficios exclusivos</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Reposición a nuevo de la unidad</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Reposición a nuevo de las cubiertas</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Daños por granizo</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Reposición de parabrisas o luneta</span>
                        <span class="text-servicios"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Rotura de cristales laterales y/o</span>
                        <span class="text-servicios">cerraduras de puerta</span>
                        <span class="text-servicios last-cancel"><img src="<?php echo $urlImg . "check.png"; ?>" alt="">Franquicia para daños parciales</span>
                        <select 
                            id="franquicia"
                            name="franquicia" 
                            class="selectores franquicia "
                            onchange="selectFranquicia();" 
                        >
                            <option value="">Cargando..</option>
                            
                        </select>
                        <span class="tit-servicios last-tit">Protejé a tu familia</span>
                        <div class="check-cobertura">
                            <input 
                                type="checkbox" 
                                name="pack1" 
                                id="packFull" 
                                checked 
                                value=" <?php echo $segTransportados;  ?> "
                                onclick="checkPackFull();" 
                            >
                            <label for="pack1" >Incluir cobertura para</label>
                            <span class="text-servicios"> pasajeros transportados</span>
                        </div>
                        <div class="btn-contrata">
                            <button 
                                id="btnCotizaFull"
                                class="btnCotiza" 
                                type="submit"
                                value=" <?php  echo $recommended['full']; ?>"
                                onclick="envioPlan('3');"
                                >
                                CONTRATÁ
                            </button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="product" value="<?php echo $quote['product']; ?>" />
                <input type="hidden" name="guid" value="<?php echo $quote['guid']; ?>" />
                <input type="hidden" name="planCobertura" value="0" />
                <input type="hidden" name="planSuma" value="0" />
                <input type="hidden" name="planPremio" value="0" />
                <input type="hidden" name="planPrima" value="0" />
                <input type="hidden" name="planFechaInicio" value="0" />
                <input type="hidden" name="planFechaFin" value="0" />
                <input type="hidden" name="planPremioMensual" value="0" />
                <input type="hidden" name="planPremioReferencia" value="0" />
                <input type="hidden" name="planFranquicia" value="0" />

                <input type="hidden" name="codigoConvenio" value="0" />
                <input type="hidden" name="bonusMaxConvenio" value="0" />
                <input type="hidden" name="bonusMaxAntiguedad" value="0" />
                <input type="hidden" name="bonusMaxSuma" value="0" />

                <input type="hidden" name="cuotaSeleccionada" value="0" />

            </form> 
        </div>
    </section>
    
    <script>
      var category = 'vehiculos';
      var product = 'seguro-de-autos-y-pick-ups';
      var commonEvent = {
        'category': category,
        'product': product,
        'vehicleBrand': '<?php echo $quote['answers']['vehicleBrand']; ?>',
        'vehicleModel': '<?php echo $quote['answers']['vehicleModel']; ?>',
        'vehicleYear': '<?php echo $quote['answers']['vehicleYear']; ?>',
        'vehicleVersion': '<?php echo $quote['answers']['vehicleVersion']; ?>',
      };
      var recommended = <?php echo json_encode($recommended) ?>;
      var plans = <?php echo json_encode($plans); ?>;
      var full = <?php echo json_encode($full) ?>;
      var ap = <?php echo json_encode($ap); ?>;

      pushDataLayer({
        'event': 'trackEcommerceCheckPricing',
        ...commonEvent,
      });
    </script>
  
    <?php 
        echo track_script($quote['guid']); 
       
    ?>
<?php  
    } 

?>




<?php  include 'nuevo_footer.php' ;?>