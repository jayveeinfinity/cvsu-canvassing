<?php
    require_once __DIR__ . '/vendor/autoload.php';

    use Google\Client;
    use Google\Service\Oauth2;

    $clientId = '1066326778049-oltq050ct12mcija02gkdd6ojcpqc01q.apps.googleusercontent.com';
    $clientSecret = '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';

    $client = new Client();
    $client->setClientId($clientId);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri('http://localhost/cvsu-canvassing/callback.php');
    $client->setScopes(Oauth2::USERINFO_EMAIL);

    echo $client->createAuthUrl();
    exit;

    $token = $_POST['idToken'];

    $data = [];

    try {
        $payload = $client->verifyIdToken($token);
        if (!$payload) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid token'
            ];
        }
        $userId = $payload['sub'];
        $email = $payload['email'];
        $name = $payload['name'];
        $data = [
            'userId' => $userId, 'email' => $email, 'name' => $name
        ];
    } catch (Exception $e) {
        $data = [
            'error' => 'Error: ' . $e->getMessage()
        ];
    }

    echo json_encode($data);
?>