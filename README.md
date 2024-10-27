# Projecte de Gestió d'Usuaris
## Daiel Torres Sanchez

Aquest projecte permet gestionar usuaris i articles mitjançant funcionalitats CRUD (crear, llegir, actualitzar, eliminar). Inclou sistemes d'inici de sessió, registre, recuperació de contrasenyes i recordatori d'usuari mitjançant cookies.

## Descripció General

Un sistema que permet la creació i administració d'usuaris, així com la inserció i modificació d'articles. A més, compta amb un sistema d'expiració de sessions i gestió de cookies per recordar els usuaris durant l'autenticació.

### Tecnologies Utilitzades

-  **PHP**: Llenguatge principal per al backend i la lògica del projecte.

-  **MySQL**: Base de dades per emmagatzemar usuaris i articles.

-  **PHPMailer**: Biblioteca per gestionar l'enviament de correus electrònics.

-  **HTML/CSS**: Estructura i disseny de la interfície.

## Canvis Recents

-  **Data**: 27/10/2024

-  **Descripció de canvis**:

- Correcció de problemes de numeració d'ID en els articles.

- Afegit l'apartat per modificar cada article.

- Implementació d'expiració de sessions automàtiques per inactivitat.

- Implementació de funcionalitats de cookies per recordar els usuaris.

## Estructura del Projecte

```plaintext
/projecte
│
├── Controlador
│   ├── db_connection.php # Fitxer de connexió a la base de dades
│   ├── id_manager.php # Funcions per gestionar i reajustar els IDs dels articles
│   ├── inserir.php # Controlador per inserir nous articles
│   ├── esborrar.php # Controlador per eliminar articles
│   └── modificar.php # Controlador per modificar articles
│
├── Estils
│   └── estils.css # Fitxer CSS amb estils per al projecte
│
├── PHPMailer # Carpeta per gestionar l'enviament de correus electrònics
│   ├── Exception.php # Classe d'excepcions per PHPMailer
│   ├── PHPMailer.php # Classe principal de PHPMailer
│   └── SMTP.php # Classe per a la configuració SMTP
│
├── Login # Carpeta de controladors i vistes relacionades amb l'inici de sessió
│   ├── login.php # Pàgina d'inici de sessió
│   ├── logout.php # Controlador per tancar sessió
│   ├── recover_password.php # Pàgina per recuperar la contrasenya
│   └── register.php # Pàgina per registrar un nou usuari
│
├── Vista # Carpeta amb fitxers de vistes HTML per formularis i seccions estàtiques
│   ├── inserir.html # Formulari HTML per afegir nous articles
│   ├── modificar.html # Formulari HTML per modificar articles
│   └── login.html # Formulari d'inici de sessió
│
└── index.php # Pàgina principal del projecte
```

### Descripció de Carpetes i Fitxers

-  **Controlador/**: Scripts PHP per a la gestió d'operacions CRUD i connexió a la base de dades.

-  `db_connection.php`: Connexió amb la base de dades MySQL.

-  `id_manager.php`: Funcions de gestió i reajustament d'ID.

-  `inserir.php`: Controlador per inserir articles.

-  `esborrar.php`: Controlador per eliminar articles.

-  `modificar.php`: Controlador per modificar articles.

-  **Estils/**: Fitxers d'estils CSS.

-  **PHPMailer/**: Biblioteques per enviar correus electrònics.

-  **Login/**: Funcions i vistes relacionades amb l'inici de sessió i recuperació de comptes.

-  `login.php`: Pàgina d'inici de sessió.

-  `logout.php`: Controlador de tancament de sessió.

-  `recover_password.php`: Pàgina per a la recuperació de contrasenya.

-  `register.php`: Registre de nous usuaris.

-  **Vista/**: Formularis HTML per a operacions d'inserció, modificació i gestió d'usuari.

## Instal·lació

1. Clonar el repositori en el servidor local o de producció.

2. Configurar la connexió a la base de dades a `Controlador/db_connection.php`.

3. Importar el fitxer SQL proporcionat per crear les taules a MySQL.

4. Assegurar-se de configurar correctament els fitxers de PHPMailer per a l'enviament de correus.

## Ús

-  **Inici de sessió**: A través de `Login/login.php`.

-  **Gestió d'Articles**:

-  **Inserir**: Formulari a `Vista/inserir.html` gestionat per `Controlador/inserir.php`.

-  **Modificar**: Formulari a `Vista/modificar.html` gestionat per `Controlador/modificar.php`.

-  **Eliminar**: Acció a `Controlador/esborrar.php`.

## Contacte

Per a qualsevol pregunta o contribució al projecte, si us plau contacta amb **Daniel Torres Sánchez**.
