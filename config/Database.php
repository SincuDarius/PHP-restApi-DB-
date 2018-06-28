<?php 

    Class Database {
        //Parametri Bazei de Date;
            private $host     = "localhost";
            private $db_name  = "myblog";
            private $username = "root";
            private $password = "1994darius";
            private $conn;

        //Conecsiunea bazei de date;
            public function connect(){
                $this->conn = NULL;

                try {
                    $this->conn = new PDO('mysql:host=' . $this->host . ';dbname='.$this->db_name,
                    $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch(PDOException $e) {
                    echo "Connection Error:" . $e->getMessage();
                }
                return $this->conn;
            }
        }

?>
