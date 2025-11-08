var Avaliacao = {

    questoes: {},
    perguntaAtual: 0,
    respostas: {},

    /** Comportamento realizado ao carregar a tela */
    onLoadAvaliacao: function() {
        Avaliacao.loadScripts();
        let setor = Cookies.get('setor');

        if (setor == undefined) {
            Avaliacao.carregaSetores();
        } else {
            Avaliacao.carregaPerguntas(setor)
        }
    },

    /** Carrega os comportamentos iniciais dos componentes */
    loadScripts: function() {
        $('#btnStartQuiz').on('click', Avaliacao.onClickStartQuiz);
        $('.button').on('click', Avaliacao.onClickButtonAnswer);
        $('#btnFinalizarAvaliacao').on('click', Avaliacao.salvaQuestionario);
        $('#areaPainelAdm').on('click', Avaliacao.onClickBotaoPainelAdministrador);
        $('#btnDefinirSetor').on('click', Avaliacao.onClickBotaoDefinirSetor);
    },

    carregaSetores: function() {
        let fnCarregaFiltroSetores = function(response) {
            let setores = Object.values(JSON.parse(response));
            $('#listaSetores').append('<option value="0">Selecione...</option>');

            for (let i = 0; i < setores.length; i++) {
                let novaOpcaoSetor = `<option value="${setores[i]['id']}">${setores[i]['nome']}</option>`;
                $('#listaSetores').append(novaOpcaoSetor);
            }

            $('#definirSetor').css('display', 'flex');
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/avaliacao/setores',
            method: 'get',
            async: false,
            fnSucess: fnCarregaFiltroSetores
        });
    },

    onClickBotaoDefinirSetor: function() {
        let setor = $('#listaSetores').val();
        Cookies.set('setor', setor, { expires: 7});
        Avaliacao.carregaPerguntas(setor);
    },

    /** Carrega as perguntas do formulário */
    carregaPerguntas: function(setor) {
        let fnSalvarPerguntas = function(response) {
            let perguntas = JSON.parse(response);
            Avaliacao.questoes = perguntas;
            Avaliacao.perguntaAtual = parseInt(Object.keys(perguntas)[0]);
            $('#definirSetor').css('display', 'none');
            $('#startQuiz').css('display', 'flex');
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/avaliacao/perguntas',
            method: 'get',
            data: {setor: setor},
            fnSucess: fnSalvarPerguntas
        });
    },

    onClickStartQuiz: function() {
        Avaliacao.carregaProximaPergunta();
        $('#startQuiz').css('display', 'none'); 
        $('#questionnaire').css('display', 'flex'); 
    },

    carregaProximaPergunta: function() {
        $("#question").fadeOut(400, function() {
            $(this).html(Avaliacao.questoes[Avaliacao.perguntaAtual]);
            $(this).fadeIn(400);
        });
    },

    onClickButtonAnswer: function() {        
        Avaliacao.respostas[Avaliacao.perguntaAtual] = this.value;
        
        if (Avaliacao.perguntaAtual != Object.keys(Avaliacao.questoes).pop()) {
            Avaliacao.perguntaAtual++;
            Avaliacao.carregaProximaPergunta();
        } else {
            Avaliacao.exibeFeedback();
        }
    },

    exibeFeedback: function() {
        $('#questionnaire').css('display', 'none');
        $('#feedback').css('display', 'flex'); 
    },

    salvaQuestionario: function() {
        Avaliacao.respostas['feedback'] = $('#textoFeedback')[0].value;
        Avaliacao.respostas['setor'] = Cookies.get('setor');;

        let fnExibirMensagemSucesso = function() {
            let tituloMensagemSucesso = 'Avaliação de Qualidade Finalizada';
            let mensagemSucesso = 'O Estabelecimento agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.O Estabelecimento agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.';
            Message.success(tituloMensagemSucesso, mensagemSucesso, function() {
                Avaliacao.reiniciaQuestionario();
            });
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/avaliacao/salvar',
            method: 'post',
            data: Avaliacao.respostas,
            fnSucess: fnExibirMensagemSucesso
        });
    },

    reiniciaQuestionario: function() {
        Avaliacao.perguntaAtual = parseInt(Object.keys(Avaliacao.questoes)[0]);
        $('#feedback').css('display', 'none'); 
        $('#questionnaire').css('display', 'none'); 
        $('#startQuiz').css('display', 'flex'); 
    },

    onClickBotaoPainelAdministrador: function() {
        $(location).attr('href', 'http://localhost/Voting/public/painelAdministrador');
    }
}

Avaliacao.onLoadAvaliacao();