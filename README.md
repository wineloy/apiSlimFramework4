# Pequeña Api Rest Crud de libros 

## Requisitos minimos para ejecutar esta api en tu servidor 
- Contar con una instancia de MySQL o MariaDB
- Tener la version 7.* de PHP en el servidor
- Contar con Postman curl o cualquier otro cliente http que permita realizar solicitudes
- Tener instalado composer 

## Pasos a realizar para ejecutar esta API 
1. Clonar o descargar este repositorio
2. Ejecutar el comando `composer install` en una terminal o consola de nuestro sistema
3. Ejecutar el script **books.sql** en nuestro gestor; se localiza en la ruta **src/config/DB** hay un archivo.
4. Realizar solicitudes con su cliente http y verificar funcionamiento
 
### Solucion a fallos 
Es posible que necesite cambiar el path de la aplicacion, este se encuentra en public/index.php
dependiendo de la ubicacion donde se ejecute sera o no necesario cambiarlo

## ENDPOINT 
### Mostrar Libros **GET**
http://yourhost/php/public/api/books
### Agregar Libros **POST**
http://yourhost/php/public/api/books/new
### Editar libro por medio de un id **PUT**
http://yourhost/php/public/api/books/1
### Eliminar libro por medio de un id **DELETE**
http://yourhost/php/public/api/books/delete/1

## Estructura Json para crear un libro 
Ejemplo esctructura para crear un nuevo libro 

```
{
    "Title" : "Clean Code: A Handbook of Agile Software Craftsmanship"
    "Author" : " Robert C. Martin",
    "Price" : "843.50"
}
```
**Nota:** Tanto para **editar** como para **eliminar**, al final del endpoint se tiene que mandar el **id** y este debe ser numerico del libro a tratar 

