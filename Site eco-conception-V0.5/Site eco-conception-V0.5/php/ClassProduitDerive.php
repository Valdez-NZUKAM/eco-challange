<?php
require_once("classDatabase.php");
class ClassProduitDerive {

    private ClassDatabase $db;

    public function __construct() {
        $this->db = new ClassDatabase();
    }

    public function getAll():array {
        $dbConnect = $this->db->getConnection();
        $query = "SELECT * FROM produitderive";
        $stmt = $dbConnect->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db->disconnect();
        return $result;
    }
}
?>