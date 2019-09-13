<?php
 
class connexion {
   // Members of class connexion
	private $bdd; // pdo de la base de données

    function __construct() {
        $this->connect_database();
    }

    public function getInstance() {
        return $this->bdd;
    }

    private function connect_database() {
		
	//Localhost
        $user =  'root';
        $password =  '';
        $host= 'localhost' ;
        $bd = 'bd_yoni_origine' ;

        
        // Database connection
        try {
            $connection_string = 'mysql:host='.$host.';dbname='.$bd.';charset=utf8';
            $connection_array = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );

            $this->bdd = new PDO($connection_string, $user, $password, $connection_array);
            //echo 'Database connection established';
        }
        catch(PDOException $e) {
            $this->bdd = null;
        }
    }   
}
?>
