<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'cooperacion_local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '9-1q 6DLP,Y{,!X|}{}Ha30f0%c?4r52IJBodIrAlA4CP_LT6e Os_  D}0O]CeZ' );
define( 'SECURE_AUTH_KEY',  '5_<L9qUY<iVqbARZc;)Rx;FhWXfo#)v}IA[#O;QeYhZjOpWU/aG; iPjoOhq`D{0' );
define( 'LOGGED_IN_KEY',    'i>Tk)8O$g<Ke$!-tQbvIp91,]C?U9%3aJz+leV6J@ -uwd!.:% {11s_s1I4xv7S' );
define( 'NONCE_KEY',        'e;fX!b( upFF,k{$J8F1%K#W>BB}::2>s@RoE=}axz4-vxZ!?6iLckV`lZ&F|j=y' );
define( 'AUTH_SALT',        'V+1VwQg9&!teR9_G/:|MKd$Vi/j.v0_hXphPj&C`!5 T*jjm]]M~s,@P>BIF&Q(u' );
define( 'SECURE_AUTH_SALT', ' <9$*SF?n#)4^=I!>9XhD79EQb&MdK(XMriVmW>+.&)Tko|[fHR(MY.2y]jLU$:n' );
define( 'LOGGED_IN_SALT',   '*V]|[;Lx+BgyQl`?*nqM_io}`cr)n@P)]$25Ii))Y>k9LO^3DH$y=*!gT/V? <fN' );
define( 'NONCE_SALT',       'e_9(~1e2Jq(|BWk(Y*b4 EbL}6vAuIf7Rxz+2:)8b@b/}[8a.{g Q5;=G+baZMb{' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

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
define('COOPSEG_QUOTE_IMAGES_URL', '/cooperacion_local/wp-content/themes/cooperacionseguros-theme/uploads/');

/** Socios */
define('COOPSEG_CUSTOMER_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Clientes/ObtenerSocioPorDNISexo');

/** Suscribir */
define('COOPSEG_SUSCRIBIR_URL', 'https://wstest.cooperacionseguros.com.ar/cmpservicestest/api/propuesta/suscribir');
define('COOPSEG_VALIDAR_URL', 'https://wstest.cooperacionseguros.com.ar/cmpServicesTest/api/Poliza/ValidarPropuesta');

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


/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define('COOPSEG_PRODUCERS_DB_LOGGER', 'coopseg_map_logger');

