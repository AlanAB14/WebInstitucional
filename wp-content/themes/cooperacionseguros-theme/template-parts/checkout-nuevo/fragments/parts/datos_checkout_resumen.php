
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_del_auto.css">

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<!-- ANIMATE -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>





<?php  
    require_once get_template_directory() . '/classes/quote.php';


    $seleccion = $_COOKIE['planElejido'];
    $seleccion = str_replace("\\", "",$seleccion);
    $seleccion = json_decode($seleccion);

    $guid = $_COOKIE['guid'];
    $guid = str_replace("\\", "",$guid);
    $guid = json_decode($guid);
 
    $plan = $seleccion->plan;  
    $plan = str_replace(" ", "",$plan);  
    $planDatos = $_COOKIE['datosPlan'];
    $planDatos = str_replace("\\", "",$planDatos);
    $planDatos = json_decode($planDatos);
    
    $commonEvent = $_COOKIE['commonEvent'];
    $commonEvent = str_replace("\\", "",$commonEvent);
    $commonEvent = json_decode($commonEvent);

    $vehiculo = $commonEvent->vehicleBrand . " " . $commonEvent->vehicleModel . " DE " . $commonEvent->vehicleYear;
    $suma_asegurada = $planDatos->suma;
    $cuota = $seleccion->precio;

    $quote = Quote::get_quote($guid);


?>

<section>
    <div class="sup">
        <div class="pasos">
            <div class="paso-1" id="checkout-paso-1">1</div>
            <div class="paso-2" id="checkout-paso-2">2</div>
            <div class="paso-3" id="checkout-paso-3">3</div>
            <div class="paso-4 paso-seleccionado" id="checkout-paso-4">4</div>
            <!--TODO: <div class="paso-5" id="checkout-paso-5">5</div> -->
        </div>

        <div class="titData">
            Estás contratando un <?php echo $seleccion->nombrePlan ?>
        </div>
        <div class="caja">
            <div class="auto-data">
                <div>PARA TU <?php  echo $vehiculo ;?></div>
                <div>Suma asegurada: $<?php  echo number_format($suma_asegurada,0,".","."); ;?> | Cuota mensual: <?php  echo $cuota ;?> | Cobertura: <?php echo $plan ?></div>
            </div>
        </div>
        
    </div>
