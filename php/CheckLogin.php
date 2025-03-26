<!-- <?php
session_start();

// Output as JSON
header('Content-Type: application/json');

// Debug information
$debug = [
    'session_id' => session_id(),
    'session_status' => session_status(),
    'session_data' => $_SESSION
];

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

echo json_encode([
    'logged_in' => $loggedIn,
    'debug' => $debug
]);
?>  -->