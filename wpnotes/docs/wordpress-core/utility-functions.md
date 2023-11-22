# Utility Functions

A continuacion se presentan una serie de funciones de utilidad general en wordpress

* **absint( ):** Convierte un valor en un número entero no negativo.

```php
absint( mixed $maybeint ): int
```

* **trailingslashit():** Agrega una barra diagonal (trailing slash) al final \
    Scripts utiles:
  * `const APP_DIRECTORY_URI = trailingslashit( get_template_directory_uri() )`
  * `const APP_DIRECTORY_PATH = trailingslashit( get_template_directory() )`

```php
trailingslashit( string $value ): string
```

**Implementation:**

```php
function trailingslashit( $value ) {
    return untrailingslashit( $value ) . '/';
}
```

```php
# Usage Examples
wp_enqueue_style( 'main-css', trailingslashit( get_template_directory_uri() ) . 'style.css' );
require trailingslashit( get_template_directory() ) . 'inc/custom-theme-functions.php';
```

* **untrailingslashit():** Elimina las barras diagonales (trailing slash) y las barras invertidas si existen.

```php
untrailingslashit( string $value ): string
```
