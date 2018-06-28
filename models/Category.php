<?php


Class Category {
    //Baza de date
    private $conn;
    private $table = 'categories';
        
    //Proprietati pentru Categories;
    public $id;
    public $name;
    public $created_at;

    //Construcorul pentru Database;
    public function __construct($db){
        $this->conn = $db;

    }
    //Metoda GET listeaza returneaza tot ce avem in DB (in tabela category);
    public function read(){
        //creaza query-ul;
            $query = 'SELECT 
                        id,
                        name,
                        created_at
                    FROM ' . $this->table . '
                    ORDER BY created_at DESC';
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
                        id,
                        name,
                        created_at
                    FROM ' . $this->table . '
                    WHERE 
                        id = ?
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
        $this->name = $row['name'];
    }


    //Metoda POST creaza o noua postare;    
    public function create(){
        //Queriul pentru inerare;
        $query = 'INSERT INTO ' . $this->table . '
                    SET 
                        name = :name';
        //Pregatirea unei afirmati 'statement';
            $stmt = $this->conn->prepare($query);

        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
       
        //bind data
        $stmt->bindParam(':name', $this->name);
       
        //Executarea query-ului
        if ($stmt->execute()) {
            return TRUE;
        } else {
        //printeza o eroare daca ceva nu functioneaza cum trbuie;
        printf("Error: %s.\n", $stmt->error);
        return false;
        }
    }
    
    //Metoda PUT face update la o categoire deja existenta;    
    public function update(){
        //Query-ul pentru inserare;
        $query = 'UPDATE ' . $this->table . '
                    SET 
                        name = :name   
                    WHERE
                        id = :id';
        //Pregatirea unei afirmati 'statement';
            $stmt = $this->conn->prepare($query);

        //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

        //bind data
            $stmt->bindParam(':id', $this->id);
         $stmt->bindParam(':name', $this->name);
        
        //Executarea query-ului
        if ($stmt->execute()) {
            return TRUE;
        }
        // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
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