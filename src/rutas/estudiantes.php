<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// require '../config/conexion.php';


//Get, traes estudiantes

$app->get('/api/estudiantes', function(Request $req, Response $res){

    $connection = new conexion();
    $connect = $connection->get_conexion();

    try{
        $sql = "SELECT * FROM datos";
        $query = $connect->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0) {
            $data = $query->fetchAll();
            echo json_encode($data);
        }else{
            echo json_encode("No existen estudiantes en la BD");
        }
    }catch(Exception $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }

});

//Get, traer un estudiante

$app->get('/api/estudiante/{id}', function(Request $req, Response $res){

    $connection = new conexion();
    $connect = $connection->get_conexion();
    $id = $req->getAttribute('id');

    try{
        $sql = "SELECT * FROM datos WHERE id=?";
        $query = $connect->prepare($sql);
        $data = [$id];
        $query->execute($data);

        if ($query->rowCount() > 0) {
            $infoestudiante = $query->fetch();
            echo json_encode($infoestudiante);
        } else {
            echo json_encode("No existe un estudiante en la BD con esa ID");
        }
        
    }catch(Exception $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});


//Post Insertar un estudiante

$app->post('/api/estudiante/nuevo', function(Request $req , Response $res){

    $connection = new conexion();
    $connect = $connection->get_conexion();

    $nombres = $req->getParam('nombres');
    $apellidos = $req->getParam('apellidos');
    $cedula = $req->getParam('cedula');
    $telefono = $req->getParam('telefono');
    $email = $req->getParam('email');

    try{
        $sql = "INSERT INTO datos (nombres, apellidos, cedula, telefono, email) VALUES (?,?,?,?,?)";
        $query = $connect->prepare($sql);
        $data = [$nombres, $apellidos, $cedula, $telefono, $email];
        $query->execute($data);
        echo json_encode("creaste un nuevo estudiante");

    }catch(Exception $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }

});

//put Actualiza un Estudiante

$app->put('/api/estudiante/update/{id}', function(Request $req, Response $res){

    $connection = new conexion();
    $connect = $connection->get_conexion();
    $id = $req->getAttribute('id');

    $nombres = $req->getParam('nombres');
    $apellidos = $req->getParam('apellidos');
    $cedula = $req->getParam('cedula');
    $telefono = $req->getParam('telefono');
    $email = $req->getParam('email');

    try{
        $sql = "UPDATE datos SET nombres=?, apellidos=?, cedula=?, telefono=?, email=? WHERE id=? ";
        $query = $connect->prepare($sql);
        $data = [$nombres, $apellidos, $cedula, $telefono, $email, $id];
        $query->execute($data);
        echo json_encode("Estudiante Actualizado");

    }catch(Exception $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

$app->delete('/api/estudiante/destroy/{id}', function(Request $req, Response $res){

    $connection = new conexion();
    $connect = $connection->get_conexion();
    $id = $req->getAttribute('id');

    $nombres = $req->getParam('nombres');
    $apellidos = $req->getParam('apellidos');
    $cedula = $req->getParam('cedula');
    $telefono = $req->getParam('telefono');
    $email = $req->getParam('email');

    try{
        $sql = "DELETE FROM datos WHERE id=? ";
        $query = $connect->prepare($sql);
        $data = [$nombres, $apellidos, $cedula, $telefono, $email, $id];
        $query->execute($data);
        echo json_encode("El estudiante ha sido Eliminado Exitosamente");

    }catch(Exception $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});