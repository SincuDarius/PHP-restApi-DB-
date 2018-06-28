<?php 
    Class Post {
        //Chesti pentru legatura cu Clasa Database;
            private $conn;
            private $table = 'posts';
        
        //Proprietati pentru Post;
            public $id;
            public $cadegory_id;
            public $cadegory_name;
            public $title;
            public $body;
            public $author;
            public $created_at;

        //Construcorul pentru Database;
            public function __construct($db){
                $this->conn = $db;
            }
        
        //Metoda GET listeaza returneaza tot ce avem in DB;
            public function read(){
                //creaza query-ul;
                    $query = 'SELECT 
                                c.name as category_name,
                                p.id,
                                p.category_id,
                                p.title,
                                p.body,
                                p.author,
                                p.created_at
                            FROM
                                '.$this->table . ' p
                            LEFT JOIN 
                                categories c ON p.category_id = c.id
                            ORDER BY
                                p.created_at DESC';
            //Pregatirea unei afirmati 'statement';
                $stmt = $this->conn->prepare($query);
            //Executarea query-ului
                $stmt->execute();
                
                return $stmt;
            }
        
        //Metoda GET{id} listeaza in functie de id;
            public function read_single(){
                //creaza query-ul;
                    $query = 'SELECT 
                                c.name as category_name,
                                p.id,
                                p.category_id,
                                p.title,
                                p.body,
                                p.author,
                                p.created_at
                            FROM
                                '.$this->table . ' p
                            LEFT JOIN 
                                categories c ON p.category_id = c.id
                            WHERE
                                p.id = ?
                            LIMIT 0,1';
            //Pregatirea unei afirmati 'statement';
                $stmt = $this->conn->prepare($query);
            //Gasirea Id
                $stmt->bindParam(1, $this->id);
            //Executarea query-ului
                $stmt->execute();
            //selectam ce sa coloana sa aducem din baza de date    
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //numele coloanelor (setarea proprietatilor);
                $this->title = $row['title'];
                $this->body = $row['body'];
                $this->author = $row['author'];
                $this->category_id = $row['category_id'];
                $this->category_name = $row['category_name'];
            }

        //Metoda POST creaza o noua postare;    
            public function create(){
                //Queriul pentru inerare;
                $query = 'INSERT INTO ' . $this->table . '
                            SET 
                                title = :title,   
                                body = :body,
                                author = :author,
                                category_id = :category_id';
                //Pregatirea unei afirmati 'statement';
                    $stmt = $this->conn->prepare($query);

                //clean data
                $this->title = htmlspecialchars(strip_tags($this->title));
                $this->body = htmlspecialchars(strip_tags($this->body));
                $this->author = htmlspecialchars(strip_tags($this->author));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));

                //bind data
                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':body', $this->body);
                $stmt->bindParam(':author', $this->author);
                $stmt->bindParam(':category_id', $this->category_id);

                //Executarea query-ului
                if ($stmt->execute()) {
                    return TRUE;
                } else {
                //printeza o eroare daca ceva nu functioneaza cum trbuie;
                printf("Error: %s.\n", $stmt->error);
                return false;
                }
            }

        //Metoda PUT face update la o postare deja existenta;    
        public function update(){
            //Query-ul pentru inserare;
            $query = 'UPDATE ' . $this->table . '
                        SET 
                            title = :title,   
                            body = :body,
                            author = :author,
                            category_id = :category_id
                        WHERE
                            id = :id';
            //Pregatirea unei afirmati 'statement';
                $stmt = $this->conn->prepare($query);

            //clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);


            //Executarea query-ului
            if ($stmt->execute()) {
                return TRUE;
            } else {
            //printeza o eroare daca ceva nu functioneaza cum trbuie;
            printf("Error: %s.\n", $stmt->error);
            return false;
            }
        }

        //Delete a post
        public function delete(){
            //Query-ul pentru stergere;
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
      
            //Pregatirea unei afirmati 'statement';
            $stmt = $this->conn->prepare($query);

            //Clear data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind id
            $stmt->bindParam(':id', $this->id);

            //Executarea query-ului
            if ($stmt->execute()) {
                return TRUE;
            } else {
                 //printeza o eroare daca ceva nu functioneaza cum trbuie;
                printf("Error: %s.\n", $stmt->error);
            return false;
            }
        }
    }
?>