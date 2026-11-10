<?php
require_once("classDatabase.php");

class ClassMiel {
    private ClassDatabase $db;
    private PDO $pdo;

    public function __construct() {
        $this->db = new ClassDatabase();
        $this->pdo = $this->db->getConnection();
    }

    // Insérer un nouveau miel
    public function addMiel(string $type, string $photo): bool {
        $type = trim($type);
        $photo = trim($photo);

        if ($type === '' || $photo === '') {
            return false;
        }

        if (strlen($type) > 255 || strlen($photo) > 255) {
            return false;
        }

        $sql = "INSERT INTO miel (type, photo)
                VALUES (:type, :photo)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'type' => $type,
            'photo' => $photo
        ]);
    }

    // Supprimer un miel à partir de son identifiant
    public function removeMiel(int $id): bool {
        if ($id <= 0) {
            return false;
        }

        $sql = "DELETE FROM miel WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        // true si une ligne a été supprimée
        return $stmt->rowCount() > 0;
    }

    public function getListMiels(): array {
        $sql = "SELECT id, type, photo
                FROM miel
                ORDER BY type";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
