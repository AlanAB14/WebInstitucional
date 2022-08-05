<?php

class ErrorLog {
  public static function new_error($type, $error, $data) {
    $date = new DateTime();
    $file_path = get_template_directory() . '/' . COOPSEG_ERRORES_DIR . '/' . $type . '-' . $date->getTimestamp() . '.json';

    $content = [
      'error' => $error,
      'datetime' => date('d-m-Y h:i:s a', time()),
      'data' => $data,
    ];

    file_put_contents($file_path, json_encode($content));
  }
}
