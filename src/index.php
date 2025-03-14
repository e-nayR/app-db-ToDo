<?php
try {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

    if ($conn) {
        echo "Conexão bem-sucedida com o PostgreSQL! 🎉";
    } else {
        echo "Falha na conexão ❌";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>