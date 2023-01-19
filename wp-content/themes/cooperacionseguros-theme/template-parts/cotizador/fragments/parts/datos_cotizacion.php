<?php

     $path = get_template_directory_uri();
     $urlImg= $path . "/assets/img/cotizador/"; 

    

    $datosPersonales = stripslashes($_COOKIE['datosPersonales']);
    $datosPersonales = json_decode($datosPersonales, true);

    $datosVehiculo = stripslashes($_COOKIE['datosVehiculo']);
    $datosVehiculo = json_decode($datosVehiculo, true);

    $guid = stripslashes($_COOKIE['guid']);
    $guid = json_decode($guid, true);

    $quote = Quote::get_quote($guid);

    $marca = $datosVehiculo['marca'];
    $modelo = $datosVehiculo['modelo'];
    $anio = $datosVehiculo['agno'];

    $leyenda = $marca." ".$modelo." DE ".$anio;

    $rates = Quote::get_vehicle_rates($quote);
    
    if(!$rates){
        ?>
        <input type="text" id="input-cotiza" value="noCotiza" hidden>
        <?php
        if ($datosVehiculo['cotiza'] === '0') {
            ?>
            <div class="mensaje" style="flex-direction: column; align-items: center;">
                <div class="sinCotizacion">
                        <span>Error zona de comercialización/localidad</span>
                        <br>Lo sentimos, en este momento no tenemos coberturas online disponibles en <span><?php echo $datosVehiculo['localidad'] ;?></span>
                        . Si tenés alguna duda, podés comunicarte con nuestro Centro de Atención al Cliente al 0800-777-7070 o por mail a clientes@cooperacionseguros.com.ar
                </div>
                <button type="button" id="btn-error-volver" class="btnCotiza btn-continuar-persona" style="margin-bottom: 60px;">Volver</button>   
            </div>
        <?php
        }else {
    ?>
        <div class="mensaje" style="flex-direction: column; align-items: center;">
            <div class="sinCotizacion">
                    Lo sentimos, en este momento no tenemos coberturas para tu <span><?php echo $leyenda ;?></span>
                    . Si tenés alguna duda, podés comunicarte con nuestro Centro de Atención al Cliente al 0800-777-7070 o por mail a clientes@cooperacionseguros.com.ar
            </div>
            <button type="button" id="btn-error-volver" class="btnCotiza btn-continuar-persona" style="margin-bottom: 60px;">Volver</button>   
        </div>
       
    <?php
        } 
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
     
    
    $quote['answers']['vehicleVersion'] = $datosVehiculo['version'];
    $segTransportados = $ap->premioMensual ?? 0;
    $sumaAsegurada = $plans->{$recommended['medium']}->suma + $plans->{$recommended['medium']}->sumaAccesorio;
    

    


    $nroGuid = $quote['guid'];
    $quote['answers']['vehicleValue'] = $sumaAsegurada;

    $quote = Quote::save_quote($nroGuid, $quote);
    
       
    ?>
    
    <section class="precios-conteiner animate__animated animate__fadeIn" id="seccion_planes" hidden>
          <div class="data-plan">
                <div class="pasos">
                    <div class="img_pasos1">
                        <svg id="img_vehiculo_cotizacion" width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="img_pasos1 pasos_cotizador_inactivo" d="M2.12869 9.47297L4.01984 4.0013C4.74374 1.90484 6.69615 0.501404 8.88879 0.501404H18.6267C20.8193 0.501404 22.7701 1.90484 23.4957 4.0013L25.3873 9.47297C26.6341 9.99559 27.5155 11.2422 27.5155 12.6958V23.1481C27.5155 24.1117 26.747 24.8901 25.7958 24.8901H24.0761C23.1248 24.8901 22.3563 24.1117 22.3563 23.1481V20.535H5.15916V23.1481C5.15916 24.1117 4.38904 24.8901 3.43944 24.8901H1.71972C0.770111 24.8901 0 24.1117 0 23.1481V12.6958C0 11.2422 0.879206 9.99559 2.12869 9.47297ZM5.86316 9.21167H21.6523L20.2497 5.15051C20.0078 4.45369 19.3576 3.98551 18.6267 3.98551H8.88879C8.15791 3.98551 7.50765 4.45369 7.26581 5.15051L5.86316 9.21167ZM5.15916 12.6958C4.20955 12.6958 3.43944 13.4742 3.43944 14.4378C3.43944 15.4014 4.20955 16.1799 5.15916 16.1799C6.11037 16.1799 6.87887 15.4014 6.87887 14.4378C6.87887 13.4742 6.11037 12.6958 5.15916 12.6958ZM22.3563 16.1799C23.3076 16.1799 24.0761 15.4014 24.0761 14.4378C24.0761 13.4742 23.3076 12.6958 22.3563 12.6958C21.4051 12.6958 20.6366 13.4742 20.6366 14.4378C20.6366 15.4014 21.4051 16.1799 22.3563 16.1799Z" fill="#F5A02E"/>
                        </svg>
                    </div>

                    <div class="img_pasos2">
                        <svg id="img_persona_cotizacion" width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="img_pasos2 pasos_cotizador_inactivo" d="M19.4719 10.9436C19.4719 12.3119 18.9283 13.6242 17.9608 14.5917C16.9933 15.5592 15.681 16.1028 14.3127 16.1028C12.9444 16.1028 11.6322 15.5592 10.6646 14.5917C9.69712 13.6242 9.15356 12.3119 9.15356 10.9436C9.15356 9.57535 9.69712 8.2631 10.6646 7.29557C11.6322 6.32804 12.9444 5.78448 14.3127 5.78448C15.681 5.78448 16.9933 6.32804 17.9608 7.29557C18.9283 8.2631 19.4719 9.57535 19.4719 10.9436Z" fill="#DCD1D1"/>
                        <path class="img_pasos2 pasos_cotizador_inactivo" fill-rule="evenodd" clip-rule="evenodd" d="M0.554932 14.3831C0.554932 10.7343 2.0044 7.235 4.58448 4.65492C7.16456 2.07484 10.6639 0.625366 14.3127 0.625366C17.9615 0.625366 21.4608 2.07484 24.0409 4.65492C26.621 7.235 28.0704 10.7343 28.0704 14.3831C28.0704 18.0319 26.621 21.5312 24.0409 24.1113C21.4608 26.6914 17.9615 28.1409 14.3127 28.1409C10.6639 28.1409 7.16456 26.6914 4.58448 24.1113C2.0044 21.5312 0.554932 18.0319 0.554932 14.3831V14.3831ZM14.3127 2.34508C12.0457 2.34521 9.82484 2.98544 7.9057 4.19211C5.98656 5.39878 4.44714 7.12282 3.46463 9.16582C2.48213 11.2088 2.09646 13.4877 2.35203 15.7402C2.60761 17.9928 3.49402 20.1273 4.90926 21.8983C6.13026 19.9309 8.81818 17.8225 14.3127 17.8225C19.8072 17.8225 22.4934 19.9292 23.7161 21.8983C25.1313 20.1273 26.0178 17.9928 26.2733 15.7402C26.5289 13.4877 26.1432 11.2088 25.1607 9.16582C24.1782 7.12282 22.6388 5.39878 20.7197 4.19211C18.8005 2.98544 16.5796 2.34521 14.3127 2.34508V2.34508Z" fill="#DCD1D1"/>
                        </svg>
                    </div>

                    <div class="img_pasos3">
                        <svg id="img_pago" width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="pasos_cotizador_activo" d="M14.5633 11.7644C13.8911 11.5964 13.2188 11.2602 12.7146 10.7561C12.2104 10.588 12.0424 10.0838 12.0424 9.74768C12.0424 9.41155 12.2104 8.90736 12.5466 8.7393C13.0507 8.40317 13.5549 8.06704 14.0591 8.23511C15.0675 8.23511 15.9078 8.7393 16.412 9.41155L17.9246 7.39479C17.4204 6.8906 16.9162 6.55447 16.412 6.21834C15.9078 5.88222 15.2356 5.71416 14.5633 5.71416V3.36127H12.5466V5.71416C11.7062 5.88222 10.8659 6.38641 10.1937 7.05866C9.52141 7.89898 9.01722 8.90736 9.18529 9.91574C9.18529 10.9241 9.52141 11.9325 10.1937 12.6048C11.034 13.4451 12.2104 13.9493 13.2188 14.4535C13.723 14.6215 14.3953 14.9576 14.8994 15.2938C15.2356 15.6299 15.4036 16.1341 15.4036 16.6383C15.4036 17.1425 15.2356 17.6467 14.8994 18.1508C14.3953 18.655 13.723 18.8231 13.2188 18.8231C12.5466 18.8231 11.7062 18.655 11.202 18.1508C10.6979 17.8147 10.1937 17.3105 9.85754 16.8063L8.17691 18.655C8.6811 19.3273 9.18529 19.8315 9.85754 20.3357C10.6979 20.8399 11.7062 21.344 12.7146 21.344V23.5289H14.5633V21.0079C15.5717 20.8399 16.412 20.3357 17.0843 19.6634C17.9246 18.8231 18.4288 17.4786 18.4288 16.3021C18.4288 15.2938 18.0926 14.1173 17.2523 13.4451C16.412 12.6048 15.5717 12.1006 14.5633 11.7644ZM13.5549 0C6.16014 0 0.109863 6.05028 0.109863 13.4451C0.109863 20.8399 6.16014 26.8901 13.5549 26.8901C20.9497 26.8901 27 20.8399 27 13.4451C27 6.05028 20.9497 0 13.5549 0ZM13.5549 25.0414C7.16853 25.0414 1.95856 19.8315 1.95856 13.4451C1.95856 7.05866 7.16853 1.8487 13.5549 1.8487C19.9413 1.8487 25.1513 7.05866 25.1513 13.4451C25.1513 19.8315 19.9413 25.0414 13.5549 25.0414Z" fill="#DCD1D1"/>
                        </svg>
                    </div> 
            </div>
            <div class="titData">
                Seleccioná un plan
            </div>
            <div class="auto-data">
                <div>PARA TU <?php  echo $leyenda; ?>    </div>
                <div>Suma asegurada: $<?php echo number_format($sumaAsegurada,0,".","."); ?></div>
            </div>
        </div>
        <div class="sel-plan">
            <form>
                <?php if ($priceBasic) {
                ?>   
                <div>
                    <span class="titData" id="nombreBasico">Plan esencial</span> 
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
                                onclick="checkCoberturaAP('basico');" 
                            >
                            <label for="pack1" >Incluir cobertura para</label>
                            <span class="text-servicios"> pasajeros transportados</span>
                        </div>
                        <div class="boxPrecio">
                            <span class="tit-precio precio-abajo" id="precioBasicoAbajo"> $<?php  echo $priceBasic ;?> </span>
                        </div>
                        <span class="txt-precio txt-precio-abajo">por mes</span>
                        <div class="btn-contrata">
                            <button 
                                id="btnCotizaBasic"
                                class="btnCotiza" 
                                type="button"
                                value="<?php echo $recommended['basic'] ; ?>"
                                onclick="envioPlan('1');"
                                disabled
                                >
                                CONTRATÁ
                            </button>
                        </div>
                    </div>
                </div>
                <?php } 
                if ($priceMedium) {
                ?>                
                <div>
                    <span class="titData" id="nombreMedium">Plan superior</span> 
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
                            onclick="checkCoberturaAP('superior');" 
                        >
                            <label for="pack1" >Incluir cobertura para</label>
                            <span class="text-servicios"> pasajeros transportados</span>
                        </div>
                        <div class="boxPrecio">
                        <span class="tit-precio precio-abajo" id="precioMediumAbajo"> $<?php  echo $priceMedium ;?> </span>
                        </div>
                        <span class="txt-precio txt-precio-abajo">por mes</span>
                        <div class="btn-contrata">
                            <button 
                                id="btnCotizaMedium"
                                class="btnCotiza" 
                                type="button"
                                value="<?php echo $recommended['medium'] ; ?>"
                                onclick="envioPlan('2');"
                                disabled
                                >
                                CONTRATÁ
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                }
                if ($priceFull) {
                ?>
                <div class="exclusive">
                    <span class="titData" id="nombreFull">Plan exclusivo</span> 
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
                                onclick="checkCoberturaAP('full');" 
                            >
                            <label for="pack1" >Incluir cobertura para</label>
                            <span class="text-servicios"> pasajeros transportados</span>
                        </div>
                        <div class="boxPrecio">
                        <span class="tit-precio precio-abajo" id="precioFullAbajo"> $<?php  echo $priceFull ;?> </span>
                        </div>
                        <span class="txt-precio txt-precio-abajo">por mes</span>
                        <div class="btn-contrata">
                            <button 
                                id="btnCotizaFull"
                                class="btnCotiza" 
                                type="button"
                                value=" <?php  echo $recommended['full']; ?>"
                                onclick="envioPlan('3');"
                                disabled
                                >
                                CONTRATÁ
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                }
                ?>

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


                <?php if ($ap->premioMensual) : ?>
                    <input type="hidden" class="dataAp" name="apOnOff" value="on" />
                    <input type="hidden" class="dataAp" name="apIdProducto" value="<?php echo $ap->idProducto; ?>" />
                    <input type="hidden" class="dataAp" name="apIdPlantSuscWebCab" value="<?php echo $ap->idPlantSuscWebCab; ?>" />
                    <input type="hidden" class="dataAp" name="apPremio" value="<?php echo $ap->premio; ?>" />
                    <input type="hidden" class="dataAp" name="apPremioMensual" value="<?php echo $ap->premioMensual; ?>" />
                    <input type="hidden" class="dataAp" name="apPrima" value="<?php echo $ap->prima; ?>" />
                <?php endif; ?>

            </form> 
        </div>
    </section>

    <div class="loader-checkout-vehiculo-cedula" style="margin: 200px 0;" id="loader-cedula">
        <p>Espere un momento...</p>
        <img src="<?php echo get_template_directory_uri() . '/assets/img/checkout/loader.gif'  ?>" alt="">
    </div>
    
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
        'vehicleGnc': '<?php echo $quote['answers']['vehicleGnc']; ?>',
        'localidad': '<?php echo $quote['answers']['userCity']; ?>,<?php echo $quote['answers']['userState']; ?>',
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