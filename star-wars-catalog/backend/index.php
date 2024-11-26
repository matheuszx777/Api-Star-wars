<?php
require 'db.php';

$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {
    case 'listar-filmes':
        include 'listar_filmes.php';
        break;
    case 'detalhes-filme':
        include 'detalhes_filme.php';
        break;
    default:
        echo json_encode(['erro' => 'Endpoint não encontrado']);

       
}
?>
