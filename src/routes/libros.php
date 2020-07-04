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
    $resultado = null;
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

$app->post('/api/books/new', function ($request, $response, $args) {
//Recoleccion de datos POST
  $data = json_decode($request->getBody()->getContents());
//Mapeo de datos en variables
  $title = $data->title;
  $author = $data->author;
  $price = $data->price;

  try {

    $db=new DatabaseMysql();
    $db=$db->ConnectionDB();
    $prepare=$db->prepare("INSERT INTO `books` (`Title`, `Author`, `Price`) VALUES (?, ?, ?);");
    $book =array($title, $author, $price);
    $prepare->execute($book);
    echo json_encode("{'Status':{ 'Message':'Se han insertado el nuevo libro','Code':'201'}");
    
  } catch (PDOException $e) {
    echo "{'Error':'No se pudieron insertar los datos'} +$e.getMessage().";
  }

  return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});
