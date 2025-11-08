<?php

namespace src\controller;

use database\Query;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller Avaliacao
 * @package src
 * @subpackage controller
 * @author Victor Ramos <httpsvictorramos@gmail.com>
 * @since 05/11/2025
 */
class ControllerAvaliacao extends Controller {
    
    /** Retorna a view de avaliação */
    public function getView() {
        $this->view('avaliacao.html');
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

    /**
     * Retorna as perguntas da avaliação
     * @return Response
     */
    public function getPerguntas() {
        $setor = $_GET['setor'];
        $sql = 'SELECT * FROM pergunta where id_setor = ' . $setor;
        $perguntas = [];
        $result = Query::query($sql);

        if ($result) {
            while ($pergunta = pg_fetch_assoc($result)) {
                $perguntas[$pergunta['id']] = $pergunta['pergunta'];
            }
        }

        return new Response(json_encode($perguntas));
    }

    /**
     * Salvar Avaliação
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function salvarAvaliacao(Request $request) {
        Query::begin();
        $dataAtual = date('d-m-Y');
        $respostas = $_POST;
        $setor = array_pop($respostas);
        $feedback = array_pop($respostas);
        $idAvaliacao = Query::insertQueryPreparedReturningColumn('avaliacao', ['feedback', 'datahora', 'id_setor', 'id_dispositivo'], [$feedback, $dataAtual, $setor, 1], 'ID');
        
        foreach ($respostas as $numeroPergunta => $resposta) {
            Query::insertQueryPrepared('respostas', ['id_avaliacao', 'id_pergunta', 'resposta'], [$idAvaliacao, $numeroPergunta, $resposta]);
        }

        Query::commit();
    }
}