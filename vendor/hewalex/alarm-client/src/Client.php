<?php

namespace Hewalex\AlarmClient;

use Hewalex\Client\Client as HewalexClient;
use Psr\Log\LoggerInterface;

class Client extends HewalexClient implements ClientInterface 
{
    protected $apiEndpoint = '';

    public function __construct(array $config, LoggerInterface $logger = null) 
    {
        $endpoints = $config['endpoints'] ?? [];
        if (array_key_exists('api', $endpoints)) {
            $this->apiEndpoint = $endpoints['api'];
        }

        parent::__construct($config, $logger);
    }
    
    public function getDevicesDiagnoseSummary($deviceType, $startTime, $params): array
    {
        return $this->get($this->apiEndpoint . 'diag/' . $deviceType . '/get-daily-diagnose-result/' . $startTime, $params);
    }
    
    public function getDeviceDiagnoseResult($deviceType, $deviceId, $startTime, $params): array
    {
        return $this->get($this->apiEndpoint . 'diag/' . $deviceType . '/get-device-diagnose-result/' . $deviceId . '/' . $startTime, $params);
    }

    public function getSupervisionAll($nip): array
    {
        return $this->get('supervision/'. $nip .'/all');
    }
}