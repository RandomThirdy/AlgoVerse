<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $processId = $_POST['process_id'];
    $arrivalTime = $_POST['arrival_time'];
    $burstTime = $_POST['burst_time'];
    $priority = $_POST['priority'];
    $queueLevel = $_POST['ql'];

    foreach ($_SESSION['processes'] as &$process) {
        if ($process['id'] == $processId) {
            $process['arrival_time'] = $arrivalTime;
            $process['burst_time'] = $burstTime;
            $process['priority'] = $priority;
            $process['queue_level'] = $queueLevel;

            echo json_encode([
                'success' => true,
                'process' => $process
            ]);
            exit;
        }
    }

    echo json_encode([
        'success' => false,
        'message' => 'Process not found.'
    ]);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Invalid request.'
]);
exit;
?>