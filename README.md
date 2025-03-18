# Ecommerce - Tienda Online Básica

Este proyecto es una aplicación web de ecommerce desarrollada en PHP con una arquitectura MVC (Modelo-Vista-Controlador). Permite a los usuarios navegar por un catálogo de productos y a los administradores gestionar productos y ver estadísticas básicas. Está diseñada para ser simple, extensible y fácil de usar.

## Características

### Para Usuarios
- **Catálogo de Productos**: Lista de productos filtrables por nombre, categoría, precio mínimo y máximo, con paginación (6 productos por página).
- **Imágenes**: Soporta URLs externas y una imagen por defecto (`default.jpg`) almacenada en `/ecommerce/uploads/`.
- **Stock**: Solo muestra productos con stock mayor a 0 en el catálogo público.
- **Carrito**: Botón "Agregar al carrito" con notificaciones (funcionalidad básica implementada vía JavaScript/AJAX).

### Para Administradores
- **Gestión de Productos (CRUD)**:
  - Crear, editar y eliminar productos con campos: nombre, descripción, precio, stock, categoría e imagen (URL o por defecto).
  - Lista filtrable de productos con paginación, incluyendo productos con stock 0.
- **Estadísticas Básicas**:
  - Cantidad total de pedidos.
  - Productos más vendidos (top 5 por unidades vendidas, sin filtro por estado de pedido).

## Requisitos

- **PHP**: 7.4 o superior
- **Servidor Web**: Apache (recomendado con XAMPP o similar)
- **Base de Datos**: MySQL o MariaDB
- **Dependencias**: Bootstrap 5 (incluido vía CDN en las vistas)

## Estructura del Proyecto

```
ecommerce/
├── config/
│   └── database.php        # Configuración de la conexión a la base de datos (PDO)
├── controllers/
│   ├── AdminController.php # Controlador para el panel de administración
│   └── ProductController.php # Controlador para el catálogo público
├── models/
│   ├── Category.php        # Modelo para categorías
│   └── Product.php         # Modelo para productos y estadísticas
├── views/
│   ├── admin/
│   │   ├── create.php      # Vista para crear productos
│   │   ├── edit.php        # Vista para editar productos
│   │   ├── index.php       # Vista principal del panel de admin
│   │   └── stats.php       # Vista para estadísticas
│   ├── layouts/
│   │   ├── header.php      # Encabezado común (HTML + navegación)
│   │   └── footer.php      # Pie de página común
│   └── products/
│       └── index.php       # Vista del catálogo público
├── uploads/
│   └── default.jpg         # Imagen por defecto para productos
└── index.php               # Punto de entrada de la aplicación
```

## Instalación

1. **Clonar o Descargar el Proyecto**:
   - Descarga el código o clona el repositorio en tu servidor local (por ejemplo, `C:\xampp\htdocs\ecommerce`).

2. **Configurar la Base de Datos**:
   - Crea una base de datos en MySQL (por ejemplo, `ecommerce`).
   - Importa el siguiente esquema SQL:

     ```sql
     CREATE TABLE categories (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(100) NOT NULL
     );

     CREATE TABLE products (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(100) NOT NULL,
         description TEXT NOT NULL,
         price DECIMAL(10,2) NOT NULL,
         stock INT NOT NULL,
         category_id INT,
         image VARCHAR(255) DEFAULT 'default.jpg',
         FOREIGN KEY (category_id) REFERENCES categories(id)
     );

     CREATE TABLE orders (
         id INT AUTO_INCREMENT PRIMARY KEY,
         user_id INT,
         total DECIMAL(10,2) NOT NULL,
         status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
         shipping_info TEXT,
         order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         INDEX (user_id)
     );

     CREATE TABLE order_details (
         id INT AUTO_INCREMENT PRIMARY KEY,
         order_id INT,
         product_id INT,
         quantity INT NOT NULL,
         price DECIMAL(10,2) NOT NULL,
         INDEX (order_id),
         INDEX (product_id),
         FOREIGN KEY (order_id) REFERENCES orders(id),
         FOREIGN KEY (product_id) REFERENCES products(id)
     );
     ```

3. **Configurar `database.php`**:
   - Edita `/config/database.php` con tus credenciales de MySQL:

     ```php
     <?php
     class Database {
         private $host = 'localhost';
         private $db_name = 'ecommerce';
         private $username = 'root';
         private $password = '';
         private $conn;

         public function getConnection() {
             $this->conn = null;
             try {
                 $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                 $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             } catch (PDOException $e) {
                 echo "Error de conexión: " . $e->getMessage();
             }
             return $this->conn;
         }
     }
     ?>
     ```

4. **Subir la Imagen por Defecto**:
   - Coloca una imagen llamada `default.jpg` en `/ecommerce/uploads/`. Asegúrate de que el directorio tenga permisos de escritura si planeas subir más imágenes.

5. **Iniciar el Servidor**:
   - Usa XAMPP o un servidor similar y apunta tu navegador a `http://localhost/ecommerce/`.

## Uso

- **Catálogo Público**: `http://localhost/ecommerce/` (controlador `ProductController`, acción `index`)
- **Panel de Admin**: `http://localhost/ecommerce/index.php?controller=admin&action=index` (requiere autenticación de admin)

## Contribuciones

Si deseas contribuir, crea un *pull request* o reporta problemas en el repositorio.
