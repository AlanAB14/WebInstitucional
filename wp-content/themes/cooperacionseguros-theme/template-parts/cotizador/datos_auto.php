    <?php
      //echo gettype($mi_data);
     
    ?>  
        <form id="form1" name="datos del auto" method="POST" >
            <div class="row">
              <span class="titulos titForm1">Comentanos un poco sobre tu vehículo</span>
            </div>
            <div class="row">
             <select name="marca" class="selectores" id="marca-nuevo" onchange="cambioFormVehiculo(event);" required>
                <option value="" disabled selected>Marca de tu vehículo</option>
                
             </select>
            </div>
            <div class="row" >
            <select name="modelo" class="selectores" id='model' disabled onchange="cambioFormVehiculo(event);" required>
                <option value="" disabled selected>Modelo</option>
                
             </select>
            </div>
            <div class="row">
              <select name="año" class="selectores" id='agnoNew' disabled onchange="cambioFormVehiculo(event);" required>
                  <option value="" disabled selected>Año</option>
              </select>
            </div>
            <div class="row">
              <select name="version" class="selectores" id='version' disabled onchange="cambioFormVehiculo(event);" required>
                  <option value="" disabled selected>Versión</option>
              </select>
            </div>
            <div class="row">
            <select name="localidad" class="selectores" id='localidad' disabled onchange="cambioFormVehiculo(event);" required>
                <option value="" disabled selected>¿Dónde circula el vehículo?</option>
                
             </select>
            </div>
            <div class="row">
            <select name="gnc" class="selectores" id='gnc' disabled required>
                <option value="" disabled selected>¿Tiene GNC?</option>
             </select>
            </div>
            <div class="row">
              <button class="btnCotiza" type="submit" value="2" name="form" onclick="form1();">Continuar</button>
            </div>
            
        </form>
      