<?php

// Replace with your Cloudflare API Token
$apiToken = '##################';

// Specify the zone ID for which you want to delete DNS records
$zoneId = '######################';

// Cloudflare API endpoint for DNS records
$apiUrl = "https://api.cloudflare.com/client/v4/zones/{$zoneId}/dns_records";

// Initialize cURL session
$ch = curl_init();

// Set cURL options for authentication
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiToken,
    'Content-Type: application/json',
]);

// Execute the cURL request to fetch DNS records
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    exit();
}

// Parse the response JSON
$data = json_decode($response, true);

// Check if DNS records were retrieved successfully
if (isset($data['result']) && is_array($data['result'])) {
    // Loop through and delete each DNS record
    foreach ($data['result'] as $record) {
        $recordId = $record['id'];
        
        // Send DELETE request for each DNS record
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_URL, $apiUrl . '/' . $recordId);
        $deleteResponse = curl_exec($ch);
        
        // Check for errors when deleting
        if (curl_errno($ch)) {
            echo 'Error deleting DNS record with ID ' . $recordId . ': ' . curl_error($ch) . PHP_EOL;
        } else {
            echo 'Deleted DNS record with ID ' . $recordId . PHP_EOL;
        }
    }
} else {
    echo 'Error fetching DNS records. Response: ' . $response;
}

// Close cURL session
curl_close($ch);
?>

