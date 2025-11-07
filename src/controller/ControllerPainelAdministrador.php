<?php

namespace src\controller;

use database\Query;
use Symfony\Component\HttpFoundation\Response;

class ControllerPainelAdministrador extends Controller {

    /** Retorna a view de painel do administrador */
    public function getView() {
        return $this->view('painelAdministrador.html');
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
}