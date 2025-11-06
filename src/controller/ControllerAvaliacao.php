<?php

namespace src\controller;

use database\Conexao;
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
    
    /**
     * Retorna a tela de avaliação
     * @return void
     */
    public function getTela() {
        $this->view('avaliacao.html');
    }

    /**
     * Retorna as perguntas da avaliação
     * @return Response
     */
    public function getPerguntas() {
        $sql = 'SELECT * FROM pergunta LIMIT 10';
        $perguntas = [];
        $result = Conexao::query($sql);

        if ($result) {
            while ($pergunta = pg_fetch_assoc($result)) {
                $perguntas[] = $pergunta['pergunta'];
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
        $sqlInsertAvalicao = 'INSERT INTO avaliacao(feedback, datahora, id_setor, id_dispositivo) VALUES ($1, $2, $3, $4)';
        $dataAtual = date('d-m-Y');
    }

    /**
     * Salva as respostas da avaliação
     * @return void
     */
    private function salvaRespostas() {

    }
}