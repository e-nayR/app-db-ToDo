<?php
include 'functions.php';

$conn = dbConn();
try{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id'])){
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'ID não fornecido']);
        exit;
    }

    $id = (int)$data['id'];

    $query = "DELETE FROM tarefa WHERE id=$id;";
    $result = pg_query($conn, $query);

    if ($result) {
        echo json_encode(['success' => true, 'rows_affected' => pg_affected_rows($result)]);
    } else {
        echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}