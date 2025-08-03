<?php
require_once '../vendor/autoload.php';

use App\DB\ConnectionDB;

$con = ConnectionDB::getConnection();
$stmt = $con->prepare("CALL ConsultarTallerPorID(:id)");
$stmt->execute([':id' => 1]);

$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($result);
echo "</pre>";
