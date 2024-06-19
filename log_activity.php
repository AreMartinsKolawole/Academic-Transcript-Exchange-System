<?php
// Function to log activity
function logActivity($message) {
    // Set the time zone to West Central Africa
    date_default_timezone_set('Africa/Lagos');

    // Log file path
    $logFile = 'system_logs.log';
    
    // Log message with timestamp
    $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    
    // Write message to log file
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>
