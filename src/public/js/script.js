document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll("#btnModalEditarTarefa").forEach(function(btnEditar) {
        btnEditar.addEventListener("click", function() {
            const tarefaData = JSON.parse(this.getAttribute('data-tarefaInfo'));
            document.getElementById("idTarefa").value = tarefaData.id;
            document.getElementById("editarTituloTarefa").value = tarefaData.titulo;
            document.querySelector(`#editarTagTarefa option[value="${tarefaData.tag_id}"]`).selected = true;
            document.getElementById("editarTagTarefa").value = tarefaData.tag_id;
            document.getElementById("editarDataFinal").value = tarefaData.data_final;
            if (tarefaData.concluida == 't'){
                document.getElementById("editarTarefaConcluida").checked = true;
            }
        });
    })
    document.querySelectorAll("#btnModalEditarTag").forEach(function(btnEditar) {
        btnEditar.addEventListener("click", function() {
            try {
                const tagData = JSON.parse(this.getAttribute('data-tagInfo'));

                document.getElementById("idTag").value = tagData.id;
                document.getElementById("editarTituloTag").value = tagData.titulo;
            } catch (error) {
                console.error("Erro ao processar os dados da tag:", error);
            }
        });
    })
})

