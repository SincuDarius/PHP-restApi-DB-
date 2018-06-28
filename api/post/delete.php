<?php 
    //Acest fisier va interctiona cu /models si avand in vedere ca acesta va fi REST API va fi acesat prin HTTP 
    //trbuie sa adaugam antene(headers);
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Method, Authorization
            X-Requested-With  ');

    //Includem fisierele de care avem nevoie
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //Insantiem un obiect pentru Database si executam o conextiune;
    $database = new Database();
    $db       = $database->connect();

    //Instantiem un obiect din fisierul post(nu se refera la un POST request);
    $post = new Post($db);

    //Get a row posted data
    $data = json_decode(file_get_contents("php://input"));

    //SET ID
    $post->id = $data->id;


    //Delete postarea
    if ($post->delete()) {
        echo json_encode(['message'=>'Post deleted']);
    } else {
        echo json_encode(['message'=>'Post not deleted']);
    }
?>