<?php

require_once get_template_directory() . '/api/api.php';

class Quote {
  public static function create_guid() {
    if (function_exists('com_create_guid') === true) {
      return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
  }

  public static function create_quote($product, $data = null, $guid = null) {
    $quote = [];
    $quote['guid'] = $guid ? $guid : self::create_guid();
    $quote['created'] = date('c');
    $quote['product'] = $product;

    switch($product) {
      case 'seguro-de-autos-y-pick-ups':
        $quote['answers'] = self::create_vehicle_quote($product, $data);
        break;

      case 'seguro-de-motos':
        $quote['answers'] = self::create_vehicle_quote($product, $data);
        break;

      case 'seguro-de-vida-individual':
        $quote['answers'] = self::create_life_insurance_quote($data);
        break;

      case 'seguro-de-maquinaria-e-implementos':
        $quote['answers'] = self::create_agro_vehicle_quote($data);
        break;
    }

    $quote['utmSource'] = $_COOKIE['utmSource'] ?? '';
    $quote['utmMedium'] = $_COOKIE['utmMedium'] ?? '';
    $quote['utmCampaign'] = $_COOKIE['utmCampaign'] ?? '';

    $currentProduct = get_product_from_slug($quote['product']);
    $quote['coopid'] = $currentProduct->coopid;
    $quote['coopname'] = $currentProduct->coopname;

    self::save_quote($quote['guid'], $quote);

    $lead = new Lead($quote);
    $lead->send_lead();

    return $quote;
  }

  public static function create_vehicle_quote($product, $data) {
    $answers = [];

    // Datos de la persona
    $answers['userName'] = filter_var($data['userName'], FILTER_SANITIZE_STRING);
    $answers['userEmail'] = filter_var($data['userEmail'], FILTER_SANITIZE_STRING);
    $answers['userZip'] = filter_var($data['userZip'], FILTER_SANITIZE_NUMBER_INT);
    $answers['userIdCity'] = filter_var($data['userIdCity'], FILTER_SANITIZE_NUMBER_INT);
    $answers['userCity'] = filter_var($data['userCity'], FILTER_SANITIZE_STRING);
    $answers['userState'] = filter_var($data['userState'], FILTER_SANITIZE_STRING);

    // Datos del vehículo (común)
    $answers['vehicleBrand'] = filter_var($data['vehicleBrand'], FILTER_SANITIZE_STRING);
    $answers['vehicleYear'] = filter_var($data['vehicleYear'], FILTER_SANITIZE_NUMBER_INT);
    $answers['vehicleVersion'] = filter_var($data['vehicleVersion'], FILTER_SANITIZE_STRING);
    $answers['codInfoAuto'] = filter_var($data['codInfoAuto'], FILTER_SANITIZE_STRING);
    $answers['codVal'] = filter_var($data['codval'], FILTER_SANITIZE_STRING);
    $answers['vehicleValue'] = filter_var($data['vehicleValue'], FILTER_SANITIZE_STRING);

    // Datos autos y pickups
    if ($product == 'seguro-de-autos-y-pick-ups') {
      $answers['vehicleBrandId'] = filter_var($data['vehicleBrandId'], FILTER_SANITIZE_NUMBER_INT);
      $answers['vehicleModel'] = filter_var($data['vehicleModel'], FILTER_SANITIZE_STRING);
      $answers['vehicleModelId'] = filter_var($data['vehicleModelId'], FILTER_SANITIZE_NUMBER_INT);
      $answers['vehicleGnc'] = filter_var($data['vehicleGnc'], FILTER_SANITIZE_STRING);
      $answers['vehicleGncID'] = filter_var($data['vehicleGncId'], FILTER_SANITIZE_STRING);
      $answers['vehicleGncValue'] = filter_var($data['vehicleGncValue'], FILTER_SANITIZE_STRING);
    } else if ($product == 'seguro-de-motos') {
      $answers['codRC'] = filter_var($data['codRC'], FILTER_SANITIZE_STRING);
    }

    return $answers;
  }

  public static function create_life_insurance_quote($data) {
      $answers = [];

      $answers['userName'] = filter_var($data['userName'], FILTER_SANITIZE_STRING);
      $answers['userEmail'] = filter_var($data['userEmail'], FILTER_SANITIZE_STRING);
      $answers['userBirthDate'] = filter_var($data['userBirthMonth'], FILTER_SANITIZE_NUMBER_INT) . '-' . filter_var($data['userBirthDay'], FILTER_SANITIZE_NUMBER_INT) . '-' . filter_var($data['userBirthYear'], FILTER_SANITIZE_NUMBER_INT);
      $answers['sumaAsegurada'] = filter_var($data['sumaAsegurada'], FILTER_SANITIZE_NUMBER_INT);
      $answers['userZip'] = filter_var($data['userZip'], FILTER_SANITIZE_NUMBER_INT);
      $answers['userIdCity'] = filter_var($data['userIdCity'], FILTER_SANITIZE_NUMBER_INT);
      $answers['userCity'] = filter_var($data['userCity'], FILTER_SANITIZE_STRING);
      $answers['userState'] = filter_var($data['userState'], FILTER_SANITIZE_STRING);

      return $answers;
  }

  public static function create_agro_vehicle_quote($data) {
    $answers = [];

    $answers['agroBrand'] = filter_var($data['agroBrand'], FILTER_SANITIZE_STRING);
    $answers['agroType'] = filter_var($data['agroType'], FILTER_SANITIZE_STRING);
    $answers['agroModel'] = filter_var($data['agroModel'], FILTER_SANITIZE_STRING);
    $answers['agroYear'] = filter_var($data['agroYear'], FILTER_SANITIZE_STRING);

    return $answers;
  }

  public static function save_quote($guid = null, $quote = []) {
    if (!$guid) return false;

    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';

    if (file_put_contents($file_path, json_encode($quote))) {
      return $quote;
    }
  }

  public static function get_quote($guid = null) {
    if (!$guid) return;
    require_once get_template_directory() . '/api/api.php';
    $token = encrypt_decrypt('decrypt', coopseg_get_local_token());
    $remoteLead = json_decode(coopseg_lead_get($token, $guid), true);

    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';

    $response = [];
    if (isset($remoteLead['idLead'])) {
      $response = array_merge($response, $remoteLead);
    }

    if (file_exists($file_path)) {
      $response = array_merge($response, json_decode(file_get_contents($file_path), true));
    }

    return (empty($response)) ? null : $response;
  }

  public static function get_vehicle_rates($quote) {
    $token = get_token();
    $product = $quote['product'];

    $year = $quote['answers']['vehicleYear'] ?? $quote['vehiculos'][0]['anio'] ?? null;
    $codInfoAuto = $quote['answers']['codInfoAuto'] ?? $codInfoAuto = $quote['vehiculos'][0]['codia'] ?? null ;
    $codval = $quote['answers']['codVal'] ?? $quote['vehiculos'][0]['codval'] ?? null;
    $codRC = $quote['answers']['codRC'] ?? $quote['vehiculos'][0]['codRC'] ?? null;
    $idCity = $quote['answers']['userIdCity'] ?? $quote['vehiculos'][0]['idLocalidadGuardaHabitual'] ?? null;
    $gnc = $quote['answers']['vehicleGncValue'] ?? $quote['vehiculos'][0]['idAccesorioGnc'] ?? null;

    $response = coopseg_vehicles_get_quotes($token, $year, $codInfoAuto, $codval, $idCity, $gnc);
    $rates = ($response) ? json_decode($response) : null;
    if (empty($rates) || $rates == 'cURL Error #:28') return null;
    $plans = $rates->planes;
    $recommended = [];

    if ($product == 'seguro-de-autos-y-pick-ups') {
      if ((!isset($rates->planes->B1) && !isset($rates->planes->B2)) || (!isset($rates->planes->C1) && !isset($rates->planes->C2))) return null;
      $full = [];

      $AP = $rates->ap[0] ?? null;

      if (isset($rates->planes->B2)) {
        $recommended['basic'] = 'B2';
      } else {
        $recommended['basic'] = 'B1';
      }

      // Plan Superior
      if ((date('Y') - $year) <= 10) {
        $recommended['medium'] = 'C2';
      } else if ((date('Y') - $year) <= 14) {
        $recommended['medium'] = 'C3';
      } else {
        $recommended['medium'] = 'C1';
      }

      // Planes Exclusivos
      $fullPlans = [
        'O' => 'limited300',
        'D' => 'limited400',
        'M' => 'limited400',
        'P' => 'limited400',
        'J' => 'limited400',
        'J1' => 'limited400',
        'J2' => 'unlimited',
        'J3' => 'unlimited',
      ];

      foreach ($fullPlans as $plan => $tier) {
        if (isset($plans->{$plan})) {
          $full[$tier][] = $plan;
        }
      }

      if (!empty($full)) {
        if (!empty($full['limited400'])) {
          usort($full['limited400'], function ($a, $b) use ($plans) {
            return $plans->{$a}->premioMensual <=> $plans->{$b}->premioMensual;
          });

          $recommended['full'] = $full['limited400'][0];
        } else if (!empty($full['limited300'])) {
          usort($full['limited300'], function ($a, $b) use ($plans) {
            global $plans;
            return $plans->{$a}->premioMensual <=> $plans->{$b}->premioMensual;
          });

          $recommended['full'] = $full['limited300'][0];
        } else if (!empty($full['unlimited'])) {
          usort($full['unlimited'], function ($a, $b) use ($plans) {
            global $plans;
            return $plans->{$a}->premioMensual <=> $plans->{$b}->premioMensual;
          });

          $recommended['full'] = $full['unlimited'][0];
        }
      }

      $rates = [
        'ap' => $AP,
        'plans' => $plans,
        'recommended' => $recommended,
        'full' => $full,
      ];
    } else if ($product == 'seguro-de-motos') {
      if (!isset($rates->planes->A)) return null;

      $AP = $rates->ap[0] ?? null;

      if (isset($rates->planes->A)) {
        $recommended['basic'] = 'A';
      }

      if ($codRC == '73') {
        if (((date('Y') - $year) > 14) && isset($rates->planes->B1)) {
          $recommended['medium'] = 'B1';
        } else if (isset($rates->planes->B)) {
          $recommended['medium'] = 'B';
        }

        if (isset($rates->planes->J)) {
          $recommended['full'] = 'J';
        } else if (isset($rates->planes->B4)) {
          $recommended['full'] = 'B4';
        }
      } else if($codRC == '74') {
        if (isset($rates->planes->B1)) {
          $recommended['medium'] = 'B1';
        }
      } else { // $codRC == '76'
        if (((date('Y') - $year) > 14) && isset($rates->planes->B1)) {
          $recommended['medium'] = 'B1';
        } else if (isset($rates->planes->B)) {
          $recommended['medium'] = 'B';
        }
      }

      $rates = [
        'ap' => $AP,
        'plans' => $plans,
        'recommended' => $recommended,
      ];
    };

    return $rates;
  }

  public static function get_life_insurance_rates($quote) {
    $token = get_token();

    $response = coopseg_life_get_quotes($token, $quote['answers']['sumaAsegurada'], $quote['answers']['userBirthDate']);
    $rates = ($response) ? json_decode($response) : null;
    if (empty($rates) || $rates == 'cURL Error #:28') return null;

    return $rates;
  }
}
