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
    <ul class="tipos-listas nav nav-tabs mb-4">
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
                            <?php include 'listar-tarefas.php'; ?>
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
                                        <?php include 'listar-tarefas.php'; ?>
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
                                    <?php include 'listar-tarefas.php'; ?>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
