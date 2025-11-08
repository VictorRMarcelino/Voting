var Avaliacao = {

    questoes: {},
    perguntaAtual: 1,
    respostas: {},

    /** Comportamento realizado ao carregar a tela */
    onLoadAvaliacao: function() {
        Avaliacao.loadScripts();
        Avaliacao.carregaPerguntas();
    },

    /** Carrega os comportamentos iniciais dos componentes */
    loadScripts: function() {
        $('#btnStartQuiz').on('click', Avaliacao.onClickStartQuiz);
        $('.button').on('click', Avaliacao.onClickButtonAnswer);
        $('#btnFinalizarAvaliacao').on('click', Avaliacao.salvaQuestionario);
    },

    /** Carrega as perguntas do formulário */
    carregaPerguntas: function() {
        let fnSalvarPerguntas = function(response) {
            let perguntas = JSON.parse(response);
            Avaliacao.questoes = perguntas;
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/avaliacao/perguntas',
            method: 'get',
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
        
        if (Avaliacao.perguntaAtual != Object.keys(Avaliacao.questoes).length) {
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
        Avaliacao.perguntaAtual = 1;
        $('#feedback').css('display', 'none'); 
        $('#questionnaire').css('display', 'none'); 
        $('#startQuiz').css('display', 'flex'); 
    }
}

Avaliacao.onLoadAvaliacao();