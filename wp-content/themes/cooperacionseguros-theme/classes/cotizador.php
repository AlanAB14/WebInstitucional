<?php

class Cotizador {
  public $guid;
  public $quote;
  public $product;
  public $step;
  public $steps;
  public $status;

  public function __construct($paso, $guid, $instanceLabel) {
    $this->guid = $guid;
    
    $this->quote = Quote::get_quote($this->guid);
    $this->product = get_product_from_slug($this->quote['product'] ?? trim($_REQUEST['product'] ?? get_query_var('product')));
    //if (!$this->product) $this->redirect_home();
    $this->steps = $this->product->steps;
    //print_r($this->steps);
    $this->step = $this->steps[$paso] ?? $this->steps[1];
    //$this->step = $this->get_current_step();
    
    $this->status = trim($_REQUEST['status'] ?? get_query_var('status'));
    
    if (!$this->quote) {
        if (!empty($this->product->questions)) {
          header('Location: /' . $this->product->slug);
        } else {
          $this->quote = Quote::create_quote($this->product->slug);
          header('Location: /cotizador/' . $this->product->slug . '/' . $this->steps[0]->slug . '/' . $this->quote['guid']);
        }
        exit;
    }

    if (isset($this->quote['idPropuesta']) && $this->step->slug != 'finalizado' && $this->step->slug != 'pago') {
       
        header('Location: /' . $this->product->slug . '/' . $this->quote['guid']);
        exit;
      }
   
      if (isset($this->quote['idPropuesta']) && $this->step->slug != 'finalizado' && $this->step->slug != 'pago') {
        header('Location: /' . $this->product->slug . '/' . $this->quote['guid']);
        exit;
      }
    
    $lead = new Lead($this->quote, $this->step->id, $instanceLabel);
    $lead->send_lead();

    
  }

  private function redirect_home() {
    header('Location: /');
    exit;
  }
  private function redirect_error() {
    header('Location: /hubo-un-problema');
    exit;
  }

  public function get_current_step() {
    if (empty($this->steps)) $this->redirect_error();
    $step = array_filter($this->steps, function ($step) {
      return ($step->slug == get_query_var('step'));
    });

    if (!empty(get_query_var('step')) && empty($step)) $this->redirect_error();

    return array_shift($step) ?? $this->steps[1];
  }

  public function get_template() {
    
    //$slug = $this->steps[$paso]->slug;
    $slug = $this->step->slug;
    
    $args = [
       'quote' => $this->quote,
       'options' => (array) ($this->step->options ?? []),
     ];

    
    
    switch($slug) {
        case 'inicio':
            //include 'template-parts/checkout/fragment-inicio.php';
            break;
       case 'datos-vehiculo':
         get_template_part('template-parts/cotizador/cotizador_datos_personales', null, $args);
            break;
         break;

      case 'fotos-vehiculo':
            get_template_part('template-parts/cotizador/cotizador_datos_del_auto', null, $args);
            break;
      case 'datos-solicitante':
            get_template_part('template-parts/cotizador/cotizador_datos_asesor', null, $args);
            //$this->quote['datos-solicitante'] = $_POST;
            break;
      
      case 'asesores':
            get_template_part('template-parts/cotizador/cotizador_resumen', null, $args);
            //$this->quote['asesor'] = $_POST;
            break;
      
      case 'resumen':
            get_template_part('template-parts/cotizador/cotizador_pago', null, $args);
            //$this->quote['resumen'] = $_POST;
            break;
     }
  }

}
