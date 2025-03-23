<?php
include 'functions.php';

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
    <link rel="icon" type="image/png" href="./favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
body {
    background-color: #eeeff1;
}
</style>
<body>
    <nav class="navbar navbar-expand-lg bg-primary-subtle">
        <div class="container-fluid">
            <span class="navbar-brand">Minhas Tarefas</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="nav nav-tabs me-auto mb-2 mb-lg-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-tarefas" data-bs-toggle="tab" data-bs-target="#conteudoTarefas" type="button"
                                role="tab" aria-controls="conteudoTarefas" aria-selected="true">Tarefas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-tags" data-bs-toggle="tab" data-bs-target="#conteudoTags" type="button" role="tab"
                                aria-controls="conteudoTags" aria-selected="false">Tags</button>
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
                        <div class="offset-lg-1 col-lg-10 col-md-12">
                            <div class="row align-items-center mb-2">
                                <form method="POST" class="row gy-2 gx-3 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" class="form-control" id="tituloTarefa" name="tituloTarefa" placeholder="Título da Tarefa" required>
                                    </div>
                                    <div class="col-auto">
                                        <label class="text-secondary">Tag</label>
                                        <select class="form-select" id="tagTarefa" name="tagTarefa">
                                            <option value="">Selecione</option>
                                            <?php foreach ($tags as $tag) : ?>
                                                <option value="<?= $tag['id'] ?>"><?= $tag['titulo'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label class="text-secondary">Data final</label>
                                        <input type="date" class="form-control" id="dataFinal" name="dataFinal">
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="tarefaConcluida" name="tarefaConcluida">
                                            <label class="form-check-label" for="tarefaConcluida">Concluída</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-outline-success" id="criarTarefa" name="criarTarefa">Criar</button>
                                    </div>
                                </form>
                            </div>
                            <!-- tipos de listagem -->
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <button class="nav-link active" id="lista-todas" data-bs-toggle="tab" data-bs-target="#tarefas">Todas</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="lista-tag" data-bs-toggle="tab" data-bs-target="#listaTagTarefas">Por tag</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tarefas">
                                    <div class="mb-4">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($tarefas as $tarefa) : ?>
                                                    <li class="list-group-item p-2">
                                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input me-0" type="checkbox" id="tarefaCheck" <?= $tarefa['concluida'] == 't' ? 'checked' : '' ?> disabled>
                                                                </div>
                                                                <div class="ms-3">
                                                                    <p class="mb-0"><span class="text-muted"><?= $tarefa['data_final'] ?></span> <?= $tarefa['titulo'] ?></p>
                                                                </div>
                                                                <div class="ms-2">
                                                                    <span class="badge rounded-pill text-bg-warning"><?= $tarefa['tag'] ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-row justify-content-end">
                                                                <button class="btn btn-outline-primary me-1" id="btnModalEditarTarefa" data-id="<?= $tarefa['id'] ?>" data-bs-toggle="modal" data-bs-target="#editarTarefaModal<?= $tarefa['id']?>">
                                                                    <i class="bi bi-pen-fill"></i>
                                                                </button>
                                                                <form method="post">
                                                                    <input type="hidden" name="tarefaId" value="<?= $tarefa['id'] ?>" id="tarefaId">
                                                                    <button class="btn btn-outline-danger" id="btnModalExcluirTarefa" name="btnModalExcluirTarefa">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="listaTagTarefas">
                                    <div class="row">
                                        <?php foreach ($tags as $tag) : ?>
                                            <div class="col-md-6 mt-2">
                                                <div class="card shadow-sm">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0"><?= $tag['titulo'] ?></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            <?php $porStatus = consultarPorStatus($conn, $tag['id']);
                                                            foreach ($porStatus as $tarefa) : ?>
                                                                <li class="list-group-item p-2 bg-light rounded" >
                                                                    <div class="d-flex justify-content-between align-items-center flex-wrap" >
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input me-0" type="checkbox" id="tarefaCheck" <?= $tarefa['concluida'] == 't' ? 'checked' : '' ?> disabled>
                                                                            </div>
                                                                            <div class="ms-3">
                                                                                <p class="mb-0"><span class="text-muted"><?= $tarefa['data_final'] ?></span> <?= $tarefa['titulo'] ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex flex-row justify-content-end">
                                                                            <button class="btn btn-outline-primary me-1" id="btnModalEditarTarefa" data-bs-toggle="modal" data-bs-target="#editarTarefaModal<?= $tarefa['id']?>">
                                                                                <i class="bi bi-pen-fill"></i>
                                                                            </button>
                                                                            <form method="post">
                                                                                <input type="hidden" name="tarefaId" value="<?= $tarefa['id'] ?>" id="tarefaId">
                                                                                <button class="btn btn-outline-danger" id="btnModalExcluirTarefa" name="btnModalExcluirTarefa">
                                                                                    <i class="bi bi-trash-fill"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach;?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                        <div class="col-md-6 mt-2">
                                            <div class="card shadow-sm">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">Sem Tag</h5>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <?php $porTagNull = consultarPorTagNull($conn);
                                                        foreach ($porTagNull as $tarefa) : ?>
                                                            <li class="list-group-item p-2 bg-light rounded" >
                                                                <div class="d-flex justify-content-between align-items-center flex-wrap" >
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input me-0" type="checkbox" id="tarefaCheck" <?= $tarefa['concluida'] == 't' ? 'checked' : '' ?> disabled>
                                                                        </div>
                                                                        <div class="ms-3">
                                                                            <p class="mb-0"><span class="text-muted"><?= $tarefa['data_final'] ?></span> <?= $tarefa['titulo'] ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex flex-row justify-content-end">
                                                                        <button class="btn btn-outline-primary me-1" id="btnModalEditarTarefa" data-bs-toggle="modal" data-bs-target="#editarTarefaModal<?= $tarefa['id']?>">
                                                                            <i class="bi bi-pen-fill"></i>
                                                                        </button>
                                                                        <form method="post">
                                                                            <input type="hidden" name="tarefaId" value="<?= $tarefa['id'] ?>" id="tarefaId">
                                                                            <button class="btn btn-outline-danger" id="btnModalExcluirTarefa" name="btnModalExcluirTarefa">
                                                                                <i class="bi bi-trash-fill"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php endforeach;?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="conteudoTags" role="tabpanel" aria-labelledby="conteudo-tags" tabindex="0">
                        <div class="offset-lg-1 col-lg-10 col-md-12">
                            <div class="row align-items-center mb-2">
                                <form method="post" class="row gy-2 gx-3 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" class="form-control" id="tagTitulo" name="tagTitulo" placeholder="Título da Tag" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-outline-success" data-bs-dismiss="modal" id="criarTag" name="criarTag">Criar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-4">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($tags as $tag) : ?>
                                            <li class="list-group-item p-2">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-3">
                                                            <p class="mb-0"><?= $tag['titulo'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row justify-content-end">
                                                        <button class="btn btn-outline-primary me-1" id="btnModalEditarTag"  data-bs-toggle="modal" data-bs-target="#editarTagModal<?= $tag['id']?>">
                                                            <i class="bi bi-pen-fill"></i>
                                                        </button>
                                                        <form method="post">
                                                            <input type="hidden" name="tagId" value="<?= $tag['id'] ?>" id="tagId">
                                                            <button class="btn btn-outline-danger" id="btnModalExcluirTag" name="btnModalExcluirTag">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($tarefas as $tarefa) : ?>
    <div class="modal fade" id="editarTarefaModal<?= $tarefa['id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarTarefaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" name="idTarefaEditar" id="idTarefaEditar">
                    <h1 class="modal-title fs-5" id="editarTarefaModalLabel">Editar Tarefa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" class="row gy-2 gx-3 align-items-center">
                        <input type="hidden" name="tarefaId" value="<?= $tarefa['id'] ?>" id="tarefaId">
                        <div class="col-auto">
                            <input type="text" class="form-control" id="editarTituloTarefa" name="editarTituloTarefa" value="<?= $tarefa['titulo']?>" placeholder="Título da Tarefa">
                        </div>
                        <div class="col-auto">
                            <select class="form-select" id="editarTagTarefa" name="editarTagTarefa">
                                <option value="">Selecione</option>
                                <?php foreach ($tags as $tag) : ?>
                                    <option value="<?= $tag['id'] ?>" <?= ($tag['id'] == $tarefa['tag_id'] ? 'selected' : '' ) ?>><?= $tag['titulo'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="text-secondary">Data final</label>
                            <input type="date" class="form-control" id="editarDataFinal" name="editarDataFinal" value="<?= $tarefa['data_final']?>">
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editarTarefaConcluida" name="editarTarefaConcluida" <?= $tarefa['concluida'] == 't' ? 'checked' : '' ?>>
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
    <?php endforeach; ?>

    <?php foreach ($tags as $tag) : ?>
    <div class="modal fade" id="editarTagModal<?= $tag['id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" name="idTagEditar" id="idTagEditar">
                    <h1 class="modal-title fs-5" id="editarTagModalLabel">Editar Tag</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" class="row gy-2 gx-3 align-items-center">
                        <input type="hidden" name="idTag" value="<?= $tag['id'] ?>" id="idTag">
                        <div class="col-auto">
                            <input type="text" class="form-control" id="editarTituloTag" name="editarTituloTag" value="<?= $tag['titulo']?>" placeholder="Título da Tarefa">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="editarTag" name="editarTag">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <script>
        modalTarefa = document.querySelector("#idTarefaEditar");
        modalTag = document.querySelector("#idTagEditar");
        document.querySelectorAll("#btnModalEditarTarefa").forEach(function(btnEditar) {
            btnEditar.addEventListener("click", function() {
                console.log("ID da Tarefa:", this.dataset.id);
            });
        });
        document.querySelectorAll("#btnModalEditarTag").forEach(function(btnEditar) {
            btnEditar.addEventListener("click", function() {
                modalTag.value= this.dataset.id;
                console.log(modalTag.value)
            });
        });

    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
