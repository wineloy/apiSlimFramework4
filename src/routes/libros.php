<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->setBasePath("/php/public");


//Obtener los todos los clientes

$app->get('/api/books', function (Request $request, Response $response) {
  $sql = "SELECT * FROM books";

  try {
    $db = new DatabaseMysql();
    $db = $db->ConnectionDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0) {
      $libro = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($libro);
    } else {
      echo json_encode("No existen libros en la BBDD.");
    }
    $db = null;
    $resultado = null;
  } catch (PDOException $e) {
    echo '{"error" : {"text":' . $e->getMessage() . '}';
  }
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


//Recuperar los libros por ID

$app->get('/api/books/{id}', function (Request $request, Response $response) {
  $id_book = $request->getAttribute('id');


  if (!is_numeric($id_book)) {
    echo json_encode("{'Error': 'el Id introducido es invalido'}");
    return $response->withHeader('Content-type', 'application/json');
  }

  try {

    $db = new DatabaseMysql();
    $db = $db->ConnectionDB();
    $resultado = $db->prepare("SELECT * FROM books WHERE id_book= ?");
    //$resultado->bindParam(':book',$id_book);
    $resultado->execute([$id_book]);

    if ($resultado->rowCount() > 0) {
      $libro = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($libro);
    } else {
      echo json_encode('No hay libros con este id');
    }
    $resultado = null;
    $db = null;
  } catch (PDOException $e) {
    echo '{"error" : {"text":' . $e->getMessage() . '}';
  }
  return $response->withHeader('Content-type', 'application/json');
});

// Crear nuevo Libro cliente

$app->post('/api/books/new', function (Request $request, Response $response, $args) {
  //Recoleccion de datos POST
  $data = json_decode($request->getBody()->getContents());
  //Mapeo de datos en variables
  $title = $data->title;
  $author = $data->author;
  $price = $data->price;

  try {

    $db = new DatabaseMysql();
    $db = $db->ConnectionDB();
    $prepare = $db->prepare("INSERT INTO `books` (`Title`, `Author`, `Price`) VALUES (?, ?, ?);");
    $book = array($title, $author, $price);
    $prepare->execute($book);
    echo json_encode("{'Status':{ 'Message':'Se ha insertado el nuevo libro','Code':'201'}");

    $prepare = null;
    $db = null;
  } catch (PDOException $e) {
    echo "{'Error':'No se pudieron insertar los datos'} +$e.getMessage().";
  }

  return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});


//Editar Libro existente

$app->put('/api/books/edit/{id}', function (Request $request, Response $response) {

  //Obtengo el ID del libro a modificar
  $id_book = $request->getAttribute('id');
  //Obtengo los parametros del body
  $data = json_decode($request->getBody()->getContents());
  //Mapeo de datos en variables
  $title = $data->title;
  $author = $data->author;
  $price = $data->price;

  //Valido que el ususario ingrese un ID Correcto 
  if (!is_numeric($id_book)) {
    echo json_encode("{'Error': 'el Id introducido es invalido'}");
    return $response->withHeader('Content-type', 'application/json');
  }

  try {

    $db = new DatabaseMysql();
    $db = $db->ConnectionDB();
    //Preparo la consulta SQL para evitar Inyeccion SQL
    $prepare = $db->prepare("UPDATE books SET Title=?, Author=?,Price=? WHERE id_book=?");
    $book = array($title, $author, $price, $id_book);
    $prepare->execute($book);

    echo (json_encode("Libro editado correctamente"));

    $prepare = null;
    $db = null;
  } catch (PDOException $e) {
    echo "{'Error':'No se pudieron insertar los datos'} +$e.getMessage().";
  }
  return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});


$app->delete('/api/books/delete/{id}', function (Request $request, Response $response) {

  $id_book = $request->getAttribute('id');


  if (!is_numeric($id_book)) {
    echo json_encode("{'Error': 'el Id introducido es invalido'}");
    return $response->withHeader('Content-type', 'application/json');
  }


  try {

    $db = new DatabaseMysql();
    $db = $db->ConnectionDB();
    //Preparo la consulta SQL para evitar Inyeccion SQL
    $prepare = $db->prepare("DELETE FROM books WHERE id_book=?");
    $book = array($id_book);
    $prepare->execute($book);

    echo (json_encode("Libro Eliminado Correctamente"));

    $prepare = null;
    $db = null;
  } catch (PDOException $e) {
    echo "{'Error':'No se pudo eliminar el libro'} +$e.getMessage().";
  }
  return $response->withHeader('Content-Type', 'application/json')->withStatus(202);
});
