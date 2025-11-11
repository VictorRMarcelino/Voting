<?php

namespace src\controller;

use database\Query;
use Exception;
use src\core\Sessao;
use Symfony\Component\HttpFoundation\Response;

class ControllerPainelAdministrador extends Controller {

    /** Retorna a view de painel do administrador */
    public function getView() {
        if (Sessao::isUsuarioLogado()) {
            $this->view('painelAdministrador.html');
        } else {
            $this->view('login.html');
        }
    }

    /**
     * Retorna todos os setores
     * @return Response
     */
    public function getSetores() {
        $sql = 'SELECT * FROM setor';
        $setores = [];
        $result = Query::select('setor', ['*']);

        if ($result) {
            while ($setor = pg_fetch_assoc($result)) {
                $setores[] = $setor;
            }
        }

        return new Response(json_encode($setores));
    }

    /**
     * Retorna as perguntas vinculadas com um setor
     * @return Response
     */
    public function getPerguntasByIdSetor() {
        $idSetor = $_GET['idSetor'];
        $perguntas = [];
        $result = Query::select('pergunta', ['*'], ['id_setor = $1'], [$idSetor], ['id asc']);

        if ($result) {
            while ($pergunta = pg_fetch_assoc($result)) {
                $perguntas[] = $pergunta;
            }
        }

        return new Response(json_encode($perguntas));
    }

    /**
     * Insere um novo setor
     * @return void
     */
    public function inserirSetor() {
        $nomeSetor = $_POST['nome'];
        Query::insertQueryPrepared('setor', ['nome'], [$nomeSetor]);
    }

    /**
     * Realiza o update de um setor
     * @return void
     */
    public function alterarSetor() {
        parse_str(file_get_contents("php://input"), $_PUT);
        $idSetor = $_PUT['idSetor'];
        $nomeSetor = $_PUT['nome'];
        Query::update('setor', ["nome = '$nomeSetor'"], ["id = $idSetor"]);
    }

    /**
     * Realiza a exclusão de um setor
     * @throws \Exception
     * @return void
     */
    public function excluirSetor() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $idSetor = $_DELETE['idSetor'];

        if ($this->validaSetorPossuiPerguntasCadastradas($idSetor)) {
            throw new Exception("Não é possível excluir o setor $idSetor pois o mesmo possui perguntas cadastradas.");
        }

        Query::delete('setor', ["id = $idSetor"]);
    }

    /**
     * Verifica se determinado setor já possui ao menos uma pergunta cadastrada
     * @param int $setor
     * @return bool
     */
    private function validaSetorPossuiPerguntasCadastradas(int $setor) {
        $sql = 'SELECT * FROM pergunta where id_setor = ' . $setor;
        $result = Query::select('pergunta', ['*'], ['id_setor = $1'], [$setor]);

        if ($result) {
            if ($setor = pg_fetch_assoc($result)) {
                return true;
            }
        }

        return false;
    }

    /** Insere uma nova pergunta */
    public function inserirPergunta() {
        $idSetor = $_POST['idSetor'];
        $pergunta = $_POST['pergunta'];
        Query::insertQueryPrepared('pergunta', ['id_setor', 'pergunta'], [$idSetor, $pergunta]);
    }

    /** Realiza o update de uma pergunta */
    public function alterarPergunta() {
        parse_str(file_get_contents("php://input"), $_PUT);
        $idPergunta = $_PUT['idPergunta'];
        $idSetor = $_PUT['idSetor'];
        $questao = $_PUT['pergunta'];
        Query::update('pergunta', ["id_setor = $idSetor, pergunta = '$questao'"], ["id = $idPergunta"]);
    }

    /** Realiza a exclusão de uma pergunta */
    public function excluirPergunta() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $idPergunta = $_DELETE['idPergunta'];
        Query::delete('pergunta', ["id = $idPergunta"]);
    }
}