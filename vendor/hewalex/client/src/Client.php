<?php namespace Hewalex\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\TransferStats;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Base Client Class.
 *
 * Class Client
 * @package Hewalex\Client
 */
class Client implements ClientInterface
{
    /**
     * Used to create authorization code.
     *
     * @var string
     */
    protected $secret;

    /**
     * Stores client instance.
     *
     * @var GuzzleClientInterface;
     */
    protected $client;

    /**
     * Send parameters as json payload
     *
     * @var bool
     */
    protected $isJson = false;

    /**
     * @var TransferStats|null
     */
    protected $stats;

    /**
     * @var mixed
     */
    private $debugLevels;

    /**
     * This flag will indicate that the request failed with RequestException (http status code 400+)
     *
     * @var bool
     */
    protected $lastCallSuccess;

    /**
     * @var ResponseInterface
     */
    protected $lastResponse;

    /**
     * @var array
     */
    protected $lastRequestParams = [];

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Change response loading behaviour. Returns response body on default content while is set true.
     *
     * @var bool
     */
    protected $loadContent = true;

    /**
     * @param array           $config
     * @param LoggerInterface $logger
     */
    public function __construct($config, LoggerInterface $logger = null)
    {
        if (!isset($config['timeout'])) {
            $config['timeout'] = 10;
        }
        $this->secret = $config['secret'];
        $this->debugLevels = $config['debug'];
        $this->loadContent = isset($config['load_content']) ? $config['load_content'] : true;
        $this->logger = $logger;
        $clientOptions = [
            'base_uri' => $config['url'],
            'timeout' => $config['timeout'],
        ];
        if (isset($config['ssl'])) {
            $clientOptions['verify'] = $config['ssl'];
        }
        if (isset($config['stats']) && $config['stats']) {
            $clientOptions['on_stats'] = function (TransferStats $stats) {
                $this->stats = $stats;
            };
        };
        if (!empty($config['headers'])) {
            $clientOptions['headers'] = $config['headers'];
        }
        if (!empty($config['user_agent'])) {
            $clientOptions['headers']['User-Agent'] = $config['user_agent'];
        }
        if (isset($config['handler'])) {
            $clientOptions['handler'] = $config['handler'];
        }
        $this->setClient(new GuzzleClient($clientOptions));
    }

    /**
     * @param int $debug
     *
     * @return Client
     */
    public function setDebugLevel($debug)
    {
        $this->debugLevels = $debug;

        return $this;
    }

