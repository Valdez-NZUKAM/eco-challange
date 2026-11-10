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
    public function addMiel(string $type, string $photo, int $stock): bool {
    $type = trim($type);
    $photo = trim($photo);

    if ($type === '' || $photo === '' || $stock < 0) {
        return false;
    }

    if (strlen($type) > 255 || strlen($photo) > 255) {
        return false;
    }

    $sql = "INSERT INTO miel (type, photo, stock)
            VALUES (:type, :photo, :stock)";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        'type' => $type,
        'photo' => $photo,
        'stock' => $stock
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
        $sql = "SELECT id, type, photo, stock
        FROM miel
        ORDER BY type";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter ou retirer du stock : $delta = +1 ou -1
public function changerStock(int $id, int $delta): bool {
    if ($id <= 0) {
        return false;
    }

    // GREATEST(x, 0) empêche le stock de descendre sous 0
    // Exemple : stock 5, delta +1 -> GREATEST(6, 0) = 6
    // Exemple : stock 0, delta -1 -> GREATEST(-1, 0) = 0
    $sql = "UPDATE miel
            SET stock = GREATEST(stock + :delta, 0)
            WHERE id = :id";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        'delta' => $delta,
        'id' => $id
    ]);
}
}
?>
