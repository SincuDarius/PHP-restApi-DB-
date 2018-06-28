<?php 
    //Acest fisier va interctiona cu /models si avand in vedere ca acesta va fi REST API va fi acesat prin HTTP 
    //trbuie sa adaugam antene(headers);
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');

    //Includem fisierele de care avem nevoie
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //Insantiem un obiect pentru Database si executam o conextiune;
    $database = new Database();
    $db       = $database->connect();

    //Instantiem un obiect din fisierul post(nu se refera la un POST request);
    $post = new Post($db);

    //GET{id}
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get postare
    $post->read_single();

    //creaza un aray
    $post_arr = [
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name,
    ];

    //Transforma in JSON
    print_r(json_encode($post_arr));
?>