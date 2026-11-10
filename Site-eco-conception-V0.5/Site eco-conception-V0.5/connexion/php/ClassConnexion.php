<?php
require_once("classDatabase.php");

class ClassConnexion {
    private ClassDatabase $db;

    public function __construct() {
        $this->db = new ClassDatabase();
    }

    public function connect($pLogin, $pPassword): bool {
        // Vérifier le type des données reçues
        if (!is_string($pLogin) || !is_string($pPassword)) {
            return false;
            exit;
        }else{
            
        }

        $login = trim($pLogin);
        $password = $pPassword;

        // Vérifier les champs
        if ($login === '' || $password === '') {
            return false;
            exit;
        }

        if (strlen($login) > 255 || strlen($password) > 1024) {
            return false;
            exit;
        }

        // Récupérer la connexion PDO
        $pdo = $this->db->getConnection();

        // Rechercher l'utilisateur uniquement par son login
        $sql = "SELECT login, motdepasse
                FROM utilisateur
                WHERE login = :login
                LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'login' => $login
        ]);

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe haché
        if ($utilisateur !== false && password_verify($password, $utilisateur['motdepasse'])){
            $result = true;
        }else{
            $result = false;
        }
        $this->db->disconnect();
        return $result;
    }
}
?>