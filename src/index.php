<?php
include 'controller/functions.php';

$conn = dbConn();
$tarefas = consultarTarefas($conn);
$tags = consultarTags($conn);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['criarTarefa'])) {
        criarTarefa($conn,$_POST);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if (isset($_POST['btnModalExcluirTarefa'])) {
        deletarTarefa($conn,$_POST['tarefaId']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if (isset($_POST['criarTag'])) {
        criarTag($conn,$_POST['tagTitulo']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if (isset($_POST['btnModalExcluirTag'])) {
        deletarTag($conn,$_POST['tagId']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if (isset($_POST['editarTag'])) {
        editarTag($conn,$_POST);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if (isset($_POST['editarTarefa'])) {
        unset($_POST['editarTarefa']);
        editarTarefa($conn,$_POST);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

}

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>
    <link rel="icon" type="image/png" href="public/img/favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
body {
    background-color: #eeeff1;
}

.nav-tabs .nav-link {
    border: none;
    color: #000000;
    background-color: transparent;
}

.tipos-listas .nav-link.active {
    font-weight: bold;
    border-bottom: 3px solid #597eb4;
    color: #597eb4;
    background-color: transparent;
}
.nav-tabs .nav-link:hover {
    color: #597eb4;
}
nav {
    .nav-tabs .nav-link.active {
        font-weight: bold;
        color: #597eb4;
        background-color: #b9cae5;
        border-radius: 20px;
    }
    .nav-tabs .nav-link {
        border: none;
        color: #000000;
        background-color: transparent;
    }
}


</style>
<body>
    <nav class="navbar navbar-expand-lg bg-primary-subtle position-relative">
        <div class="container-fluid">
            <span class="navbar-brand position-absolute start-50 translate-middle-x">Minhas Tarefas</span>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="nav nav-tabs ms-auto" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-tags" data-bs-toggle="tab" data-bs-target="#conteudoTags" type="button" role="tab"
                                aria-controls="conteudoTags" aria-selected="false">Tags</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-tarefas" data-bs-toggle="tab" data-bs-target="#conteudoTarefas" type="button"
                                role="tab" aria-controls="conteudoTarefas" aria-selected="true">Tarefas</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="py-4">
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="conteudoTarefas" role="tabpanel" aria-labelledby="conteudo-tarefas" tabindex="0">
                        <?php include 'components/conteudo-tarefas.php';?>
                    </div>
                    <div class="tab-pane fade" id="conteudoTags" role="tabpanel" aria-labelledby="conteudo-tags" tabindex="0">
                        <?php include 'components/conteudo-tags.php';?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarTarefaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarTarefaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarTarefaModalLabel">Editar Tarefa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" class="row gy-2 gx-3 align-items-center">
                        <input type="hidden" name="idTarefa" id="idTarefa" value="">
                        <div class="col-auto">
                            <input type="text" class="form-control" id="editarTituloTarefa" name="editarTituloTarefa" placeholder="Título da Tarefa" value="">
                        </div>
                        <div class="col-auto">
                            <select class="form-select" id="editarTagTarefa" name="editarTagTarefa">
                                <option value="">Selecione</option>
                                <?php foreach ($tags as $tag) : ?>
                                    <option value="<?= $tag['id'] ?>"><?= $tag['titulo'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="text-secondary">Data final</label>
                            <input type="date" class="form-control" id="editarDataFinal" name="editarDataFinal" value="">
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editarTarefaConcluida" name="editarTarefaConcluida" value="">
                                <label class="form-check-label" for="editarTarefaConcluida">Concluída</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="editarTarefa" name="editarTarefa">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarTagModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarTagModalLabel">Editar Tag</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" class="row gy-2 gx-3 align-items-center">
                        <input type="hidden" name="idTag" id="idTag">
                        <div class="col-auto">
                            <input type="text" class="form-control" id="editarTituloTag" name="editarTituloTag" placeholder="Título da Tarefa">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="editarTag" name="editarTag">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="public/js/script.js"></script>
</body>
</html>
