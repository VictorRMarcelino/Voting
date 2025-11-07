var PainelAdministrador = {

    /** Comportamento realizado ao carregar a tela */
    onLoadPainelAdministrador: function() {
        PainelAdministrador.loadScripts();
    },

    /** Carrega os comportamentos iniciais dos componentes */
    loadScripts: function() {
        $('#menuOptionSetores').on('click', PainelAdministrador.onClickOpcaoMenuSetores);
        $('#menuOptionPerguntas').on('click', PainelAdministrador.onClickOpcaoMenuPerguntas);
    },

    onClickOpcaoMenuSetores: function() {
        PainelAdministrador.carregaSetores();
    },

    carregaSetores: function() {
        $.ajax({
            url: 'http://localhost/Voting/public/painelAdministrador/setores',
            method: 'get'
        }).then(function(response) {
            $('#tebelaSetores > tbody').empty();
            let setores = Object.values(JSON.parse(response));

            for (let i = 0; i < setores.length; i++) {
                let novaLinhaSetor = `
                    <tr>
                        <td>${setores[i]['id']}</td>
                        <td>${setores[i]['nome']}</td>
                    </tr>
                `;

                $('#tebelaSetores > tbody').append(novaLinhaSetor);
            }

            $('#perguntas').css('display', 'none'); 
            $('#setores').css('display', 'flex'); 
        });
    },

    onClickOpcaoMenuPerguntas: function() {
        $('#perguntas').css('display', 'flex'); 
        $('#setores').css('display', 'none'); 
    }
}

PainelAdministrador.onLoadPainelAdministrador();