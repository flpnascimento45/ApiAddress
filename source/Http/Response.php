<?php

namespace Source\Http;

class Response
{
    /**
     * Codigo da resposta
     * @var integer
     */
    private $httpCode;

    /**
     * Cabecalho da resposta
     */
    private $headers;

    /**
     * Tipo do conteudo de resposta
     * @var string
     */
    private $contentType;

    /**
     * Conteudo da resposta
     * @var mixed
     */
    private $content;

    public function __construct($httpCode, $content, $contentType)
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Metodo para adicionar chaves no cabecalho da resposta
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    private function sendHeaders()
    {
        http_response_code($this->httpCode);

        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }

    }

    public function sendResponse()
    {

        $this->sendHeaders();

        switch ($this->contentType) {
            case 'json':
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                break;
            default:
                echo $this->content;
        }
    }

}
