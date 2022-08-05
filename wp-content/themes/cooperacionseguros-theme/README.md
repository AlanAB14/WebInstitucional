# Theme de Wordpress para Cooperación Seguros

Este documento incluye detalles para la instalación, configuración y desarrollo del theme creado a medida para Cooperación Seguros.

---

## Instalación

### Instalación de Wordpress

1. Configurar un dominio y un entorno con los [requisitos de Wordpress](https://wordpress.org/about/requirements/)
2. [Descargar Wordpress en Español](https://es-ar.wordpress.org/download/)
3. [Instalar Wordpress](https://wordpress.org/support/article/how-to-install-wordpress/) en el entorno creado

### Configuración del theme

1. Clonar el repositorio del theme dentro de `/wp-content/themes/` o copiar una versión actualizada del theme desde otro entorno
2. Activar el theme "Cooperación Seguros" desde "Apariencia" en el backend de Wodpress
3. Instalar y activar plugins utilizados en el desarrollo, desde el backend o descargando y subiendo los archivos via SFTP/SSH:

- Bloques de Gutenberg personalizados: [Lazy Blocks](https://wordpress.org/plugins/lazy-blocks/)
- Formularios de contacto: [Contact Form 7](https://wordpress.org/plugins/contact-form-7/)

4. Agregar todas las constantes utilizadas por la API al archivo `wp-config.php` (ver detalle de constantes al final de este documento)
5. Configurar permalinks en "Ajustes / Enlaces Permanentes". En principio, utilizamos la opción "Día y nombre", pero no afecta al desarrollo elegir otra. Al elegir alguna de las opciones, se activa también la estructura de permalinks general que permite utilizar slugs en páginas y posts.
6. Ejecutar script de instalación abriendo la ruta `/wp-content/themes/cooperacionseguros-theme/utils/install.php` en el browser (sólo visible para administradores logueados en Wordpress). El script de instalación hace algunas tareas básicas y se puede utilizar también como update:

- Instalación/actualización de ubicaciones (ciudades, provincias) con sus detalles, via Web Service de Cooperación Seguros
- Agregado de las categorías básicas que utilizamos en el desarrollo
- Agregado de todas las páginas básicas de contenido y de productos que utilizamos en el desarrolo

### Configuración de contenidos

1. Revisar datos de configuración básicos del sitio en "Ajustes / Generales" (`/wp-admin/options-general.php`)
2. Revisar opciones específicas del thene en "Apariencia / Personalizar" (`/wp-admin/customize.php`)

- Identidad:
  - Confirmar nombre del sitio y descripción corta
  - Hay una versión del logo disponible en `assets/img/logo.png` dentro del theme. Hay que saltear el "crop" al guardarlo.
  - Hay una versión del ícono disponible en `assets/img/icon.png` dentro del theme.
- Opciones del sitio:
  - Los datos de contacto en Opciones del sitio se utilizan en diversos lugares, pero las redes sociales son opcionales
- Menús:
  - Crear menús (también puede hacerse luego desde "Apariencia / Menús")
    - Menú principal (ubicación "Primary"): Debe incluir las páginas y enlaces del menú principal que aparece en el header. Se puede ampliar y personalizar, pero en principio usamos estos ítems:
      - Página Home
      - Enlace personalizado "Seguros", con # de URL y `togglesubmenu seguros` en Clases CSS
      - Página Siniestros
      - Página Productores
      - Página Nosotros
      - Página Ayuda
      - Página Contacto
      - Enlace Personalizado, "Asegurados", con el URL de AOL y `asegurados` en Clases CSS
      - Enlace Personalizado, "Productores", con el URL de la intranet y `productores` en Clases CSS
    - Usuarios (ubicación "Usuarios"): Debe incluir los enlaces personalizados de la columna de Usuarios del footer.
    - Productores (ubicación "Productores"): Debe incluir los enlaces personalizados de la columna de Productores del footer.
- Ajustes de portada:
  - Definir para la portada una página estática y seleccionar luego las páginas correspondientes:
    - Página de inicio: Home
    - Página de entradas: Novedades

4. Instalar el importador de Wordpress en "Herramientas / Importar"
5. Importar bloques personalizados con el archivo disponible en `cooperacionseguros-theme/content/bloques.xml` (el plugin Lazy Blocks debe estar activado)
6. Revisar los contenidos de las páginas preinstaladas (ver detalle en la sección "Contenidos")
7. Revisar contenidos de las páginas de productos (ver detalle en la sección "Contenidos") y publicarlas, ya que por defecto están agregadas en borrador
8. Importar o cargar las noticias deseadas en "Posts"

---

## Contenidos

El instalador creará automáticamente las páginas que utiliza el sitio por defecto. En algunos casos los contenidos son dinámicos y vendrán precargados, en otros el contenido es personalizable.

### Páginas de contenidos creadas por el instalador

| Página        | slug          | Descripción                                                                                                                                                                                                                                                                                                                       |
| ------------- | ------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Ayuda         | ayuda         | Página con el FAQ. Hay que cargar manualmente sus contenidos. En principio, utilizamos bloques de grupo para mostrar las preguntas y respuestas manteniendo todas las herramientas del editor de Wordpress. Incluye la tabla de representantes maquetada de forma especial con el shortcode `[entidades-representantes-cono-sur]` |
| Checkout      | checkout      | Página vacía que utilizará automáticamente el template `page-checkout.php`, con todas las funciones del checkout de productos.                                                                                                                                                                                                    |
| Contacto      | contacto      | Página de Contacto. Hay que cargar manualmente sus contenidos. Puede incluir el shortcode `[mapa-de-oficinas]` para mostrar las oficinas y debería incluir el shortcode de algún formulario de contacto configurado con el plugin Contact Form 7                                                                                  |
| Contratar     | contratar     | Página vacía que utilizará automáticamente el template `page-contratar.php`, con todas las funciones de grabar leads para productos sin transacción.                                                                                                                                                                              |
| Home          | home          | Página de inicio. Hay que cargar manualmente sus contenidos. En principio, debe contener un bloque con el shortcode `[productos]`, también incluye `[siniestros]` y `[posts-recientes]`.                                                                                                                                          |
| No Disponible | no-disponible | Página que aparece cuando una cobertura no está disponible para el usuario. Hay que cargar manualmente su contenido, tiene una regla para que un bloque del tipo Cubrir ocupe todo el alto de la pantalla.                                                                                                                        |
| Nosotros      | nosotros      | Página con el "Acerca de". Hay que cargar manualmente sus contenidos.                                                                                                                                                                                                                                                             |
| Novedades     | novedades     | Página vacía que utilizará automáticamente el template para mostrar los posts del blog                                                                                                                                                                                                                                            |
| Productores   | productores   | Pagina vacía que utilizará automaticamente el template que muestra el mapa de búsqueda de productores                                                                                                                                                                                                                             |

### Páginas de productos creadas por el instalador

Las páginas de productos pueden incluir diferentes contenidos según su tipo, pero en su definición básica se utilizan de la siguiente forma:

#### Productos con planes dinámicos según el preguntador ("Autos y Pick-ups", "Motos", "Vida Individual")

- Bloque "Cubrir" con los titulares del encabezado y la foto del producto
- Bloque con el shortcode `[planes]`, que automáticamente incluye las funciones para mostrar los planes de cada caso y redirigir al checkout correspondiente.

#### Productos con lead, con contenidos editables en el backend

- Bloque "Cubrir" con los titulares del encabezado y la foto del producto
- Bloques con contenido, según la necesidad. Además de los bloques por defecto de Gutenberg tenemos estos bloques personalizados:
  - Bloque "Detalles de plan", tiene los campos para cargar Coberturas, Beneficios y Requisitos con nuestro diseño.
  - Bloque "Tabla de planes", tiene los campos para cargar Coberturas y Beneficios en tablas que comparan versiones de un plan en Básico, Medio y Full.
- Bloque con el shortcode `[contratar]`, que tomará los parámetros que ya tenemos del preguntador y, según el producto, definirá cómo guardar un lead y cómo mostrarle al usuario opciones de productor.

## Componentes

### Productos

- La información sobre los productos se encuentra en `/data/products.json`
- La información sobre los planes de coches se encuentra en `/data/plans-cars.json`
- La información sobre los planes de motos se encuentra en `/data/plans-bikes.json`
- La lógica para mostrar la botonera de productos se encuentra en `assets/js/productos.js` y depende de jQuery

### Oficinas

- El listado de oficinas que utiliza el mapa se encuentra en `/data/offices.json`

### Nacionalidades

- El listado de nacionalidades que utiliza el checkout se encuentra en `/data/nations.json`

### Mensajes de confirmación del checkout

Los mensajes del checkout son parte de una lógica compleja que no es editable, pero para facilitar los mensajes de confirmación (que son mayormente texto), se los separó en un fragmento específico del template que está ubicado en la siguiente ruta: `/wp-content/themes/cooperacionseguros-theme/template-parts/checkout/fragment-payment.php`

### Shortcodes

| Código                  | Descripción                                                                                  |
| ----------------------- | -------------------------------------------------------------------------------------------- |
| `[planes]`              | Incluye el bloque que puede mostrar los planes transaccionables con datos de POST            |
| `[contratar]`           | Incluye el botón que toma los datos para grabar el lead en los productos no transaccionables |
| `[productos]`           | Crea los elementos para que el javascript incluya el selector de productos                   |
| `[mapa-de-productores]` | Crea los elementos para que el javascript incluya el mapa de productores                     |
| `[siniestros]`          | Muestra el bloque para acceder a la información de siniestros o siniestrados                 |
| `[posts-recientes]`     | Muestra las últimas 3 noticias del blog                                                      |
| `[mapa-de-oficina]`     | Muestra un mapa con las oficinas de Cooperación Seguros                                      |

---

## API

Algunos métodos de la API se pueden utilizar via GET a través de los métodos documentados y también se puede usar via PHP incluyendo el archivo `api.php`, por ejemplo:

`require_once(get_template_directory() . '/api/api.php');`

## Constantes de configuración

Las constantes de configuración que requiere la API se definen por fuera del theme, ya que por seguridad se excluyen del repositorio y, por su naturaleza, estas constantes varían según el entorno (cambiando los usuarios, los URLs de desarrollo a los de producción, etc).

Siguiendo el estilo de Wordpress, definimos todas las constantes en el archivo `wp-config.php`, por ejemplo:
`- `COOPSEG_CONFIG_GRANT_TYPE', 'client_credentials');`

A continuación se listan todas las constantes utilizadas en el sitio.

### Constantes de configuración

- `COOPSEG_CONFIG_GRANT_TYPE`: Tipo de request
- `COOPSEG_CONFIG_CLIENT_ID`: Identificador del cliente
- `COOPSEG_CONFIG_CLIENT_SECRET`: Clave del cliente
- `COOPSEG_CONFIG_HOST_URL`: URL del host del web service
- `COOPSEG_ERRORES_DIR`: Directorio de logs de errores

### Constantes del servicio de tokens

- `COOPSEG_TOKEN_URL`: URL del servicio para obtener un token
- `COOPSEG_TOKEN_FILE`: Archivo en el que se cachea el token

### Constantes del servicio de ubicaciones

- `COOPSEG_PLACES_ZIPCODES_URL`: URL del servicio para obtener códigos postales
- `COOPSEG_PLACES_ZIPCODES_FILE`: Archivo en el que se guarda la versión cacheada del resultado
- `COOPSEG_PLACES_DB_TABLE`: Base de datos en la que se guarda la versión optimizada de las ubicaciones

### Constantes del servicio de vehículos

- `COOPSEG_VEHICLES_BRANDS_URL`: URL del servicio para obtener marcas de vehículos
- `COOPSEG_VEHICLES_BRANDS_FILE_CARS`: Archivo para cachear las marcas de coches
- `COOPSEG_VEHICLES_BRANDS_FILE_BIKES`: Archivo para cachear las marcas de motos
- `COOPSEG_VEHICLES_MODELS_URL`: URL del servicio para obtener modelos por marca
- `COOPSEG_VEHICLES_YEARS_URL`: URL del servicio para obtener años por modelo
- `COOPSEG_VEHICLES_VERSIONS_URL`: URL del servicio para obtener versiones por modelo y por año
- `COOPSEG_VEHICLES_VERSIONS_CATBRANDYEAR_URL`: URL del servicio de versiones que funciona por categoría, marca y año
- `COOPSEG_VEHICLES_ACCESORIES_URL`: URL del servicio de accesorios
- `COOPSEG_VEHICLES_QUOTES_URL`: URL del servicio para obtener una cotización
- `COOPSEG_VEHICLES_CARGAR_INSPECCION_URL`: URL del servicio donde cargar las imágenes de la inspección

### Constantes del servicio de seguros de vida

- `COOPSEG_LIFE_QUOTES_URL`: URL del servicio para obtener cotización de seguros de vida

### Constantes del servicio de socios

- `COOPSEG_CUSTOMER_URL`: URL del servicio para obtener información del socio

### Constantes de checkout

- `COOPSEG_QUOTE_DIR`: Directorio donde se guardaran los archivos de cotización
- `COOPSEG_QUOTE_IMAGES_DIR`: Directorio donde se suben las imágenes de la cotización
- `COOPSEG_QUOTE_IMAGES_URL`: URL pública para acceder a las imagenes subidas
- `COOPSEG_SUGGEST_PRODUCERS_URL`: URL del webservice de sugerir productores
- `COOPSEG_SUSCRIBIR_URL`: URL del webservice de suscribir
- `COOPSEG_VALIDAR_URL`: URL del webservice de validar propuesta

### Constantes del servicio de ePagos

- `COOPSEG_PAGOS_USUARIO`: Usuario del webservice de ePagos
- `COOPSEG_CREAR_PREFERENCIA_PAGO`: URL del webservice para crear la preferencia de pago

### Constantes de productores

- `COOPSEG_PRODUCERS_URL`: URL del servicio para obtener productores por ubicación
- `COOPSEG_PRODUCERS_DB_LOGGER`: URL del servicio para obtener productores por ubicación

### Constantes de leads

- `COOPSEG_LEADS_URL`: URL del servicio para grabar leads
- `COOPSEG_LEADS_GET_URL`: URL del servicio para obtener info de leads

### Constantes de reclamos de terceros

- `COOPSEG_CONFIG_TERCEROS_CLIENT_ID`: Client ID para obtener el token de reclamos de terceros
- `COOPSEG_CONFIG_TERCEROS_CLIENT_SECRET`: Contraseña del Client ID
- `COOPSEG_TOKEN_TERCEROS_FILE`: Archivo en el que se cachea el token de terceros
- `COOPSEG_RECLAMOS_PATENTES`: URL del servicio para consultar estado de patentes
- `COOPSEG_RECLAMOS_CONSULTA`: URL del servicio para consultar el estado de un reclamo
- `COOPSEG_RECLAMOS_AGREGAR`: URL del servicio para agregar reclamos
- `COOPSEG_RECLAMOS_INSPECCION`: URL del servicio para agregar imágenes de reclamos
- `COOPSEG_RECLAMOS_DIR`: Directorio de logs de agregar reclamos

## API Interna

Estos son urls con "endpoints" que se pueden ejecutar desde el browser, en la ruta relativa a la API interna (`/wp-content/themes/cooperacionseguros-theme/api/`)

### Actualizar datos

#### /api.php?update=save_places

| Parámetros | Descripción                                                                                                                                      |
| ---------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
|            | Busca las ubicaciones en el Web Service de Cooperación Seguros, vacía la base de datos local e inserta todos los resultados desde el Web Service |

#### /api.php?update=token

| Parámetros | Descripción                                            |
| ---------- | ------------------------------------------------------ |
|            | Busca un nuevo token para actualizar el token cacheado |

## Requerimientos de desarrollo

- Node + npm
- [Gulp](https://gulpjs.com/docs/en/getting-started/quick-start)

## Configuración de entorno de desarrollo

- Instalar dependencias de gulp: `sudo npm install --save-dev`
- Ejecutar `gulp` en la carpeta del theme para compilar y observar cambios en assets
