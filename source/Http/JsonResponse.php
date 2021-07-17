<?php

namespace Source\Http;

class JsonResponse
{

    /**
     * tipo do retorno (success / error)
     * @var string
     */
    public $returnStatus;

    /**
     * Conteudo do retorno, em caso de sucesso
     * @var mixed
     */
    public $data;

    /**
     * conteudo da mensagem de erro
     * @var string
     */
    public $errorMessage;

    public function __construct($returnStatus, $data, $errorMessage = '')
    {
        $this->returnStatus = $returnStatus;
        $this->data = $data;
        $this->errorMessage = $errorMessage;
    }

}
