<?php 
    //Acest fisier va interctiona cu /Models si avand in vedere ca acesta va fi REST API va fi acesat prin HTTP 
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

    //Query-ul pentru $post;
    $result = $post->read();
    //Luam numarul randului
    $num = $result->rowCount();

    //Verificam daca exista vreo postare
    if($num > 0){
        //o lista a postari deoarece o postare contine mai multe chesti
        $posts_arr = []; //acelasi lucru ca si array(); array()===[];
        $posts_arr['data'] = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = [
                'id'           =>$id,
                'title'        => $title,
                'body'         => html_entity_decode($body),
                'author'       => $author,
                'category_id'  => $category_id,
                'category_name'=> $category_name,
            ];
            //acestea trbuie puse in ['data']
            array_push($posts_arr['data'], $post_item);
        }
        // trebuie sa returnam un JSON

        echo json_encode($posts_arr);

    } else {
        echo json_encode(['message'=>'no posts found']);
    }
?>