</section>
<section class="resumen">
    <form action="#" method="POST" id="form_resumen">
        <section class="main-box-p4 animate__animated animate__fadeIn" id="section_resumen" hidden>
            <div class="my-container-fluid">
                <label>Si todos los datos que registramos son correctos, ya podés contratar tu póliza.</label>
            </div>
            <div class="my-container-p4">
                <div class="box-left">
                    <div class="box-left-top">
                        <div class="box-left-top-content">
                            <div class="b-l-t-content-title">
                                <label>Datos sobre vos</label>
                            </div>
                            <div class="b-l-t-content-inputs">
                                <label>DNI:</label>
                                    <input  type="text"
                                            name="dni"
                                            id="datos-dni" 
                                            value="" 
                                            readonly>
                                <label>Nombre:</label>
                                    <input  type="text"
                                            name="nombre"
                                            id="datos-nombre" 
                                            value="ANA GABRIEL" 
                                            readonly>
                                <label>Apellido:</label>
                                    <input  type="text"
                                            name="apellido"
                                            id="datos-apellido" 
                                            value="ALVAREZ GONZALEZ"
                                            readonly>
                                <label>Nacido el:</label>
                                    <input  type="text"
                                            name="fecha_nacimiento"
                                            id="datos-fecha-nacimiento" 
                                            value="25/4/1987" 
                                            readonly>
                                <label>Email:</label>
                                    <input  type="email"
                                            name="email"
                                            id="datos-email" 
                                            value="anagriselalvarez@gmail.com" 
                                            readonly>
                                <label>Teléfono:</label>
                                    <input  type="text"
                                            name="telefono"
                                            id="datos-telefono" 
                                            value="(261) 449985" 
                                            readonly>
                            </div>
                        </div>
                    </div>
                    <div class="box-left-top">
                        <div class="box-left-top-content">
                            <div class="b-l-t-content-title">
                                <label>Datos de tu vehículo</label>
                            </div>
                            <div class="b-l-t-content-inputs ">
                                <label>Vehículo: </label>
                                    <input  type="text" 
                                            name="vehiculo"
                                            id="datos-vehiculo" 
                                            value="GUERRERO GD 100 2021" 
                                            readonly>
                                <label>Circulo en:</label>
                                    <input  type="text" 
                                            name="localidad_circulacion"
                                            id="datos-localidad-circulacion" 
                                            value="Venado Tuerto, Santa Fe (2600)" 
                                            readonly>
                                <label>Patente:</label>
                                    <input  type="text" 
                                            name="patente"
                                            id="datos-patente" 
                                            value="A123ABG" 
                                            readonly>
                                <label>Chasis:</label>
                                    <input  type="text" 
                                            name="chasis" 
                                            id="datos-chasis"
                                            value="5UXXW3C53J0T8683" 
                                            readonly>
                                <label>Motor:</label>
                                    <input  type="email" 
                                            name="motor"
                                            id="datos-motor" 
                                            value="52WVC10338" 
                                            readonly>
                                <label class="box-down">Suma asegurada:</label>
                                    <input  class="box-down" 
                                            type="text" 
                                            name="total_asegurado"
                                            id="datos-suma-asegurada" 
                                            value="$ 7.015.00,00" 
                                            readonly>
                                <label class="box-down" style="color: #73d0f6;">Cuota mensual:</label>
                                    <input  class="box-down" 
                                            type="text" 
                                            name="cuota_mensual"
                                            id="datos-cuota-mensual" 
                                            value="$ 7.015.00,00" 
                                            readonly>
                                <label class="box-down" style="color: #73d0f6;">Cobertura:</label>
                                    <input  class="box-down" 
                                            type="text" 
                                            name="cobertura"
                                            id="datos-cobertura" 
                                            value="A" 
                                            readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parte derecha - Fotos -->
                <div class="box-right">

                    <!-- Fila 1 -->
                    <div class="row-arriba">
                        <div class="caja-interna-arriba">
                            <label>Fotos</label>
                        </div>
                    </div>

                    <!-- Fila 2 -->
                    <div class="row-abajo">
                        <div class="caja-interna-abajo">
                            <div class="caja-interna-abajo-row" id="imagenes-inspeccion">
                            
                                <!-- foreach ($quote['fotos-vehiculo'] as $key => $image) {
                                //if ($key != 'step' && $key != 'guid') {
                                if (strpos($key, 'foto') === 0) {
                                    echo '<img class="imagen-vehiculo-resumen" src="' . COOPSEG_QUOTE_IMAGES_URL . $image . '">';
                                }
                                } -->
                            
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="my-container-orange">
                <div class="text-orange">
                    <label id="label_asesor_asignado">Asesor asignado: REMONDEGUI, SILVIA GRACIELA 25 de mayo 254, Venado Tuerto</label>
                </div>
            </div>

            <div class="checkbox">
                <input  type="checkbox" 
                        name="consentimiento_tyc" 
                        id="consentimiento_tyc"
                        required>
                <div class="checkbox-text">
                    <label for="consentimiento_tyc">Expreso mi consentimiento para suscribir esta póliza y aceptar los <a class="link-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">Términos y Condiciones.</a></label>
                </div>
            </div>

            <div class="my-btn">
                <button class="btn-volver" name="paso" type="button" id="btn_volver" value="3" >VOLVER</button>
                <button class="btn-continuar" name="paso" type="submit" value="5">CONTINUAR</button>
            </div>
        </section>
    </form>
