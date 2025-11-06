<?php

namespace src\controller;

class Controller {
    
    /**
     * Send a view data to the cliente
     * @param string $url
     * @return void
     */
    public function view(string $url) {
        $caminho = __DIR__ . '/../../views/' . $url;

        if (file_exists($caminho)) {
            $pagina = file_get_contents($caminho);
            echo $pagina;
        }
    }
}