var Login = {

    /** Comportamento realizado ao carregar a tela */
    onLoadLogin: function() {
        Login.loadScripts();
    },

    /** Carrega os comportamentos iniciais dos componentes */
    loadScripts: function() {
        $('#btnAcessar').on('click', Login.onClickBotaoAcessar);
        $('#areaAtualizar').on('click', Login.onClickBotaoAvalicao);
    },

    onClickBotaoAcessar: function() {
        let usuario = $('#usuario').val();
        let senha = $('#senha').val();

        if ((usuario == '') || (senha == '')) {
            Message.warn('Alerta', 'É necessário preencher o usuário e a senha para poder acessar o sistema!');
            return;
        }

        let fnVerificaLogin = function(response) {
            let retorno = JSON.parse(response);

            if (retorno.logado) {
                $(location).attr('href', 'http://localhost/Voting/public/painelAdministrador');
                return;
            }

            Message.warn('Alerta', 'Usuário ou senha incorretos!');
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/login/verificar',
            method: 'get',
            data: {usuario: usuario, senha: senha},
            fnSucess: fnVerificaLogin
        });
    },

    onClickBotaoAvalicao: function() {
        $(location).attr('href', 'http://localhost/Voting/public/avaliacao');
    }
}

Login.onLoadLogin();