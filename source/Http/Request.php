<?php

namespace Source\Http;

class Request
{

    /**
     * Metodo http da requisicao
     * @var string
     */
    private $httpMethod;

    /**
     * Parametro da URI
     * @var string
     */
    private $uri;

    /**
     * Parametros da URL
     * @var array
     */
    private $queryParams;

    /**
     * Parametros recebidos via POST
     * @var array
     */
    private $postVars;

    /**
     * Parametros do cabecalho
     * @var array
     */
    private $headers;

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST == [] ? json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY) : $_POST;
        $this->headers = getallheaders();
        $this->setUri();
    }

    private function setUri()
    {
        $xUri = explode('?', $_SERVER['REQUEST_URI']);
        $this->uri = $xUri[0];
    }

    /**
     *
     * @return  string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     *
     * @return  string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     *
     * @return  array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     *
     * @return  array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     *
     * @return  array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
