
# 🚀 Flavio NFT

## 🌟 Descripción del Proyecto

Este proyecto es una plataforma funcional de **Marketplace de Tokens No Fungibles (NFT)** construida utilizando **PHP** bajo un patrón de arquitectura de **Front Controller** (`index.php`). El objetivo es simular las operaciones básicas de un mercado de activos digitales, permitiendo a los usuarios registrarse, explorar el *marketplace*, gestionar sus perfiles y realizar transacciones utilizando una billetera de saldo simulado.

## 🛠️ Tecnologías Clave

| Categoría | Tecnología |
| :--- | :--- |
| **Backend** | PHP (v8.0+) |
| **Base de Datos** | MySQL / MariaDB |
| **Arquitectura** | Patrón Front Controller (Routing en `index.php`) |
| **Frontend** | HTML, CSS (posiblemente Bootstrap), JavaScript |

---

## 📦 Estructura de Directorios

La aplicación sigue una convención MVC (Modelo-Vista-Controlador) simple centralizada por el *router* principal.
¡Aquí tienes el contenido del archivo README.md listo para que lo copies y pegues!

---

## ⚙️ Instalación y Configuración Local

Sigue estos pasos para poner en marcha el proyecto en un entorno local (como XAMPP, WAMP, o MAMP).

### 1. Requisitos

* Servidor Web (Apache recomendado).
* PHP 8.0 o superior.
* Servidor de Base de Datos (MySQL/MariaDB).

### 2. Clonar y Configurar

1.  Clona este repositorio o descarga los archivos.
    ```bash
    git clone 
    cd nombre-del-proyecto
    ```
2.  Crea la base de datos en tu servidor (ej. `tienda_virtual`).
3.  **Importa el Esquema SQL** que esta en alojada en la carpeta db
4.  Abre y configura la conexión a la base de datos en `model/conn.php` con tus credenciales:

    ```php
    Ejemplo de conexión a DB en conn.php
    $host = "localhost";
    $user = "tu_usuario_db"; 
    $pass = "tu_contraseña_db"; 
    $db = "tienda_virtual"; 
    ```

### 3. Ejecución

Accede al proyecto a través de tu navegador

---

## 🔑 Funcionalidades del Marketplace

La aplicación maneja las siguientes vistas controladas por el archivo `index.php`:

| Vista (Parámetro `?view=`) | Controlador | Descripción | ¿Requiere Auth? |
| :--- | :--- | :--- | :--- |
| `home` | `home_controller.php` | Página principal y listado de NFTs. | No |
| `login` / `register` | `login_controller.php` / `register_controller.php` | Módulos de autenticación. | No |
| `nft` | `nft_controller.php` | Visualización y compra de un NFT específico. | No |
| `profile` | `profile_controller.php` | Perfil del usuario y NFTs en posesión. | Sí |
| `cart` | `cart_controller.php` | Carrito de compras para finalizar la transacción. | Sí |
| `checkout` | `checkout_controller.php` | Proceso de pago y confirmación de compra. | Sí |
| `wallet` | `wallet_controller.php` | Recarga de saldo a la billetera virtual del usuario. | Sí |
| `create_post` | `post_controller.php` | Formulario para que los creadores suban nuevos NFTs. | Sí |
| `reports` | `reports_controller.php` | Módulo de estadísticas y movimientos de la plataforma. | Sí (Admin/Creator) |

---

## 🤝 Contribuciones

Si deseas mejorar este proyecto o reportar un *bug*, por favor:

1.  Haz un *Fork* de este repositorio.
2.  Crea una nueva rama (`git checkout -b feature/nombre-funcionalidad`).
3.  Realiza tus cambios.
4.  Envía un *Pull Request* claro y conciso.

---

## Autores

- [JesusMowo](https://github.com/JesusMowo)
- [CHR-35](https://github.com/CHR-35)

