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
                                <?php $jsonTag = htmlspecialchars(json_encode($tag), ENT_QUOTES, 'UTF-8'); ?>
                                <button class="btn btn-outline-primary me-1" id="btnModalEditarTag"  data-bs-toggle="modal" data-bs-target="#editarTagModal" data-tagInfo="<?= $jsonTag ?>">
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
