<?php
require 'vendor/autoload.php';

function verifyGoogleToken($idToken) {
    $client = new Google_Client(['client_id' => '1066326778049-oltq050ct12mcija02gkdd6ojcpqc01q.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($idToken);

    if ($payload) {
        $userId = $payload['sub'];
        $email = $payload['email'];
        $name = $payload['name'];
        // Use this data to create or login the user
        return ['userId' => $userId, 'email' => $email, 'name' => $name];
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $idToken = $input['id_token'] ?? '';
    $userData = verifyGoogleToken($idToken);

    if ($userData) {
        // Check if user exists in DB, otherwise register
        echo json_encode(['status' => 'success', 'user' => $userData]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    }
}
?>
