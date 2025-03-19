<?php
function dbConn() {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

    if (!$conn) {
        die("Erro ao conectar ao banco de dados ❌");
    }
    return $conn;
}

// $query = "INSERT INTO tag(id, titulo) VALUES ($tag_titulo);"
// $query = "INSERT INTO tarefa(id, titulo, data_criado, data_final, entrege, tag) VALUES ($tarefa_titulo, $criado, $final, $entrege, $tag);"

// $query = "UPDATE tarefa SET $campo = $valor WHERE id=$id;"
// $query = "UPDATE tag SET titulo = $valor WHERE id=$id;"

// $query = "DELETE tag WHERE id=$id;"
// $query = "DELETE tafera WHERE id=$id;"

function consultarTarefas($conn) {
    try{
        $query = "SELECT t.id as id, t.entrege as entregue, t.titulo as titulo, t.data_final as data_final, ta.titulo as tag FROM tarefa as t JOIN tag as ta ON ta.id = t.tag ORDER BY data_final DESC;";
        $tarefas = [];
        $result = pg_query($conn, $query);
        while ($row = pg_fetch_assoc($result)) {
            $tarefas[] = $row;
        }
        return $tarefas;
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function consultarTags($conn) {
    try{
        $query = "SELECT * FROM tag;";
        $tags = [];
        $result = pg_query($conn, $query);
        while ($row = pg_fetch_assoc($result)) {
            $tags[] = $row;
        }
        return $tags;
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function consultarPorCategoria($conn,$tag_id) {
    try{
        $query = "SELECT t.id as id, t.titulo as titulo, t.data_final as data_final FROM tarefa as t WHERE tag=$tag_id ORDER BY data_final DESC;";
        $tarefas = [];
        $result = pg_query($conn, $query);
        while ($row = pg_fetch_assoc($result)) {
            $tarefas[] = $row;
        }
        return $tarefas;
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function criarTarefa($conn, $data) {
    $tarefa_titulo = isset($data['titulo_tarefa']) ? $data['titulo_tarefa'] : 'null';
    $criado = date("Y-m-d H:i:s");
    $final = isset($data['data_final']) ? $data['data_final'].' 00:00:00' : 'null';
    if ($final == ' 00:00:00'){
        $final = 'NULL';
    }
    $entregue = isset($data['status_tarefa']) ? $data['status_tarefa'] : 'false';
    $tag = isset($data['categoria']) ? $data['categoria'] : 'null';
    try{
        $query = "INSERT INTO tarefa(titulo, data_criado, data_final, entrege, tag) VALUES ('$tarefa_titulo', '$criado', $final, '$entregue', '$tag');";
        $result = pg_query($conn, $query);
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
};
