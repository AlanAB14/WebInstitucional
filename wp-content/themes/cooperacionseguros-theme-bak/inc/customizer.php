<?php

/**
 * Extra customization options
 */

add_action('customize_register', 'custom_theme_customizer');

function custom_theme_customizer($wp_customize)
{

  // Add section.
  $wp_customize->add_section('custom_site_options', array(
    'title'    => __('Opciones del sitio'),
    'priority' => 20
  ));

  // Add e-mail option
  $wp_customize->add_setting(
    'custom_option_email',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_email',
    array(
      'label' => __('E-mail de contacto'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );

  // Add address option
  $wp_customize->add_setting(
    'custom_option_address',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_address',
    array(
      'label' => __('Dirección'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );

  // Add phone option
  $wp_customize->add_setting(
    'custom_option_phone',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_phone',
    array(
      'label' => __('Teléfono de contacto'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );

  // Add Whatsapp option
  $wp_customize->add_setting(
    'custom_option_whatsapp',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_whatsapp',
    array(
      'label' => __('Número de Whatsapp'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );

  // Add Facebook
  $wp_customize->add_setting(
    'custom_option_facebook',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_facebook',
    array(
      'label' => __('URL de Facebook'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );

  // Add Instagram
  $wp_customize->add_setting(
    'custom_option_instagram',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_instagram',
    array(
      'label' => __('URL de Instagram'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );

  // Add Twitter
  $wp_customize->add_setting(
    'custom_option_twitter',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_twitter',
    array(
      'label' => __('URL de Twitter'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );

  // Add YouTube
  $wp_customize->add_setting(
    'custom_option_youtube',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_youtube',
    array(
      'label' => __('URL de YouTube'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );


  // Add LinkedIn
  $wp_customize->add_setting(
    'custom_option_linkedin',
    array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'custom_option_linkedin',
    array(
      'label' => __('URL de LinkedIn'),
      'section' => 'custom_site_options',
      'type' => 'text'
    )
  );
}