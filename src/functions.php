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
        $query = "SELECT t.id as id, t.concluida as concluida, t.titulo as titulo, t.data_final as data_final, ta.titulo as tag FROM tarefa as t LEFT JOIN tag as ta ON ta.id = t.tag ORDER BY data_final ASC;";
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
    $titulo_tarefa = trim($_POST['titulo_tarefa']);
    $tag_tarefa = isset($_POST['tag_tarefa']) && $_POST['tag_tarefa'] !== '' ? $_POST['tag_tarefa'] : NULL;
    $data_final = isset($_POST['data_final']) && $_POST['data_final'] !== '' ? $_POST['data_final'] : NULL;
    $tarefa_concluida = isset($_POST['tarefa_concluida']) ? 'TRUE' : 'FALSE';

    $sql = "INSERT INTO tarefa (titulo, data_final, concluida, tag) 
        VALUES ($1, $2, $3, $4)";

    $result = pg_query_params($conn, $sql, [$titulo_tarefa, $data_final, $tarefa_concluida, $tag_tarefa]);

    if (!$result) {
        echo "Erro ao cadastrar tarefa: " . pg_last_error($conn);
    }

//    $titulo = $data['titulo_tarefa'] !== '' ? "'" . $data['titulo_tarefa'] . "'" : 'NULL'; // PHP 7+ (null coalescing)
//    $criado = date("Y-m-d");
//    $final = $data['data_final'] !== '' ? "'" . $data['data_final'] . "'" : 'NULL';
//    $concluida = isset($data['tarefa_concluida']) ? ($data['tarefa_concluida'] !== '' ? 'TRUE' : 'FALSE' ) : 'FALSE';
//    $tag = $data['tag_tarefa'] !== '' ? "'" . $data['tag_tarefa'] . "'" : 'NULL';
//    try {
//        $query = "INSERT INTO tarefa(titulo, data_criado, data_final, concluida, tag)
//                  VALUES ($titulo, '$criado', $final, $concluida, $tag)";
//        $result = pg_query($conn, $query);
//
//        if (!$result) {
//            throw new Exception(pg_last_error($conn));
//        }
//    } catch(Exception $e) {
//        echo "Erro: " . $e->getMessage();
//    }
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

function consultarTarefa($conn, $id) {
    try{
        $query = "SELECT t.id as id, t.concluida as concluida, t.titulo as titulo, t.data_final as data_final, ta.titulo as tag FROM tarefa as t JOIN tag as ta ON ta.id = t.tag WHERE t.id = $id;";
        return pg_query($conn, $query);
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
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

function consultarTag($conn, $id) {
    try{
        $query = "SELECT * FROM tag WHERE id=$id;";
        return pg_query($conn, $query);
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}