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
        $('#areaAvaliacao').on('click', PainelAdministrador.onClickBotaoAvalicao);
        $('#btnIncluirSetor').on('click', PainelAdministrador.onClickBotaoIncluirSetor);
        $('#modalSetorBotaoFechar').on('click', PainelAdministrador.modalSetorBotaoFechar);
        $('#modalSetorBotaoConfirmar').on('click', PainelAdministrador.modalSetorBotaoConfirmar);
        $('#btnIncluirPergunta').on('click', PainelAdministrador.modalSetorAbrirModalPergunta);
    },

    onClickOpcaoMenuSetores: function() {
        PainelAdministrador.carregaSetores();
    },

    carregaSetores: function() {
        let fnCarregaTabelaSetores = function(response) {
            $('#tebelaSetores > tbody').empty();
            let setores = Object.values(JSON.parse(response));

            for (let i = 0; i < setores.length; i++) {
                let novaLinhaSetor = `
                    <tr>
                        <td>${setores[i]['id']}</td>
                        <td>${setores[i]['nome']}</td>
                        <td><button class="btn btn-warning btn-sm" name="modalSetorBotaoAlterar${setores[i]['id']}" id="modalSetorBotaoAlterar${setores[i]['id']}">Alterar</button></td>
                        <td><button class="btn btn-danger btn-sm" name="modalSetorBotaoExcluir${setores[i]['id']}" id="modalSetorBotaoExcluir${setores[i]['id']}">Excluir</button></td>
                    </tr>
                `;

                $('#tebelaSetores > tbody').append(novaLinhaSetor);
                $(`#modalSetorBotaoAlterar${setores[i]['id']}`).on('click', function() {
                    PainelAdministrador.onClickBotaoIncluirSetor.apply(PainelAdministrador, [setores[i]]);
                });
                $(`#modalSetorBotaoExcluir${setores[i]['id']}`).on('click', function() {
                    PainelAdministrador.modalSetorOnClickBotaoDeletar.apply(PainelAdministrador, [setores[i]['id']]);
                });
            }

            $('#menuItensAguarde').css('display', 'none'); 
            $('#setores').css('display', 'flex'); 
        }

        $('#setores').css('display', 'none'); 
        $('#perguntas').css('display', 'none'); 
        $('#menuItensAguarde').css('display', 'flex'); 
        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/painelAdministrador/setores',
            method: 'get',
            async: false,
            fnSucess: fnCarregaTabelaSetores
        });
    },

    onClickOpcaoMenuPerguntas: function() {
        $('#setores').css('display', 'none'); 
        $('#menuItensAguarde').css('display', 'flex'); 
        PainelAdministrador.carregaMenuPerguntas();
    },
    
    carregaMenuPerguntas: function() {
        let fnCarregaFiltroSetores = function(response) {
            $('#tebelaPerguntas > tbody').empty();
            let setores = Object.values(JSON.parse(response));
            $('#listaSetores').append('<option value="0">Selecione...</option>');

            for (let i = 0; i < setores.length; i++) {
                let novaOpcaoSetor = `<option value="${setores[i]['id']}">${setores[i]['nome']}</option>`;
                $('#listaSetores').append(novaOpcaoSetor);
            }

            $('#menuItensAguarde').css('display', 'none'); 
            $('#perguntas').css('display', 'flex'); 
            $('#setores').css('display', 'none'); 
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/painelAdministrador/setores',
            method: 'get',
            async: false,
            fnSucess: fnCarregaFiltroSetores
        });
    },

    onClickBtnCarregarPerguntas: function() {
        let setor = $('#listaSetores').val();
        
        if (parseInt(setor) == 0) {
            Message.warn('Alerta', 'Selecione um setor para consultar as perguntas.');
            return;
        }

        $('#tebelaPerguntas > tbody').empty();

        let fnCarregaTabelaPerguntas = function(response) {
            let perguntas = JSON.parse(response);
            
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
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/painelAdministrador/perguntas',
            method: 'get',
            data: {idSetor: setor},
            fnSucess: fnCarregaTabelaPerguntas
        });
    },

    onClickBotaoAvalicao: function() {
        $(location).attr('href', 'http://localhost/Voting/public/avaliacao');
    },

    onClickBotaoIncluirSetor: function(registro) {
        if (registro['id'] != undefined && registro['id'] != '') {
            $('#modalSetorIdSetor')[0].value = registro['id'];
            $('#modalSetorNomeSetor')[0].value = registro['nome'];
            $('#modalSetorTitulo')[0].innerHTML = 'Alterar Setor';
        } else {
            $('#modalSetorTitulo')[0].innerHTML = 'Incluir Setor';
        }

        $('#app').css('opacity', '0.1');
        $('#areaModal').css('display', 'flex');
        $('#modalSetor').css('display', 'flex'); 
    },

    modalSetorBotaoFechar: function() {
        $('#app').css('opacity', '1');
        $('#areaModal').css('display', 'none'); 
        $('#modalSetor').css('display', 'none'); 
        $('#modalSetorNomeSetor')[0].value = ''; 
    },

    modalSetorBotaoConfirmar: function() {
        let idSetor = $('#modalSetorIdSetor').val();
        let nomeSetor = $('#modalSetorNomeSetor').val();

        if (nomeSetor == '') {
            Message.warn('Alerta', 'O nome do setor não pode ficar em branco!');
            return;
        }

        let url = 'http://localhost/Voting/public/painelAdministrador/setor/incluir';
        let method = 'post';

        let fnAfterClickBotaoConfirmar = function() {
            Message.success('Sucesso!', 'Setor inserido com sucesso!', function() {
                PainelAdministrador.modalSetorBotaoFechar();
                PainelAdministrador.carregaSetores();
            });
        }

        if (idSetor != '') {
            url = 'http://localhost/Voting/public/painelAdministrador/setor/alterar';
            method = 'put';
            fnAfterClickBotaoConfirmar = function() {
                Message.success('Sucesso!', 'Setor alterado com sucesso!', function() {
                    PainelAdministrador.modalSetorBotaoFechar();
                    PainelAdministrador.carregaSetores();
                });
            }
        }

        Ajax.loadAjax({
            url: url,
            method: method,
            data: {idSetor: idSetor, nome: nomeSetor},
            fnSucess: fnAfterClickBotaoConfirmar
        });
    },

    modalSetorOnClickBotaoDeletar: function(idSetor) {
        let fnAfterClickBotaoDeletar = function() {
            Message.success('Sucesso!', 'Setor removido com sucesso!', function() {
                PainelAdministrador.carregaSetores();
            });
        }

        Ajax.loadAjax({
            url: 'http://localhost/Voting/public/painelAdministrador/setor/deletar',
            method: 'delete',
            data: {idSetor: idSetor},
            fnSucess: fnAfterClickBotaoDeletar
        });
    },

    modalSetorAbrirModalPergunta: function() {
        $('#modalPerguntaTitulo')[0].innerHTML = 'Incluir Pergunta';
        $('#app').css('opacity', '0.1');
        $('#areaModal').css('display', 'flex'); 
        $('#modalPergunta').css('display', 'flex'); 
    }
}

PainelAdministrador.onLoadPainelAdministrador();