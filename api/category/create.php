<?php 
    //Acest fisier va interctiona cu /models si avand in vedere ca acesta va fi REST API va fi acesat prin HTTP 
    //trbuie sa adaugam antene(headers);
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methods: POST');
    //('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Method, Authorization
    //  X-Requested-With  ');

    //Includem fisierele de care avem nevoie
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Insantiem un obiect pentru Database si executam o conextiune;
    $database = new Database();
    $db       = $database->connect();

    //Instantiem un obiect din fisierul post(nu se refera la un POST request);
    $category = new category($db);

    //Get a row posted data
    $data = json_decode(file_get_contents("php://input"));

    $category->name = $data->name;
   
    //Creaza postarea

    if ($category->create()) {
        echo json_encode(['message'=>'Category Created']);
    } else {
        echo json_encode(['message'=>'Category not Created']);
    }
?>