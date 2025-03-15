<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do</title>
    <link rel="icon" type="image/png" href="./favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
body{padding-top:20px;
background-color:#f1f5f9;
}
.card {
    border: 0;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,20,.08), 0 1px 2px rgba(0,0,20,.08);
}
.rounded-bottom {
    border-bottom-left-radius: 0.375rem !important;
    border-bottom-right-radius: 0.375rem !important;
}
</style>
<?php
include 'functions.php';

$conn = dbConn();
$tarefas = consultarTarefas($conn);
?>
<body>
    <div class="container">
        <div class="py-6">
            <div class="row">
                <div class="offset-lg-1 col-lg-10 col-md-12 col-12">
                    <div class="row align-items-center mb-4">
                        <div class="d-flex justify-content-between
                        align-items-center">
                            <form>
                                <input type="text" class="form-control form-control-lg" placeholder="Nova tarefa">
                            </form>
                            <div>
                                <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-success">Adicionar</button>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-4" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" id="ex1-tab-2" data-mdb-tab-init="" href="" role="tab" aria-controls="ex1-tabs-2" aria-selected="false" tabindex="-1">Todas</a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" id="ex1-tab-3" data-mdb-tab-init="" href="" role="tab" aria-controls="ex1-tabs-3" aria-selected="false" tabindex="-1">Por categoria</a>
                        </li>
                    </ul>

                    <div class="mb-8">
                        <div class="card md-6">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($tarefas as $tarefa) : ?>
                                <li class="list-group-item p-2">
                                    <div class="d-flex justify-content-between
                                        align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input me-0" type="checkbox" value="" id="flexCheckChecked1" aria-label="...">
                                            </div>
                                            <div class="ms-3">
                                                <p class="mb-0 font-weight-medium"><?php echo $tarefa['titulo'] ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row justify-content-end">
                                            <button class="btn btn-outline-primary"><i class="bi bi-pen-fill"></i></button>
                                            <button class="btn btn-outline-danger"><i class="bi bi-trash-fill"></i></button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>
