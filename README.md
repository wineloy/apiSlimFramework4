#API REST UTILIZANDO SLIM FRAMEWORK 

##Para que que puedas utilizar este proyecto, es necesario que cuentes con una instancia de MySQL, y que cuentes con la base de datos creada



#ENDPOINT 
##Mostrar Libros GET
##http://localhost/php/public/api/books
##Agregar Libros POST
##http://localhost/php/public/api/books/new
##toma en cuenta que para utilizar el endpoint anterior es necesario que mandes por el Body un Json con el titulo, el autor y el precio
##{
  "titulo":"Nuevo Libro",
  "Author":"Autor",
  "Precio":1.00
}
