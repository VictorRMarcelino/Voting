var Avaliacao = {

    questoes: [],
    perguntaAtual: 1,
    respostas: [],

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
        $.ajax({
            url: 'http://localhost/Voting/public/avaliacao/perguntas',
            method: 'get'
        }).then(function(response) {
            let perguntas = Object.values(JSON.parse(response));
            Avaliacao.questoes = perguntas;
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

        if (Avaliacao.perguntaAtual != Avaliacao.questoes.length) {
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

        $.ajax({
            url: 'http://localhost/Voting/public/avaliacao/salvar',
            method: 'post',
            data: {respostas: Avaliacao.respostas}
        }).then((response) => {
            Swal.fire({
                title: 'Avaliação de Qualidade Finalizada',
                icon: 'success',
                text: 'O Estabelecimento agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.'
            }).then((result) => {
                Avaliacao.reiniciaQuestionario();
            })
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