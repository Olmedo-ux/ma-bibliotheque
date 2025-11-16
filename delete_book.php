<?php
require 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_panel.php?status=error_id");
    exit;
}

$bookId = $_GET['id'];

try {
    $sql = "DELETE FROM Livres WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$bookId]);

    header("Location: admin_panel.php?status=deleted");
    exit;

} catch (PDOException $e) {
    // Si la suppression échoue
    header("Location: admin_panel.php?status=error_delete");
    exit;
}

$conn = null;