<li class="list-group-item p-2">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center">
            <?php if ($tarefa['concluida'] == 't') : ?>
                <div class="form-check">
                    <input class="form-check-input me-0" type="checkbox" checked disabled>
                </div>
            <?php  endif; ?>
            <div class="ms-3">
                <p class="mb-0"><span class="text-muted"><?= $tarefa['data_final'] ?></span> <?= $tarefa['titulo'] ?></p>
            </div>
            <?php if (isset($tarefa['tag'])): ?>
            <div class="ms-2">
                <span class="badge rounded-pill text-bg-warning"><?= $tarefa['tag'] ?></span>
            </div>
            <?php endif; ?>
        </div>
        <div class="d-flex flex-row justify-content-end">
            <?php $jsonTarefa = htmlspecialchars(json_encode($tarefa), ENT_QUOTES, 'UTF-8'); ?>
            <button class="btn btn-outline-primary me-1" id="btnModalEditarTarefa" data-tarefaInfo="<?= $jsonTarefa ?>" data-bs-toggle="modal" data-bs-target="#editarTarefaModal">
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
