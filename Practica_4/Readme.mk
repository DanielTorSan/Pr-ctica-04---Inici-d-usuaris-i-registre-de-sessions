# Proyecto de Gestión de Artículos

**Autor:** Daniel Torres Sanchez

Este proyecto es una aplicación web básica para gestionar artículos. Permite insertar, modificar, eliminar y mostrar artículos almacenados en una base de datos. Cada artículo se identifica mediante un DNI y tiene un cuerpo de texto, un título y un ID.

## Estructura del Proyecto

```bash
/  (directorio raíz)
│
├── Estils/
│   └── estils.css                # Archivo CSS con los estilos del proyecto.
│
├── Vista/
│   ├── index.html                # Página principal con el formulario para interactuar con la aplicación.
│   ├── mostrar.html              # Página para mostrar los detalles de un artículo.
│   ├── modificar.html            # Página con el formulario para modificar un artículo.
│   ├── inserir.html              # Página con el formulario para insertar un nuevo artículo.
│   ├── esborrar.html             # Página con el formulario para borrar un artículo.
│   ├── mostrar_articles.html      # Página que presenta todos los artículos en una lista.
│
├── insertar.php                   # Script PHP que inserta un nuevo artículo en la base de datos.
├── modificar.php                 # Script PHP para modificar un artículo existente.
├── esborrar.php                  # Script PHP para eliminar un artículo de la base de datos.
├── buscar_article.php            # Script PHP para buscar un artículo por su DNI.
├── mostrar_detalls_article.php   # Script PHP que muestra los detalles de un artículo en formato tabla HTML.
├── db_connection.php             # Script PHP que gestiona la conexión a la base de datos.
├── id_manager.php                # Script PHP que gestiona los IDs de los artículos (obtener y reajustar IDs).
├── mostrar_articles.php           # Script PHP que muestra todos los artículos de la base de datos.
└── index.php                     # Script PHP principal que procesa las solicitudes del usuario.
```
## Funcionalidad de Cada Archivo

### Estils/estils.css
**Función:** Define los estilos CSS de la aplicación, como la apariencia de los formularios y tablas, para darle un diseño consistente y organizado.

### Vista/index.html
**Función:** Página principal con un formulario para realizar acciones (insertar, modificar, eliminar, mostrar artículos). Redirige a las páginas específicas para cada acción.

### Vista/mostrar.html
**Función:** Página que presenta el resultado cuando se solicita mostrar un artículo por su DNI. Muestra los detalles en formato tabla.

### Vista/modificar.html
**Función:** Página con un formulario para modificar un artículo existente. Cambia el cuerpo (`cos`) y el título (`titol`) según los valores introducidos por el usuario, identificado por su DNI.

### Vista/inserir.html
**Función:** Página con un formulario para insertar un nuevo artículo en la base de datos. Recoge los datos del DNI, cuerpo y título del artículo.

### Vista/esborrar.html
**Función:** Página con un formulario para eliminar un artículo. Solicita el DNI del artículo que se quiere borrar.

### Vista/mostrar_articles.html
**Función:** Página que presenta todos los artículos almacenados en la base de datos en un formato de lista, permitiendo a los usuarios ver rápidamente los artículos disponibles.

### mostrar_articles.php
**Función:** Script PHP que consulta la base de datos y devuelve todos los artículos en un formato adecuado para ser mostrado en `mostrar_articles.html`.

### insertar.php
**Función:** Inserta un nuevo artículo en la base de datos con el DNI, cuerpo y título proporcionados. Utiliza `obtenirIDMinim()` para asignar el ID más bajo disponible.

### modificar.php
**Función:** Modifica los datos de un artículo existente. Cambia el cuerpo (`cos`) y el título (`titol`) según los valores introducidos por el usuario, identificado por su DNI.

### esborrar.php
**Función:** Elimina un artículo de la base de datos por su DNI. Después de la eliminación, reajusta los IDs de los artículos restantes mediante la función `reajustarIDs()`.

### buscar_article.php
**Función:** Busca un artículo en la base de datos utilizando el DNI como identificador. Retorna los detalles del artículo encontrado o `null` si no existe.

### mostrar_detalls_article.php
**Función:** Muestra los detalles de un artículo en una tabla HTML. Esta función se llama después de insertar, modificar o buscar un artículo, para visualizar los datos en el frontend.

### db_connection.php
**Función:** Gestiona la conexión a la base de datos mediante PDO (PHP Data Objects). Proporciona el acceso a la base de datos que será utilizado por las otras funciones del proyecto.

### id_manager.php
**Función:** Gestiona los IDs de los artículos. Tiene dos funciones principales:
- **`obtenirIDMinim()`**: Obtiene el ID más bajo disponible para insertar nuevos artículos.
- **`reajustarIDs()`**: Reorganiza los IDs de los artículos después de eliminar uno, asegurando que no queden huecos.

### index.php
**Función:** Es el archivo principal que gestiona la lógica de la aplicación. Recibe las solicitudes de los usuarios desde los formularios (insertar, modificar, borrar, mostrar) y ejecuta las funciones correspondientes de los otros scripts:
- Inserta, modifica, borra o busca artículos.
- Muestra mensajes de éxito o error según la operación realizada.
- Incluye las páginas HTML y archivos PHP necesarios para cada acción.

## Explicación sobre el Uso de los Archivos .php

Todos los archivos .php del proyecto son llamados desde **`index.php`**, que actúa como controlador principal de las acciones de los usuarios. Desde aquí, se recogen los datos enviados por los formularios de los diferentes archivos .html (como `inserir.html`, `modificar.html`, etc.) y se procesa la lógica necesaria con la ayuda de los scripts PHP correspondientes.

Por ejemplo:
- Cuando se envía el formulario para insertar un artículo, `index.php` llama a `insertar.php`.
- Cuando se envía el formulario para modificar un artículo, `index.php` llama a `modificar.php`.

Esto asegura que todas las operaciones estén centralizadas y gestionadas desde un solo lugar.

## Problema con el Auto-incremento de los IDs

Inicialmente, se detectó un problema con la gestión de los IDs de los artículos en la base de datos. Cuando se eliminaba un artículo, el ID eliminado quedaba vacío, y el siguiente artículo insertado obtenía un ID superior, creando huecos en la secuencia de IDs.

### Solución Implementada

Para solucionar este problema, se implementó una gestión manual de los IDs con dos funciones clave dentro del archivo `id_manager.php`:
1. **`obtenirIDMinim()`**: Esta función busca el valor de ID más bajo disponible para asegurar que, al insertar un nuevo artículo, este ocupe el primer espacio libre.
2. **`reajustarIDs()`**: Después de eliminar un artículo, esta función ajusta los IDs de los artículos restantes para eliminar cualquier vacío que quede, manteniendo así una secuencia continua de IDs.
