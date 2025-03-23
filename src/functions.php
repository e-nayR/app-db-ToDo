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
        $query = "SELECT t.id as id, t.concluida as concluida, t.titulo as titulo, t.data_final as data_final, ta.titulo as tag, ta.id as tag_id FROM tarefa as t LEFT JOIN tag as ta ON ta.id = t.tag ORDER BY data_final ASC;";
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

function consultarPorStatus($conn,$tag_id) {
    try{
        $query = "SELECT t.id as id, t.concluida as concluida, t.titulo as titulo, t.data_final as data_final FROM tarefa as t WHERE t.tag=$tag_id ORDER BY data_final DESC;";
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

function consultarPorTagNull($conn){
    try{
        $query = "SELECT t.id as id, t.concluida as concluida, t.titulo as titulo, t.data_final as data_final FROM tarefa as t WHERE t.tag is NULL ORDER BY data_final DESC;";
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
    $titulo_tarefa = $_POST['tituloTarefa'];
    $tag_tarefa = $_POST['tagTarefa'] !== '' ? $_POST['tagTarefa'] : NULL;
    $data_final = $_POST['dataFinal'] !== '' ? $_POST['dataFinal'] : NULL;
    $tarefa_concluida = isset($_POST['tarefaConcluida']) ? 'TRUE' : 'FALSE';

    $sql = "INSERT INTO tarefa (titulo, data_final, concluida, tag) 
        VALUES ($1, $2, $3, $4)";

    $result = pg_query_params($conn, $sql, [$titulo_tarefa, $data_final, $tarefa_concluida, $tag_tarefa]);

    if (!$result) {
        echo "Erro ao cadastrar tarefa: " . pg_last_error($conn);
    }
}

function deletarTarefa($conn, $id)
{
    try{
        $query = "DELETE FROM tarefa WHERE id=$id;";
        $result = pg_query($conn, $query);
    } catch(Exception $e) {
        error_log("Erro: " . $e->getMessage());
    }
}

function criarTag($conn, $tag_titulo) {
    $titulo = isset($tag_titulo) ? $tag_titulo : null;
    try{
        $sql = "INSERT INTO tag(titulo) VALUES ($1)";
        $result = pg_query_params($conn, $sql, [$titulo]);
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function deletarTag($conn, $id)
{
    try{
        $query = "DELETE FROM tag WHERE id=$id;";
        $result = pg_query($conn, $query);
    } catch(Exception $e) {
        error_log("Erro: " . $e->getMessage());
    }
}

function editarTag($conn, $data) {
    $id = $data['idTag'];
    $titulo = $data['editarTituloTag'];
    try{
        $sql = "UPDATE tag SET titulo = $1 WHERE id=$2;";
        $result = pg_query_params($conn, $sql, [$titulo, $id]);
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function editarTarefa($conn, $data){
    $id = $data['tarefaId'];
    $titulo_tarefa = $data['editarTituloTarefa'];
    $tag_tarefa = $data['editarTagTarefa'] !== '' ? $data['editarTagTarefa'] : NULL;
    $data_final = $data['editarDataFinal'] !== '' ? $data['editarDataFinal'] : NULL;
    $tarefa_concluida = isset($data['editarTarefaConcluida']) ? 'TRUE' : 'FALSE';
    try{
        $sql = "UPDATE tarefa SET titulo=$1, data_final=$2, concluida=$3, tag=$4 WHERE id=$5;";
        $result = pg_query_params($conn, $sql, [$titulo_tarefa, $data_final, $tarefa_concluida, $tag_tarefa, $id]);
        if (!$result) {
            throw new Exception(pg_last_error($conn));
        }
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}