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

// $query = "SELECT * FROM tarefa;"
// $query = "SELECT * FROM tarefa WHERE tag=$tag_id"

// $query = "UPDATE tarefa SET $campo = $valor WHERE id=$id;"
// $query = "UPDATE tag SET titulo = $valor WHERE id=$id;"

// $query = "DELETE tag WHERE id=$id;"
// $query = "DELETE tafera WHERE id=$id;"

function consultarTarefas($conn) {
    try{
        $query = "SELECT t.titulo as titulo, t.data_criado as criado, ta.titulo as tag FROM tarefa as t JOIN tag as ta ON ta.id = t.tag;";
        $tarefas = [];
        $result = pg_query($conn, $query);
        while ($row = pg_fetch_assoc($result)) {
            $tarefas[] = $row;
        }
        // pg_close($conn);
        return $tarefas;
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
};

function criarTarefa() {
    $tarefa_titulo = 'Tarefa 1';
    $criado = date("Y-m-d H:i:s", time());
    $final = '';
    $tag = '1';
    $tag_titulo = 'Urgente';
    // $query = "INSERT INTO tarefa(titulo, data_criado, tag) VALUES ('$tarefa_titulo', '$criado', $tag);";
};

?>