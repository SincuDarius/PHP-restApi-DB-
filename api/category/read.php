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

    //Query-ul pentru $post;
    $result = $category->read();
    //Luam numarul randului
    $num = $result->rowCount();

    //Verificam daca exista vreo categorie
    if($num > 0){
        //o lista a postari deoarece o postare contine mai multe chesti
        $cat_arr = []; //acelasi lucru ca si array(); array()===[];
        $cat_arr['data'] = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $cat_item = [
                'id'   =>$id,
                'name' => $name,
            ];
            //acestea trbuie puse in ['data']
            array_push($cat_arr['data'], $cat_item);
        }
        // trebuie sa returnam un JSON
        echo json_encode($cat_arr);

    } else {
        echo json_encode(['message'=>'no categories found']);
    }
?>