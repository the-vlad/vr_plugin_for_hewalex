<?php namespace Hewalex\Client;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

interface ClientInterface
{
    /**
     * DEBUG_* defines what should be done if request return an error.
     */
    const DEBUG_OFF = 0;
    const DEBUG_LOG = 1;
    const DEBUG_RETURN_BODY = 2;
    const DEBUG_THROW_EXCEPTION = 4;
    const DEBUG_LOG_AND_RETURN_BODY = 3;
    const DEBUG_LOG_AND_THROW_EXCEPTION = 5;
    const DEBUG_DEFAULT = self::DEBUG_OFF;

    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_ACCEPTED = 202;
    const STATUS_NO_CONTENT = 204;
    const STATUS_MOVED_PERMANENTLY = 301;
    const STATUS_FOUND = 302;
    const STATUS_NOT_MODIFIED = 304;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_PAYMENT_REQUIRED = 402;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_METHOD_NOT_ALLOWED = 405;
    const STATUS_NOT_ACCEPTABLE = 406;
    const STATUS_CONFLICT = 409;
    const STATUS_GONE = 410;
    const STATUS_PRECONDITION_FAILED = 412;
    const STATUS_REQUEST_ENTITY_TOO_LARGE = 413;
    const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_SERVICE_UNAVAILABLE = 503;

    const AUTH_JWT = 'JWT';

    /**
     * Set debug level.
     *
     * @param int $debug One of self::DEBUG_*
     *
     * @return Client
     */
    public function setDebugLevel($debug);

    /**
     * Check if last request ended with code < 400
     *
     * @return bool
     */
    public function isLastCallSuccess();

    /**
     * @return ResponseInterface
     */
    public function getLastResponse();

    /**
     * @return array
     */
    public function getLastRequestParams();

    /**
     * @return TransferStats|null
     */
    public function getStatistics();

    /**
     * Allow to override default client.
     *
     * @param GuzzleClientInterface $client
     *
     * @return Client
     */
    public function setClient(GuzzleClientInterface $client);

    /**
     * Return current client.
     *
     * @return ClientInterface
     */
    public function getClient();

    /**
     * Change response loading behaviour. False will disable loading response body content to the memory.
     *
     * @param $bool
     */
    public function setLoadContent($bool);

    /**
     * Set logger.
     *
     * @param LoggerInterface $logger
     *
     * @return Client
     */
    public function setLogger(LoggerInterface $logger);
}