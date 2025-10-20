<?php

require_once 'vendor/autoload.php';

echo "=== Diagnostic API OpenAI ===\n\n";

try {
    // Récupérer la clé API
    $apiKey = getenv('OPENAI_API_KEY');
    if (!$apiKey) {
        $envFile = __DIR__ . '/.env';
        if (file_exists($envFile)) {
            $envContent = file_get_contents($envFile);
            if (preg_match('/OPENAI_API_KEY=(.+)/', $envContent, $matches)) {
                $apiKey = trim($matches[1]);
            }
        }
    }

    if (!$apiKey) {
        throw new Exception('❌ Clé API OpenAI non trouvée');
    }

    echo "✅ Clé API trouvée\n";

    // Tester la connexion à l'API
    $client = new \GuzzleHttp\Client();
    $response = $client->post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Réponds simplement "OK" si tu reçois ce message.'
                ]
            ],
            'max_tokens' => 10,
            'temperature' => 0.1,
        ],
        'timeout' => 30,
    ]);

    $result = json_decode($response->getBody()->getContents(), true);

    if (isset($result['choices'][0]['message']['content'])) {
        echo "✅ API OpenAI fonctionnelle\n";
        echo "📝 Réponse : " . trim($result['choices'][0]['message']['content']) . "\n";
        echo "\n🎉 L'API fonctionne ! Le problème pourrait être résolu maintenant.\n";
    } else {
        throw new Exception('Réponse API invalide');
    }

} catch (\GuzzleHttp\Exception\ClientException $e) {
    $response = $e->getResponse();
    $statusCode = $response->getStatusCode();
    $body = json_decode($response->getBody()->getContents(), true);

    echo "❌ Erreur API OpenAI (Code: $statusCode)\n";

    if (isset($body['error']['message'])) {
        echo "📝 Message d'erreur : " . $body['error']['message'] . "\n";
    }

    if ($statusCode === 429) {
        echo "\n💡 Solution : Votre quota OpenAI est dépassé.\n";
        echo "   - Vérifiez votre compte OpenAI : https://platform.openai.com/usage\n";
        echo "   - Ajoutez des crédits ou attendez la réinitialisation mensuelle\n";
    } elseif ($statusCode === 401) {
        echo "\n💡 Solution : Clé API invalide.\n";
        echo "   - Vérifiez votre clé API dans le fichier .env\n";
        echo "   - Générez une nouvelle clé sur https://platform.openai.com/api-keys\n";
    }

} catch (\Exception $e) {
    echo "❌ Erreur générale : " . $e->getMessage() . "\n";
    echo "💡 Vérifiez votre connexion internet et la configuration réseau.\n";
}

echo "\n=== Fin du diagnostic ===\n";