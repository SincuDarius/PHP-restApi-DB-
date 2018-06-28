<?php 
    //Acest fisier va interctiona cu /Models si avand in vedere ca acesta va fi REST API va fi acesat prin HTTP 
    //trbuie sa adaugam antene(headers);
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    //header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Method, Authorization
    //        X-Requested-With  ');

    //Includem fisierele de care avem nevoie
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Insantiem un obiect pentru Database si executam o conextiune;
    $database = new Database();
    $db       = $database->connect();

    //Instantiem un obiect din fisierul category (nu se refera la un PUT request);
    $category  = new Category($db);

    //Get a row posted data
    $data = json_decode(file_get_contents("php://input"));

    //SET ID
    $category ->id = $data->id;

    $category ->name = $data->name;
   

    //Update postarea
    if ($category->update()) {
        echo json_encode(['message'=>'Category updated']);
    } else {
        echo json_encode(['message'=>'Category not updated']);
    }
?>