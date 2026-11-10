<?php
require_once("classDatabase.php");

class ClassAccueil {
    private ClassDatabase $db;

    public function __construct() {
        $this->db = new ClassDatabase();
    }

    public function getPicture(): string {
        $dbConnect = $this->db->getConnection();
        $query = "SELECT photo FROM photoaccueil";
        $stmt = $dbConnect->query($query);
        $result = $stmt->fetchColumn(0);
        $this->db->disconnect();
        return $result;
    }

    public function getAltForPicture(): string {
        $dbConnect = $this->db->getConnection();
        $query = "SELECT alt FROM photoaccueil";
        $stmt = $dbConnect->query($query);
        $result = $stmt->fetchColumn(0);
        $this->db->disconnect();
        return $result;
    }

    public function getText(): string {
        $dbConnect = $this->db->getConnection();
        $query = "SELECT texte FROM texteaccueil";
        $stmt = $dbConnect->query($query);
        $result = $stmt->fetchColumn(0);
        $this->db->disconnect();
        return $result;
    }
}
?>