    /**
     * Check if last request ended with code < 400
     *
     * @return bool
     */
    public function isLastCallSuccess()
    {
        return $this->lastCallSuccess;
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @return array
     */
    public function getLastRequestParams()
    {
        return $this->lastRequestParams;
    }

    /**
     * @return TransferStats|null
     */
    public function getStatistics()
    {
        return $this->stats;
    }

    /**
     * @param $bool
     */
    public function setLoadContent($bool)
    {
        $this->loadContent = (bool) $bool;
    }

    /**
     * Return authorization code of the application.
     *
     * @param string $codeGenerator
     *
     * @return string
     */
    protected function getAuthorizationCode($codeGenerator = null)
    {
        //@TODO Add more authorization Code generation methods
        switch ($codeGenerator) {
            default:
                return $this->getJWTAuthorizationCode();
        }
    }

    /**
     * Return JWT authorization code of the application.
     *
     * @return string
     */
    protected function getJWTAuthorizationCode()
    {
        $signer = new Sha256();
        $token = (new Builder())
            ->setIssuedAt(time())
            ->setExpiration(time() + 600)
            ->sign($signer, $this->secret)
            ->getToken();

        return $token->__toString();
    }

    /**
     * Handle 400+ responses depending on debug level
     * Extending debug requires 2^n levels
     *
     * @param \RuntimeException $e
     *
     * @return bool|string|array
     * @throws RequestException
     */
    protected function handleException(\RuntimeException $e)
    {
        $this->lastCallSuccess = false;
        if ($e instanceof RequestException) {
            $this->lastResponse = $e->getResponse();
        } else {
            $this->lastResponse = null;
        }
        $debugLevel = $this->getDebugLevel($e);

        if ($debugLevel & self::DEBUG_LOG) {
            if ($this->lastResponse) {
                $message = $this->lastResponse->getReasonPhrase();
                $context = [
                    'code' => $this->lastResponse->getStatusCode(),
                    'body' => $this->lastResponse->getBody()->getContents(),
                ];
                if ($this->logger) {
                    $this->logger->warning($message, $context);
                }
            }
        }

        if ($debugLevel & self::DEBUG_RETURN_BODY) {
            return $this->readContent($this->lastResponse);
        }

        if ($debugLevel & self::DEBUG_THROW_EXCEPTION) {
            throw $e;
        }
        
        return false;
    }

    /**
     * Send POST request and return response content in standard mode or $this on pool mode.
     *
     * Return false may be returned on exception.
     *
     * @param string $path    Action path.
     * @param array  $params  form parameters
     * @param array  $options Guzzle request options.
     *
     * @return bool|string|array|$this
     */
    protected function post($path, $params = [], $options = [])
    {
        $this->lastRequestParams = $params;
        $options = $this->fillDefaultOptions($options);
        if ($this->isJson) {
            $options['json'] = $params;
        } else {
            $options['form_params'] = $params;
        }
        
        try {
            return $this->readContent($this->client->post($path, $options));
        } catch (\RuntimeException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Send GET request and return response content in standard mode or $this on pool mode.
     *
     * Return false may be returned on response exception.
     *
     * @param string $path    Action path.
     * @param array  $params  uri parameters
     * @param array  $options Guzzle request options.
     *
     * @return bool|string|array|null|$this
     */
    protected function get($path, $params = [], $options = [])
    {
        $this->lastRequestParams = $params;
        if (!isset($options['query']) || !is_array($options['query'])) {
            $options['query'] = [];
        }
        $options['query'] += $params;
        $options = $this->fillDefaultOptions($options);

        try {
            $contentData = $this->readContent($this->client->get($path, $options));

            return $contentData;
        } catch (\RuntimeException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Send PATCH request and return response content.
     *
     * Return false may be returned on exception.
     *
     * @param string $path    Action path.
     * @param array  $params  form parameters
     * @param array  $options Guzzle request options.
     *
     * @return bool|string|array
     */
    protected function patch($path, $params = [], $options = [])
    {
        $this->lastRequestParams = $params;
        $options = $this->fillDefaultOptions($options);
        if ($this->isJson) {
            $options['json'] = $params;
        } else {
            $options['form_params'] = $params;
        }
        try {
            return $this->readContent($this->client->patch($path, $options));
        } catch (\RuntimeException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Send PUT request and return response content in standard mode or $this on pool mode.
     *
     * Return false on response exception.
     *
     * @param string $path    Action path.
     * @param array  $params  uri parameters
     * @param array  $options Guzzle request options.
     *
     * @return bool|string|array|$this
     */
    protected function put($path, $params = [], $options = [])
    {
        $this->lastRequestParams = $params;
        $options = $this->fillDefaultOptions($options);
        if ($this->isJson) {
            $options['json'] = $params;
        } else {
            $options['form_params'] = $params;
        }

        try {
            return $this->readContent($this->client->put($path, $options));
        } catch (\RuntimeException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Send DELETE request and return response content in standard mode or $this on pool mode.
     *
     * Return false on response exception.
     *
     * @param string $path    Action path.
     * @param array  $options Guzzle request options.
     *
     * @return bool|string|array|$this
     */
    protected function delete($path, $options = [])
    {
        $this->lastRequestParams = [];
        $options = $this->fillDefaultOptions($options);
        
        try {
            return $this->readContent($this->client->delete($path, $options));
        } catch (\RuntimeException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Add some default values to options array.
     *
     * Currently we just need to add authorization header.
     *
     * @param array $options
     *
     * @return mixed
     */
    protected function fillDefaultOptions($options)
    {
        $this->lastCallSuccess = true;

        isset($options['headers']) or $options['headers'] = [];

        return $options;
    }

    /**
     * Get json decoded value from response content.
     *
     * We expect that all responses will contain json encoded data.
     *
     * @param ResponseInterface|null $response
     *
     * @return string|array|null
     */
    protected function readContent(ResponseInterface $response = null)
    {
        $this->lastResponse = $response;
        if (null === $response) {
            return null;
        }

        if (!$this->loadContent) {
            return null;
        }

        $content = $response->getBody()->getContents();

        if (empty($content)) {
            return null;
        }

        if (false !== stripos($response->getHeaderLine('Content-Type'), 'application/json')) {
            return json_decode($content, true);
        }

        return $content;
    }

    /**
     * Allow to override default client.
     *
     * @param GuzzleClientInterface $client
     *
     * @return Client
     */
    public function setClient(GuzzleClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Return current client.
     *
     * @return GuzzleClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Find and return debug mode for given exception.
     *
     * @param \RuntimeException $e
     *
     * @return int
     */
    protected function getDebugLevel(\RuntimeException $e)
    {
        if (!is_array($this->debugLevels)) {
            return $this->debugLevels;
        }

        // 4XX || 5XX
        if ($e instanceof BadResponseException) {
            $statusCode = $e->getResponse()->getStatusCode();
            if (isset($this->debugLevels[$statusCode])) {
                return $this->debugLevels[$statusCode];
            }
            $class = get_class($e);
            if (isset($this->debugLevels[$class])) {
                return $this->debugLevels[$class];
            }
        }

        if ($e instanceof RequestException) {
            $class = get_class($e);
            if (isset($this->debugLevels[$class])) {
                return $this->debugLevels[$class];
            }
        }

        if ($e instanceof TransferException) {
            $class = get_class($e);
            if (isset($this->debugLevels[$class])) {
                return $this->debugLevels[$class];
            }
        }

        if ($e instanceof \RuntimeException) {
            if (isset($this->debugLevels[\RuntimeException::class])) {
                return $this->debugLevels[\RuntimeException::class];
            }
        }

        return self::DEBUG_DEFAULT;
    }

    /**
     * Set logger.
     *
     * @param LoggerInterface $logger
     *
     * @return Client
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }
}