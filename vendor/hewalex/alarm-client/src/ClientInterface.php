<?php

namespace Hewalex\AlarmClient;

interface ClientInterface 
{
    public function getDevicesDiagnoseSummary($deviceType, $startTime, $params);
    
    public function getDeviceDiagnoseResult($deviceType, $deviceId, $startTime, $params);

    public function getSupervisionAll($nip);
}
