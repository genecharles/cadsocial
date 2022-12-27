$(document).ready(function() {
    listar();
} );

function listar(){
    $.ajax({
        url: pag + "/listar.php",
        method: 'POST',
        data: $('#form').serialize(),
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
        }
    });
}


function inserir(){
    $('#mensagem').text('');
    $('#tituloModal').text('Inserir Registro');
    $('#modalForm').modal('show');
    limparCampos();
}



function excluir(id, nome){
    $('#id-excluir').val(id);
    $('#nome-excluido').text(nome);
    $('#nome-excluir').val(nome);
    $('#modalExcluir').modal('show');
    $('#mensagem-excluir').text('');
}


function ativar(id, nome, acao){
    $.ajax({
        url: pag + "/mudar-status.php",
        method: 'POST',
        data: {id, nome, acao},
        dataType: "text",

        success: function (mensagem) {
            if (mensagem.trim() == "Alterado com Sucesso") {
                 listar();
            }               
        },

    });
}



$("#form").submit(function () {
	event.preventDefault();
    //nicEditors.findEditor('area').saveContent();
	var formData = new FormData(this);
    	$.ajax({
		url: pag + "/inserir.php",
		type: 'POST',
		data: formData,

		success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {                    
                    $('#btn-fechar').click();
                    listar();
                } else {
                	$('#mensagem').addClass('text-danger')
                    $('#mensagem').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});



$("#form-excluir").submit(function () {
    event.preventDefault();
    var formData = new FormData(this);
    
    $.ajax({
        url: pag + "/excluir.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-excluir').text('');
            $('#mensagem-excluir').removeClass()
            if (mensagem.trim() == "Excluído com Sucesso") {
                $('#btn-fechar-excluir').click();
                listar();
                limparCampos();
            } else {

                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
