<?php

/**
 * A simple example of sending log data to Azure Sentinel
 * via the Azure Log Analytics Data Collector API
 */

class AzureSentinel
{
    /**
     * Properties
     */
    private $workspaceId;
    private $sharedKey;
    private $logType;
    private $apiVersion;

    /**
     * Constructor
     */
    public function __construct($workspaceId, $sharedKey, $logType = 'MyCustomLog', $apiVersion = '2016-04-01')
    {
        $this->workspaceId = $workspaceId;
        $this->sharedKey = $sharedKey;
        $this->logType = $logType;
        $this->apiVersion = $apiVersion;
    }

    /**
     * Methods
     */
    public function sendLogData($logData)
    {
        $date = gmdate('D, d M Y H:i:s T');
        $contentLength = strlen($logData);
        $signature = $this->buildSignature($date, $contentLength);
        $uri = "https://{$this->workspaceId}.ods.opinsights.azure.com/api/logs?api-version={$this->apiVersion}";

        $headers = [
            'Content-Type: application/json',
            'Authorization: SharedKey ' . $this->workspaceId . ':' . $signature,
            'Log-Type: ' . $this->logType,
            'x-ms-date: ' . $date,
            'time-generated-field: ' . time(),
        ];

        // Optionally, yo may use Guzzle instead
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $logData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // Create signature
    private function buildSignature($date, $contentLength)
    {
        $xHeaders = "x-ms-date:" . $date;
        $stringToHash = "POST\n$contentLength\napplication/json\n$xHeaders";
        $bytesToHash = utf8_encode($stringToHash);
        $keyBytes = base64_decode($this->sharedKey);
        $hashedString = hash_hmac('sha256', $bytesToHash, $keyBytes, true);
        $encodedHash = base64_encode($hashedString);

        return $encodedHash;
    }
}
