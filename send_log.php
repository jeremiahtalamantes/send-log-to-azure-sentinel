<?php

/**
 * A simple example of sending log data to Azure Sentinel
 * via the Azure Log Analytics Data Collector API
 */


/**
 * Replace these placeholders with your actual Workspace ID and Shared Key
 */
$workspaceId = getenv('your_workspace_id'); // Avoid hardcoding, use environment variable intstead
$sharedKey = getenv('your_shared_key'); // Avoid hardcoding, use environment variable intstead

// Instantiate
$azureSentinel = new AzureSentinel($workspaceId, $sharedKey);

// Prepare log data as a JSON string
$logData = json_encode([
    [
        "timestamp" => time(),
        "message" => "Sample log message",
        "severity" => "INFO",
    ],
]);

// Send log data to Azure Sentinel
$response = $azureSentinel->sendLogData($logData);

// Optionally, you can return the response here
echo $response;