var Avaliacao = {

    questoes: [
        'teste',
        'teste 2',
        'teste 3',
        'teste 4',
    ],

    perguntaAtual: 0,
    respostas: [],

    onLoadAvaliacao: function() {
        Avaliacao.loadScripts();
    },

    loadScripts: function() {
        $('#btnStartQuiz').on('click', Avaliacao.onClickStartQuiz);
        $('.button').on('click', Avaliacao.onClickButtonAnswer);
    },

    onClickStartQuiz: function() {
        Avaliacao.loadNextQuestion();
        $('#startQuiz').css('display', 'none'); 
        $('#questionnaire').css('display', 'flex'); 
    },

    onClickButtonAnswer: function() {
        Avaliacao.respostas[Avaliacao.perguntaAtual] = this.value;

        if (Avaliacao.perguntaAtual != 3) {
            Avaliacao.perguntaAtual++;
            Avaliacao.loadNextQuestion();
        } else {
            Avaliacao.saveAnswers();
        }
    },

    loadNextQuestion: function() {
        $('#question')[0].innerHTML = Avaliacao.questoes[Avaliacao.perguntaAtual];
    },

    exibeFeedback: function() {
        $('#questionnaire').css('display', 'none');
        $('#startQuiz').css('feedback', 'flex'); 
    },

    saveAnswers: function() {
        $.ajax({
            url: 'localhost:8000/Voting/avaliacao/salvar',
            method: 'post',
            data: {respostas: Avaliacao.respostas}
        }).then((response) => {
            Swal.fire({
                title: 'Avaliação de Qualidade Finalizada',
                icon: 'info',
                text: 'O Estabelecimento agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.'
            })
        });
    },

    restartQuiz: function() {
        Avaliacao.perguntaAtual = 0;
        $('#startQuiz').css('display', 'flex'); 
        $('#questionnaire').css('display', 'none'); 
    }
}

Avaliacao.onLoadAvaliacao();