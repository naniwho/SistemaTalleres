<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\DB\ConnectionDB;

try {
    $con = ConnectionDB::getConnection();

    $stmt = $con->prepare("CALL ConsultarTallerPorID(:id)");
    $stmt->execute([':id' => 1]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($result);
    echo "</pre>";
} catch (\PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