</section>

    <!-- MODAL -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modal-label-tyc" id="exampleModalLabel">Términos y Condiciones del Sitio Web de contratación de Pólizas de Automóviles con Cooperación Mutual Patronal S.M.S.G</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bienvenido a nuestro sitio web.</p>
                    <p>Si continúa navegando y utilizando este sitio web, acepta cumplir y estar sujeto a los términos y condiciones de uso que rigen la relación de Cooperación Mutual Patronal S.M.S.G. con Usted.</p>
                    <p>Al utilizar este sitio web, Usted expresa su aceptación de estos términos y condiciones de uso.</p>
                    <p>Para los fines de estos términos y condiciones, “Nosotros” y “Nuestro” se refieren a Cooperación Mutual Patronal S.M.S.G y “Usted” y “Su” se refieren a Usted, el cliente, el solicitante, el visitante, el asociado, el asegurado del sitio web o la persona que utiliza nuestro sitio web.</p>
                    <p>Cooperación Mutual Patronal S.M.S.G. es una compañía aseguradora legalmente autorizada para operar en la República Argentina, y, además, brinda servicios adicionales por si o por terceros, pudiendo por este medio contratar una póliza automotora de manera online e inmediata</p>
                    <p>La información que contiene este sitio es considerada de utilidad únicamente para el público residente en la República Argentina, a quien le está exclusivamente dirigida y para quien los productos y servicios están disponibles.</p>
                    <h1 class="modal-title-inBody">Modificación de los términos y condiciones</h1>
                    <p>Cooperación Mutual Patronal S.M.S.G. se reserva el derecho de cambiar, modificar, agregar o eliminar partes de estos términos en cualquier momento. Verifique estos términos con regularidad antes de utilizar nuestro sitio web para asegurarse de que está al tanto de cualquier cambio.</p>
                    <p>Nos esforzamos por resaltar cualquier cambio significativo o sustancial para Usted en la medida de lo posible.</p>
                    <p>Si elige utilizar nuestro sitio web, consideraremos ese uso como una prueba concluyente de su formal acuerdo y aceptación de que estos términos rigen sus derechos y obligaciones entre Usted y Cooperación Mutual Patronal S.M.S.G.</p>
                    <h1 class="modal-title-inBody">Enlaces a otros sitios web</h1>
                    <p>Cooperación Mutual Patronal S.M.S.G puede proporcionar esporádicamente en su sitio web, enlaces a otros sitios web, anuncios e información de esos sitios web con propósitos prácticos.</p>
                    <p>Esto no necesariamente implica patrocinio, aprobación o acuerdo entre Cooperación Mutual Patronal S.M.S.G y los propietarios de esos sitios web.</p>
                    <p>El sitio web de Cooperación Mutual Patronal S.M.S.G puede contener información o anuncios proporcionados por terceros, pero Cooperación Mutual Patronal S.M.S.G no asume ninguna responsabilidad en absoluto por cualquier información, sugerencia o consejo proporcionado por terceros directamente.</p>
                    <p>Estamos haciendo una “referencia” solamente y no estamos brindando ningún consejo ni nos hacemos responsables de cualquier consejo recibido respecto a ello.</p>
                    <p>El Usuario, acepta además que Cooperación Mutual Patronal S.M.S.G remita a su domicilio electrónico promociones propias o de terceros sin que ello implique para el mismo obligación alguna de compra.</p>
                    <h1 class="modal-title-inBody">Deber de confidencialidad</h1>
                    <p>En Cooperación Mutual Patronal S.M.S.G. estamos comprometidos a proteger su privacidad.</p>
                    <p>Utilizamos la información que recibimos libremente de Usted para maximizar la calidad de los servicios que brindamos.</p>
                    <p>Cooperación Mutual Patronal S.M.S.G respeta la privacidad y confidencialidad de la información por Usted libremente proporcionada.</p>
                    <p>Todos los datos del solicitante que Cooperación Mutual Patronal S.M.S.G recopila están protegidos contra el uso o acceso no autorizado de acuerdo con la legislación Argentina.</p>
                    <p>Cooperación Mutual Patronal S.M.S.G no vende ni trata información personal de Usted.
                    <p>Sin embargo, podemos usar en un sentido general sin ninguna referencia a su nombre, su información para crear estadística para propósitos de investigación científica para la mejora de marketing, identificar las demandas de los usuarios y ayudar a satisfacer las necesidades de nuestros Asociados, Asegurados, y público en general.</p>
                    <p>Además, podemos usar la información que nos proporciona para mejorar el sitio web y sus servicios, pero no para ningún otro uso.</p>
                    <h1 class="modal-title-inBody">Divulgación de información</h1>
                    <p>Se le puede requerir a Cooperación Mutual Patronal S.M.S.G. en ciertas circunstancias, divulgue información por Usted brindada.</p>
                    <p>Cooperación Mutual Patronal S.M.S.G. en tal caso, lo hará en las siguientes circunstancias: a) por así disponerlo una ley o b) por requerimiento de cualquier tribunal.</p>
                    <h1 class="modal-title-inBody">Defensa del consumidor</h1>
                    <p>En los casos previstos en los artículos 32 y 33 de la Ley Argentina de Defensa al Consumidor – Ley 24.240 - el Usuario o consumidor tiene derecho a revocar la aceptación de su contratación durante el plazo de diez (10) días corridos contados a partir de la fecha en que se celebre el contrato, sin responsabilidad alguna para el Usuario o consumidor.</p>
                    <p>Esta facultad no puede ser dispensada ni renunciada. Tal información debe ser incluida en forma clara y notoria.</p>
                    <p>El Usuario o consumidor debe poner el bien a disposición del vendedor y los gastos de devolución son por cuenta de Cooperación Mutual Patronal S.M.S.G.</p>
                    <p>Cooperación Mutual Patronal S.M.S.G cumple con su deber de informar de manera fehaciente por escrito al Usuario o consumidor de esta facultad de revocación, así como también lo informará en todo documento que con motivo de venta o prestación del servicio le sea presentado al Usuario o consumidor.</p>
                    <h1 class="modal-title-inBody">Alcance de los Términos y Condiciones</h1>
                    <p>Estos términos y condiciones representan el completo acuerdo entre Usted y Cooperación Mutual Patronal S.M.S.G con respecto a su uso y acceso al sitio web a su uso, utilización y acceso a los documentos e información que contiene.</p>
                    <p>Queda expresamente convenido, que se excluyen todos los términos no escritos.
                    <p>Bajo ninguna circunstancia puede responsabilizar a Cooperación Mutual Patronal S.M.S.G por las acciones que realice, ni puede responsabilizarnos a nosotros ni a ninguno de nuestros empleados, asociados o colaboradores por ninguna pérdida o daño en que Usted incurra como resultado del incumplimiento parcial o total de éstos términos y condiciones.</p>
                    <h1 class="modal-title-inBody">Planes de pago por servicios</h1>
                    <p>Se informa al Usuario que los pagos por servicios tomados a Cooperación Mutual Patronal S.M.S.G. son recurrentes.</p>
                    <p>Usted acepta expresamente en consecuencia, que todo compromiso de pago aceptado por Usted implica el débito automático en favor de Cooperación Mutual Patronal S.M.S.G del medio elegido y utilizado por Usted, durante toda la vigencia de la póliza convenida y hasta la total cancelación del premio.</p>
                    <h1 class="modal-title-inBody">Recepción de la póliza</h1>
                    <p>El Usuario que contrata por este sitio su póliza de seguros, podrá visualizar la misma y los demás documentos en la pantalla de su navegador y además la recibirá vía mail al correo electrónico que indicó durante la contratación.</p>
                    <p>El Usuario, acepta expresamente esta modalidad de entrega de póliza propuesta por Cooperación Mutual Patronal S.M.S.G.</p>
                    <h1 class="modal-title-inBody">Jurisdicción</h1>
                    <p>Si hay una disputa entre Usted y Cooperación Mutual Patronal S.M.S.G por el uso de éstos términos y condiciones, y que de ello resulte un litigio, debe someterse a la jurisdicción de los tribunales de Venado Tuerto, provincia de Santa Fe, Republica Argentina.</p>
                    <h1 class="modal-title-inBody">Aceptación formal</h1>
                    <p>Al hacer click en la casilla, Usted acepta sin condicionamiento alguno los términos y condiciones, y por lo tanto podrá hacer uso de los servicios de este sitio, obligándose legalmente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>