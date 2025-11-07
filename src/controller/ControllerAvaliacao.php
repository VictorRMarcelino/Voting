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
     * Retorna as perguntas da avaliação
     * @return Response
     */
    public function getPerguntas() {
        $sql = 'SELECT * FROM pergunta LIMIT 10';
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
        $dataAtual = date('d-m-Y');
        $respostas = $_POST['respostas'];
        $feedback = isset($respostas['feedback']) ? $respostas['feedback'] : '';
        $idAvaliacao = Query::insertQueryPrepared('avaliacao', ['feedback', 'datahora', 'id_setor', 'id_dispositivo'], [$feedback, $dataAtual, 1, 1], 'RETURNING ID');
        
        foreach ($respostas as $numeroPergunta => $resposta) {
            if ($numeroPergunta == 0) {
                continue;
            }

            Query::insertQueryPrepared('respostas', ['id_avaliacao', 'id_pergunta', 'resposta'], [$idAvaliacao, $numeroPergunta, $resposta]);
        }
    }
}