<?php 
    //Acest fisier va interctiona cu /models si avand in vedere ca acesta va fi REST API va fi acesat prin HTTP 
    //trbuie sa adaugam antene(headers);
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');

    //Includem fisierele de care avem nevoie
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Insantiem un obiect pentru Database si executam o conextiune;
    $database = new Database();
    $db       = $database->connect();

    //Instantiem un obiect din fisierul post(nu se refera la un POST request);
    $category = new Category($db);

    //GET{id}
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get postare
    $category->read_single();

    //creaza un aray
    $cat_arr = [
        'id' => $category->id,
        'name' => $category->name,
        
    ];

    //Transforma in JSON
    print_r(json_encode($cat_arr));
?>