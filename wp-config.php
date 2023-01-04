<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'WP_HOME', 'http://localhost/wordpress/' );
define( 'WP_SITEURL', 'http://localhost/wordpress/' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '4j.KC*8dfvsDN$[` w<4G%I&3S0,t:ubka0.D+NO%jf9{:>nx&r^u$(NZ_j?5uOj' );
define( 'SECURE_AUTH_KEY',  'Y #5,<I<ku{s9plUHf+/.56K* 5AP:ZA1_[Qnsrxe^NJdNrmJ$ChZo>NykW(AT=F' );
define( 'LOGGED_IN_KEY',    'wR2(yW*|/(0EdPx_/bNbCcrF,Jp}+}L?EZxp,s0-*/`?K,j91k(`ajM_G?SpB~mv' );
define( 'NONCE_KEY',        'w&@M^C2OkNq(}q=ms:-&7NmMlI-tb{RFh+Ye[vz|x(90@i%#&,Y]_R4%YCZA_(G{' );
define( 'AUTH_SALT',        '?W=k^dS^Q$Ng;I{gd5RdYhw*UG#vU%3K{/Ni8;{_Jc))z5D@wGZ!L3!_8Nm& =w(' );
define( 'SECURE_AUTH_SALT', 'EFw{:F*H#sx.IZg<BXzZv@{m(%PS/h<tJ(MxWpZ$V@t z_gVn#b*+`+{ds #>ls,' );
define( 'LOGGED_IN_SALT',   'E1v?gPMQIWGFVeBYwe<cW.NqAl;[>-0:N,8%]J|<ZX5rS5jh!JU8rF2f7B7^O{$t' );
define( 'NONCE_SALT',       '+9nWo{@P|5n23Nk^l=*I%kl,-{LFeky<WB<5ti|XlNeChQSGyl.KA$r550=90^,~' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */



/** Constantes relevantes al web-service de Cooperación Seguros */
define('COOPSEG_CONFIG_GRANT_TYPE', 'client_credentials');
define('COOPSEG_CONFIG_CLIENT_ID', 'WEBINSTITUCIONAL');
define('COOPSEG_CONFIG_CLIENT_SECRET', 'EF453925-B6B3-4915-AD21-CA1BA7CBA84E');
define('COOPSEG_CONFIG_HOST_URL', 'wstest.cooperacionseguros.com.ar');
define('COOPSEG_ERRORES_DIR', 'errores');

/** Token */
define('COOPSEG_TOKEN_FILE', 'cache/token.txt');
define('COOPSEG_TOKEN_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicestest/token');

/** Vehículos */
define('COOPSEG_VEHICLES_BRANDS_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicestest/api/Marcas/ObtenerMarcas');
define('COOPSEG_VEHICLES_BRANDS_FILE_CARS', 'cache/marcas-coches.json');
define('COOPSEG_VEHICLES_BRANDS_FILE_BIKES', 'cache/marcas-motos.json');
define('COOPSEG_VEHICLES_MODELS_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicestest/api/Modelos/ObtenerModelosPorMarca');
define('COOPSEG_VEHICLES_YEARS_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Versiones/ObtenerAniosPorModelo');
define('COOPSEG_VEHICLES_VERSIONS_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Versiones/ObtenerVersionesPorModeloAnio');
define('COOPSEG_VEHICLES_VERSIONS_CATBRANDYEAR_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Versiones/ObtenerVersionesPorCategoriaMarcaAnio');
define('COOPSEG_VEHICLES_ACCESORIES_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Accesorios/ObtenerAccesorios');
define('COOPSEG_VEHICLES_QUOTES_URL', 'https://wstest.cooperacionseguros.com.ar/cmpservicestest/api/Cotizacion/Automotor/');
define('COOPSEG_VEHICLES_CARGAR_INSPECCION_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Inspecciones/Cargar');
define('COOPSEG_LEADS_GET_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Lead/GetLead');

/** Ubicación */
define('COOPSEG_PLACES_ZIPCODES_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/CodigosPostales/ObtenerCodigosPostalesParaCotizador');
define('COOPSEG_PLACES_ZIPCODES_FILE', 'cache/ubicaciones.json');
define('COOPSEG_PLACES_DB_TABLE', 'coopseg_places');

/** Vida */
define('COOPSEG_LIFE_QUOTES_URL', 'https://wstest.cooperacionseguros.com.ar/cmpservicesTest/api/Cotizacion/Vida');

/** Productores */
define('COOPSEG_PRODUCERS_URL', 'https://ws.cooperacionseguros.com.ar/webservicecmp/api/ObtenerProductoresWebCorp');
define('COOPSEG_SUGGEST_PRODUCERS_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Productor/ObtenerProductoresSugeridos');

/** Quotes */
define('COOPSEG_QUOTE_DIR', 'quotes');
define('COOPSEG_QUOTE_IMAGES_DIR', '/uploads');
define('COOPSEG_QUOTE_IMAGES_URL', '/wp-content/themes/cooperacionseguros-theme/uploads/');

/** Socios */
define('COOPSEG_CUSTOMER_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Clientes/ObtenerSocioPorDNISexo');

/** Suscribir */
define('COOPSEG_SUSCRIBIR_URL', 'https://wstest.cooperacionseguros.com.ar/cmpservicestest/api/propuesta/suscribir');
define('COOPSEG_VALIDAR_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Poliza/ValidarPropuesta');
define('COOPSEG_VEHICLES_CEDULA_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/CmpGoogle/ExtraerInformacionCedulaVerde');

/** ePagos */
define('COOPSEG_CREAR_PREFERENCIA_PAGO', 'https://wstest.cooperacionseguros.com.ar/cmpservicestest/api/PreferenciaPagoOnline');
define('COOPSEG_PAGOS_URL_SUCCESS', 'https://webtest.cooperacionseguros.com.ar/checkout/?payment=success');
define('COOPSEG_PAGOS_URL_FAILURE', 'https://webtest.cooperacionseguros.com.ar/checkout/?payment=failure');
define('COOPSEG_PAGOS_URL_PENDING', 'https://webtest.cooperacionseguros.com.ar/checkout/?payment=pending');
define('COOPSEG_PAGOS_USUARIO', 'VENTADIRECTA');

/** Leads */
define('COOPSEG_LEADS_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Lead/GrabarLead');

/** Reclamos de terceros */
define('COOPSEG_CONFIG_TERCEROS_CLIENT_ID', 'RECLAMOTERCERO');
define('COOPSEG_CONFIG_TERCEROS_CLIENT_SECRET', '85B9ECFA-AE2D-42E0-AD23-3D126F625443');
define('COOPSEG_TOKEN_TERCEROS_FILE', 'cache/tokenTerceros.txt');
define('COOPSEG_RECLAMOS_PATENTES', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/ReclamosTerceros/ValidarPatente/');
define('COOPSEG_RECLAMOS_CONSULTA', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/ReclamosTerceros/ObtenerInformacionBasica/');
define('COOPSEG_RECLAMOS_AGREGAR', 'https://wstest.cooperacionseguros.com.ar/cmpservicestest/api/ReclamosTerceros/');
define('COOPSEG_RECLAMOS_INSPECCION', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Inspecciones/ReclamoTercero');
define('COOPSEG_RECLAMOS_DIR', 'reclamos');



/** All-In-One WP Migration */

@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
               define('ABSPATH', dirname( __FILE__ ) . '/');
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

/** tabla para loguear accesos al mapa de productores */
define('COOPSEG_PRODUCERS_DB_LOGGER', 'coopseg_map_logger');