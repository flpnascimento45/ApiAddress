<?php

namespace Source\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router
{

    /**
     * url completa
     * @var string
     */
    private $url = '';

    /**
     * prefixo comum entre todas as URLs
     * @var string
     */
    private $prefix = '';

    /**
     * variavel com as rotas
     * @var array
     */
    private $routes = [];

    /**
     * instancia da classe Request
     * @var Request
     */
    private $request;

    public function __construct($url)
    {
        $this->url = $url;
        $this->request = new Request();
        $this->setPrefix();
    }

    /**
     * Metodo para definir prefixo
     */
    private function setPrefix()
    {
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Metodo responsavel pelas rotas da classe
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route, $params = [])
    {

        foreach ($params as $key => $value) {

            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }

        }

        // variaveis de rota
        $params['variables'] = [];

        // padrao validacao de parametros
        $patternVariable = '/{(.*?)}/';

        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        // padrao validacao URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        // add rota
        $this->routes[$patternRoute][$method] = $params;

    }

    /**
     * Metodo que recebe as chamadas realizadas via GET
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Metodo que recebe as chamadas realizadas via POST
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Metodo que recebe as chamadas realizadas via PUT
     * @param string $route
     * @param array $params
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Metodo que recebe as chamadas realizadas via DELETE
     * @param string $route
     * @param array $params
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    /**
     * retorna uri sem prefixo
     * @return string
     */
    private function getUri()
    {
        $uri = $this->request->geturi();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);
    }

    /**
     * Retorna dados da rota
     * @return array
     */
    private function getRoute()
    {
        $uri = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();

        foreach ($this->routes as $patternRoute => $methods) {

            if (preg_match($patternRoute, $uri, $matches)) {

                if (isset($methods[$httpMethod])) {

                    // retira primeira posicao dos matches, pois eh a rota
                    unset($matches[0]);

                    // recupera as chaves obtidas no addRoute
                    $keys = $methods[$httpMethod]['variables'];

                    // recria as variaveis ja com suas chaves
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);

                    // adiciona objeto request as variaveis, caso necessaria consulta futura
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    return $methods[$httpMethod];

                }

                throw new Exception('Método não permitido!', 405);

            }

        }

        throw new Exception('URL não encontrada!', 404);

    }

    /**
     * Executa a rota atual
     * @return Response
     */
    public function run()
    {
        try {

            $route = $this->getRoute();

            if (!isset($route['controller'])) {
                throw new Exception('Url não pode ser processada!', 500);
            }

            $args = [];

            $reflection = new ReflectionFunction($route['controller']);

            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            // retorna execucao da funcao definida na chamada do router
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {

            $jsonReturn = new JsonResponse('error', '', $e->getMessage());

            return new Response($e->getCode(), $jsonReturn, 'json');

        }
    }

}
