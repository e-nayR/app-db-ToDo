<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do</title>
    <link rel="icon" type="image/png" href="./favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
body {
    padding-top: 20px;
    background-color: #f1f5f9;
}
</style>
<?php
include 'functions.php';

$conn = dbConn();
$tarefas = consultarTarefas($conn);
$tags = consultarTags($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['criar-tarefa'])) {
        //echo $_POST['data_final'].' 00:00:00';
        criarTarefa($conn,$_POST);
    }
//    elseif (isset($_POST['editar-tarefa'])) {
//        echo 'Editou';
//    }
}

?>
<body>
    <div class="container">
        <div class="py-4">
            <div class="row">
                <div class="offset-lg-1 col-lg-10 col-md-12">
                    <div class="row align-items-center mb-2">
                        <form method="POST" class="row gy-2 gx-3 align-items-center">
                            <div class="col-auto">
                                <input type="text" class="form-control" id="titulo_tarefa" name="titulo_tarefa" placeholder="Título da Tarefa" required>
                            </div>
                            <div class="col-auto">
                                <label class="text-secondary">Categoria</label>
                                <select class="form-select" id="categoria" name="categoria">
                                    <option value="0">Selecione</option>
                                <?php foreach ($tags as $tag) : ?>
                                    <option value="<?php echo $tag['id'] ?>"><?php echo $tag['titulo'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-auto">
                                <label class="text-secondary">Data final</label>
                                <input type="date" class="form-control" id="data_final" name="data_final">
                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="status_tarefa" name="status_tarefa">
                                    <label class="form-check-label" for="status_tarefa">Concluída</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success" id="criar-tarefa" name="criar-tarefa">Criar</button>
                            </div>
                        </form>
                    </div>
                    <!-- tipos de listagem -->
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <button class="nav-link active" id="lista-todas" data-bs-toggle="tab" data-bs-target="#tarefas">Todas</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="lista-categoria" data-bs-toggle="tab" data-bs-target="#categoria-tarefas">Por categoria</button>
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
                                                        <input class="form-check-input me-0" type="checkbox" id="tarefa_check1" <?= $tarefa['entregue'] == 't' ? 'checked' : '' ?>>
                                                    </div>
                                                    <div class="ms-3">
                                                        <p class="mb-0"><span class="text-muted"><?php echo $tarefa['data_final'] ?></span> <?php echo $tarefa['titulo'] ?></p>
                                                    </div>
                                                    <div class="ms-2">
                                                        <span class="badge rounded-pill text-bg-warning"><?php echo $tarefa['tag'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row justify-content-end">
                                                    <button class="btn btn-outline-primary me-1" id="botaoEditar" data-bs-toggle="modal" data-bs-target="#editarTarefaModal">
                                                        <i class="bi bi-pen-fill"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger" id="botaoExcluir" data-id="<?php echo $tarefa['id'] ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="categoria-tarefas">
                            <div class="row">
                            <?php foreach ($tags as $tag) : ?>
                            <div class="col-md-6 mt-2">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0"><?php echo $tag['titulo'] ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <?php $porCategoria = consultarPorCategoria($conn, $tag['id']);
                                             foreach ($porCategoria as $tarefa) : ?>
                                            <li class="list-group-item p-2 bg-light rounded" >
                                                <div class="d-flex justify-content-between align-items-center flex-wrap" >
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input me-0" type="checkbox" id="tarefa_check1">
                                                        </div>
                                                        <div class="ms-3">
                                                            <p class="mb-0"><span class="text-muted"><?php echo $tarefa['data_final'] ?></span> <?php echo $tarefa['titulo'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row justify-content-end">
                                                        <button class="btn btn-outline-primary me-1" id="botaoEditar" data-bs-toggle="modal" data-bs-target="#editarTarefaModal">
                                                            <i class="bi bi-pen-fill"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger" id="botaoExcluir" data-id="<?php echo $tarefa['id'] ?>">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edição -->
    <div class="modal fade" id="editarTarefaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarTarefaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarTarefaModalLabel">Editar Tarefa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" class="row gy-2 gx-3 align-items-center">
                        <div class="col-auto">
                            <input type="text" class="form-control" id="editar_titulo_tarefa" placeholder="Título da Tarefa">
                        </div>
                        <div class="col-auto">
                            <select class="form-select" id="editar_categoria">
                                <option selected>Categoria</option>
                                <option value="1">Urgente</option>
                                <option value="2">Faculdade</option>
                                <option value="3">Tempo</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="text-secondary">Data final</label>
                            <input type="date" class="form-control" id="editar_data_final">
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editar_status_tarefa">
                                <label class="form-check-label" for="editar_status_tarefa">Concluída</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="editar-tarefa" name="editar-tarefa">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('#botaoExcluir').forEach(botao => {
            botao.addEventListener('click', () => {
                const id = botao.dataset.id;

                fetch('delete.php', {
                    method: 'POST',
                    body: JSON.stringify({ id: id })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            botao.closest('li').remove(); // Remove a linha da tabela
                        }
                    });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
