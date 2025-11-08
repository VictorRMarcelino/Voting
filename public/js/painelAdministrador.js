var PainelAdministrador = {

    /** Comportamento realizado ao carregar a tela */
    onLoadPainelAdministrador: function() {
        PainelAdministrador.loadScripts();
    },

    /** Carrega os comportamentos iniciais dos componentes */
    loadScripts: function() {
        $('#menuOptionSetores').on('click', PainelAdministrador.onClickOpcaoMenuSetores);
        $('#menuOptionPerguntas').on('click', PainelAdministrador.onClickOpcaoMenuPerguntas);
        $('#btnCarregarPerguntas').on('click', PainelAdministrador.onClickBtnCarregarPerguntas);
    },

    onClickOpcaoMenuSetores: function() {
        PainelAdministrador.carregaSetores();
    },

    carregaSetores: function() {
        $.ajax({
            url: 'http://localhost/Voting/public/painelAdministrador/setores',
            method: 'get',
            async: false
        }).then(function(response) {
            $('#tebelaSetores > tbody').empty();
            let setores = Object.values(JSON.parse(response));

            for (let i = 0; i < setores.length; i++) {
                let novaLinhaSetor = `
                    <tr>
                        <td>${setores[i]['id']}</td>
                        <td>${setores[i]['nome']}</td>
                        <td><button class="btn btn-warning btn-sm">Alterar</button></td>
                        <td><button class="btn btn-danger btn-sm">Excluir</button></td>
                    </tr>
                `;

                $('#tebelaSetores > tbody').append(novaLinhaSetor);
            }

            $('#perguntas').css('display', 'none'); 
            $('#setores').css('display', 'flex'); 
        });
    },

    onClickOpcaoMenuPerguntas: function() {
        PainelAdministrador.carregaMenuPerguntas();
        $('#tebelaPerguntas > tbody').empty();
        $('#perguntas').css('display', 'flex'); 
        $('#setores').css('display', 'none'); 
    },
    
    carregaMenuPerguntas: function() {
        $.ajax({
            url: 'http://localhost/Voting/public/painelAdministrador/setores',
            method: 'get',
            async: false
        }).then(function(response) {
            $('#tebelaSetores > tbody').empty();
            let setores = Object.values(JSON.parse(response));
            $('#listaSetores').append('<option value="0">Selecione...</option>');

            for (let i = 0; i < setores.length; i++) {
                let novaOpcaoSetor = `<option value="${setores[i]['id']}">${setores[i]['nome']}</option>`;
                $('#listaSetores').append(novaOpcaoSetor);
            }
        });
    },

    onClickBtnCarregarPerguntas: function() {
        let setor = $('#listaSetores').val();
        
        if (parseInt(setor) == 0) {
            Swal.fire({
                title: 'Alerta',
                icon: 'warn',
                text: 'Selecione um setor para consultar as perguntas.'
            });
            return;
        }

        $('#tebelaPerguntas > tbody').empty();

        $.ajax({
            url: 'http://localhost/Voting/public/painelAdministrador/perguntas',
            method: 'get',
            data: {idSetor: setor}
        }).then(function(response) {
            let perguntas = Object.values(JSON.parse(response));
            
            for (let i = 0; i < perguntas.length; i++) {
                let novaLinhaSetor = `
                    <tr>
                        <td>${perguntas[i]['id']}</td>
                        <td>${perguntas[i]['id_setor']}</td>
                        <td>${perguntas[i]['pergunta']}</td>
                        <td><button class="btn btn-warning btn-sm">Alterar</button></td>
                        <td><button class="btn btn-danger btn-sm">Excluir</button></td>
                    </tr>
                `;

                $('#tebelaPerguntas > tbody').append(novaLinhaSetor);
            }
        });
    }
}

PainelAdministrador.onLoadPainelAdministrador();