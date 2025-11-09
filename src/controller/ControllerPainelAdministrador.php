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
        $result = Query::query($sql);

        if ($result) {
            while ($setor = pg_fetch_assoc($result)) {
                $setores[] = $setor;
            }
        }


        return new Response(json_encode($setores));
    }

    public function getPerguntasByIdSetor() {
        $idSetor = $_GET['idSetor'];
        $sql = 'SELECT * FROM pergunta where id_setor = ' . $idSetor;
        $perguntas = [];
        $result = Query::query($sql);

        if ($result) {
            while ($pergunta = pg_fetch_assoc($result)) {
                $perguntas[] = $pergunta;
            }
        }

        return new Response(json_encode($perguntas));
    }

    public function inserirSetor() {
        $nomeSetor = $_POST['nome'];
        Query::insertQueryPrepared('setor', ['nome'], [$nomeSetor]);
    }

    public function alterarSetor() {
        parse_str(file_get_contents("php://input"), $_PUT);
        $idSetor = $_PUT['idSetor'];
        $nomeSetor = $_PUT['nome'];
        Query::update('setor', ["nome = '$nomeSetor'"], ["id = $idSetor"]);
    }

    public function excluirSetor() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $idSetor = $_DELETE['idSetor'];

        if ($this->validaSetorPossuiPerguntasCadastradas($idSetor)) {
            throw new Exception("Não é possível excluir o setor $idSetor pois o mesmo possui perguntas cadastradas.");
        }

        Query::delete('setor', ["id = $idSetor"]);
    }

    private function validaSetorPossuiPerguntasCadastradas(int $setor) {
        $sql = 'SELECT * FROM pergunta where id_setor = ' . $setor;
        $result = Query::query($sql);

        if ($result) {
            if ($setor = pg_fetch_assoc($result)) {
                return true;
            }
        }

        return false;
    }
}