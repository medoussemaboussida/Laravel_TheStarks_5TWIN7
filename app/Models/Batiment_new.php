<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Batiment extends Model
{
    use HasFactory;

    protected $table = 'batiments';

    protected $fillable = [
        'type_batiment',
        'adresse',
        'emission_c_o2',
        'nb_habitants',
        'nb_employes',
        'type_industrie',
        'pourcentage_renouvelable',
        'emission_reelle',
        'zone_id',
        'type_zone_urbaine',
        'recyclage_data',
        'energies_renouvelables_data',
        'emission_data',
        'user_id',
    ];

    protected $casts = [
        'emission_c_o2' => 'float',
        'pourcentage_renouvelable' => 'float',
        'emission_reelle' => 'float',
        'nb_habitants' => 'integer',
        'nb_employes' => 'integer',
        'recyclage_data' => 'array',
        'energies_renouvelables_data' => 'array',
        'emission_data' => 'array',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ZoneUrbaine::class, 'zone_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setEmissionCO2Attribute($value)
    {
        $this->attributes['emission_c_o2'] = (float) $value;
        $this->attributes['emission_reelle'] = $this->calculateEmissionReelle(
            (float) $value,
            $this->attributes['pourcentage_renouvelable'] ?? 0.0
        );
    }

    public function setPourcentageRenouvelableAttribute($value)
    {
        $this->attributes['pourcentage_renouvelable'] = (float) $value;
        $this->attributes['emission_reelle'] = $this->calculateEmissionReelle(
            $this->attributes['emission_c_o2'] ?? 0.0,
            (float) $value
        );
    }

    private function calculateEmissionReelle(float $co2, float $pct): float
    {
        return $co2 * (1 - $pct / 100);
    }

    public function getNbArbresBesoinAttribute(): int
    {
        return (int) ceil(($this->emission_reelle ?? 0.0) / 0.02);
    }

    // Accesseurs pour les anciens noms
    public function getEmissionCO2Attribute()
    {
        return $this->attributes['emission_c_o2'] ?? 0.0;
    }

    public function getNbHabitantsAttribute()
    {
        return $this->attributes['nb_habitants'] ?? null;
    }

    public function getNbEmployesAttribute()
    {
        return $this->attributes['nb_employes'] ?? null;
    }

    // Mutateurs pour les anciens noms (compatibilitÃ©)
    public function setNbHabitantsAttribute($value)
    {
        $this->attributes['nb_habitants'] = $value;
    }

    public function setNbEmployesAttribute($value)
    {
        $this->attributes['nb_employes'] = $value;
    }

    public function setTypeIndustrieAttribute($value)
    {
        $this->attributes['type_industrie'] = $value;
    }

    // Accesseur pour les donnÃ©es de recyclage (toujours retourner un tableau)
    public function getRecyclageDataAttribute()
    {
    return $this->attributes['recyclage_data']
        ? json_decode($this->attributes['recyclage_data'], true)
        : [];
}

    // Mutateur pour s'assurer que les donnÃ©es de recyclage sont correctement formatÃ©es
    public function setRecyclageDataAttribute($value)
    {
        if (is_array($value)) {
            // S'assurer que quantites est toujours un tableau avec des valeurs numÃ©riques
            if (isset($value['quantites']) && is_array($value['quantites'])) {
                foreach ($value['quantites'] as $key => $quantite) {
                    $value['quantites'][$key] = (float) $quantite;
                }
            }
            $this->attributes['recyclage_data'] = json_encode($value);
        } elseif (is_string($value)) {
            $this->attributes['recyclage_data'] = $value;
        } else {
            $this->attributes['recyclage_data'] = null;
        }
    }

    // Accesseur pour vÃ©rifier si le recyclage existe
    public function getRecyclageExisteAttribute()
    {
        $data = $this->recyclageData;
        return $data && isset($data['existe']) && $data['existe'];
    }

    // Accesseur pour vÃ©rifier si les Ã©nergies renouvelables existent
    public function getEnergiesRenouvelablesExisteAttribute()
    {
        $data = $this->energies_renouvelables_data;
        return !empty($data);
    }

    public function setEnergiesRenouvelablesDataAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['energies_renouvelables_data'] = json_encode($value);
        } elseif (is_string($value)) {
            // Si c'est dÃ©jÃ  du JSON, on le garde tel quel
            $this->attributes['energies_renouvelables_data'] = $value;
        } else {
            $this->attributes['energies_renouvelables_data'] = null;
        }
    }

    // Accesseur pour s'assurer que energies_renouvelables_data retourne toujours un tableau
    public function getEnergiesRenouvelablesDataAttribute()
    {
        $value = $this->attributes['energies_renouvelables_data'] ?? null;

        if (is_null($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    // Accesseur pour le type de zone urbaine formatÃ©
    public function getTypeZoneUrbaineFormattedAttribute()
    {
        $types = [
            'zone_industrielle' => 'Zone Industrielle',
            'quartier_residentiel' => 'Quartier RÃ©sidentiel',
            'centre_ville' => 'Centre Ville'
        ];

        return $this->type_zone_urbaine ? ($types[$this->type_zone_urbaine] ?? $this->type_zone_urbaine) : null;
    }

    /**
     * PrÃ©dire les Ã©missions CO2 et le pourcentage renouvelable en utilisant une API IA
     */
    public static function predictEmissionsWithAI(array $buildingData): array
    {
        try {
            // PrÃ©parer les donnÃ©es pour l'API IA
            $apiData = [
                'type_batiment' => $buildingData['type_batiment'] ?? null,
                'emission_data' => $buildingData['emission_data'] ?? [],
                'energies_renouvelables_data' => $buildingData['energies_renouvelables_data'] ?? [],
                'recyclage_data' => $buildingData['recyclage_data'] ?? [],
                'type_industrie' => $buildingData['type_industrie'] ?? null,
            ];

            // Configuration de l'API IA (exemple avec OpenAI ou autre service)
            $apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));
            $apiUrl = 'https://api.openai.com/v1/chat/completions';

            if (!$apiKey) {
                // Fallback vers des valeurs par dÃ©faut si pas d'API configurÃ©e
                return self::getDefaultPredictions($apiData);
            }

            // PrÃ©parer le prompt pour l'IA
            $prompt = self::buildAIPrompt($apiData);

            // Appel Ã  l'API OpenAI
            $response = self::callOpenAI($apiUrl, $apiKey, $prompt);

            // Parser la rÃ©ponse et retourner les prÃ©dictions
            return self::parseAIResponse($response);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la prÃ©diction IA des Ã©missions: ' . $e->getMessage());

            // Fallback vers des valeurs par dÃ©faut
            return self::getDefaultPredictions($buildingData);
        }
    }

    /**
     * Construire le prompt pour l'IA
     */
    private static function buildAIPrompt(array $data): string
    {
        $typeBatiment = $data['type_batiment'] ?? 'inconnu';
        $typeIndustrie = $data['type_industrie'] ?? 'gÃ©nÃ©ral';

        $prompt = "En tant qu'expert en analyse environnementale et bÃ¢timent, prÃ©dis les Ã©missions de CO2 annuelles, le pourcentage d'Ã©nergie renouvelable et les Ã©missions rÃ©elles pour le bÃ¢timent suivant :\n\n";

        $prompt .= "Type de bÃ¢timent: {$typeBatiment}\n";
        if ($typeIndustrie !== 'gÃ©nÃ©ral') {
            $prompt .= "Type d'industrie: {$typeIndustrie}\n";
        }

        // Ajouter les donnÃ©es d'Ã©mission si disponibles
        if (!empty($data['emission_data'])) {
            $prompt .= "DonnÃ©es d'Ã©mission fournies: " . json_encode($data['emission_data']) . "\n";
        }

        // Ajouter les donnÃ©es d'Ã©nergies renouvelables
        if (!empty($data['energies_renouvelables_data'])) {
            $prompt .= "Ã‰nergies renouvelables installÃ©es: " . json_encode($data['energies_renouvelables_data']) . "\n";
        }

        // Ajouter les donnÃ©es de recyclage
        if (!empty($data['recyclage_data'])) {
            $prompt .= "DonnÃ©es de recyclage: " . json_encode($data['recyclage_data']) . "\n";
        }

        $prompt .= "\nFournis ta rÃ©ponse au format JSON avec exactement ces clÃ©s :\n";
        $prompt .= "{\n";
        $prompt .= "  \"emission_c_o2\": <valeur numÃ©rique en tonnes par an>,\n";
        $prompt .= "  \"pourcentage_renouvelable\": <valeur entre 0 et 100>,\n";
        $prompt .= "  \"emission_reelle\": <valeur numÃ©rique calculÃ©e>\n";
        $prompt .= "}\n\n";
        $prompt .= "Sois prÃ©cis et rÃ©aliste dans tes estimations basÃ©es sur des donnÃ©es environnementales standard.";

        return $prompt;
    }

    /**
     * Appeler l'API OpenAI
     */
    private static function callOpenAI(string $url, string $apiKey, string $prompt): array
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 300,
                'temperature' => 0.3,
            ],
            'timeout' => 30,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Parser la rÃ©ponse de l'IA
     */
    private static function parseAIResponse(array $response): array
    {
        if (!isset($response['choices'][0]['message']['content'])) {
            throw new \Exception('RÃ©ponse IA invalide');
        }

        $content = $response['choices'][0]['message']['content'];

        // Essayer de parser le JSON de la rÃ©ponse
        $predictions = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si ce n'est pas du JSON valide, essayer d'extraire les valeurs avec regex
            $predictions = self::extractValuesFromText($content);
        }

        // Valider et nettoyer les valeurs
        return self::validatePredictions($predictions);
    }

    /**
     * Extraire les recommandations du texte si le JSON Ã©choue
     */
    private function extractRecommendationsFromText(string $text): array
    {
        $recommendations = [];

        // Essayer d'extraire les diffÃ©rentes sections
        $patterns = [
            'recommandations_principales' => '/"recommandations_principales"\s*:\s*\[([^\]]*)\]/',
            'actions_courte_terme' => '/"actions_courte_terme"\s*:\s*\[([^\]]*)\]/',
            'actions_long_terme' => '/"actions_long_terme"\s*:\s*\[([^\]]*)\]/',
        ];

        foreach ($patterns as $key => $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                // Extraire les Ã©lÃ©ments du tableau
                $content = $matches[1];
                $items = [];
                if (preg_match_all('/"([^"]+)"/', $content, $itemMatches)) {
                    $items = $itemMatches[1];
                }
                $recommendations[$key] = $items;
            }
        }

        // Extraire les champs simples
        $simplePatterns = [
            'impact_estime' => '/"impact_estime"\s*:\s*"([^"]+)"/',
            'cout_estime' => '/"cout_estime"\s*:\s*"([^"]+)"/',
            'duree_implementation' => '/"duree_implementation"\s*:\s*"([^"]+)"/',
        ];

        foreach ($simplePatterns as $key => $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $recommendations[$key] = $matches[1];
            }
        }

        return $recommendations;
    }

    /**
     * Valider et nettoyer les prÃ©dictions
     */
    private static function validatePredictions(array $predictions): array
    {
        $defaults = self::getDefaultPredictions([]);

        return [
            'emission_c_o2' => isset($predictions['emission_c_o2']) && is_numeric($predictions['emission_c_o2'])
                ? max(0, (float) $predictions['emission_c_o2'])
                : $defaults['emission_c_o2'],

            'pourcentage_renouvelable' => isset($predictions['pourcentage_renouvelable']) && is_numeric($predictions['pourcentage_renouvelable'])
                ? max(0, min(100, (float) $predictions['pourcentage_renouvelable']))
                : $defaults['pourcentage_renouvelable'],

