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

    // Mutateurs pour les anciens noms (compatibilité)
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

    // Accesseur pour les données de recyclage (toujours retourner un tableau)
    public function getRecyclageDataAttribute()
    {
    return $this->attributes['recyclage_data']
        ? json_decode($this->attributes['recyclage_data'], true)
        : [];
}

    // Mutateur pour s'assurer que les données de recyclage sont correctement formatées
    public function setRecyclageDataAttribute($value)
    {
        if (is_array($value)) {
            // S'assurer que quantites est toujours un tableau avec des valeurs numériques
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

    // Accesseur pour vérifier si le recyclage existe
    public function getRecyclageExisteAttribute()
    {
        $data = $this->recyclageData;
        return $data && isset($data['existe']) && $data['existe'];
    }

    // Accesseur pour vérifier si les énergies renouvelables existent
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
            // Si c'est déjà du JSON, on le garde tel quel
            $this->attributes['energies_renouvelables_data'] = $value;
        } else {
            $this->attributes['energies_renouvelables_data'] = null;
        }
    }

    // Accesseur pour s'assurer que energies_renouvelables_data retourne toujours un tableau normalisé
    public function getEnergiesRenouvelablesDataAttribute()
    {
        $value = $this->attributes['energies_renouvelables_data'] ?? null;

        if (is_null($value)) {
            return [];
        }

        if (is_array($value)) {
            return $this->normalizeEnergiesRenouvelablesData($value);
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $this->normalizeEnergiesRenouvelablesData($decoded);
            }
        }

        return [];
    }

    /**
     * Normalise les données d'énergies renouvelables vers le format attendu
     * Format attendu: {"type": {"check": boolean, "nb": number}}
     */
    private function normalizeEnergiesRenouvelablesData(array $data): array
    {
        $normalized = [];

        // Types d'énergies renouvelables supportés
        $energyTypes = [
            'panneaux_solaires',
            'voitures_electriques',
            'camions_electriques',
            'energie_eolienne',
            'energie_hydroelectrique'
        ];

        foreach ($energyTypes as $type) {
            if (isset($data[$type]) && is_array($data[$type])) {
                $energyData = $data[$type];

                // Si la structure a déjà check et nb, la garder telle quelle
                if (isset($energyData['check']) && isset($energyData['nb'])) {
                    $normalized[$type] = [
                        'check' => (bool) $energyData['check'],
                        'nb' => is_numeric($energyData['nb']) ? (float) $energyData['nb'] : 0
                    ];
                }
                // Si la structure a type et nb (ancien format), convertir
                elseif (isset($energyData['type']) && isset($energyData['nb'])) {
                    $normalized[$type] = [
                        'check' => true, // On considère que si c'est défini, c'est coché
                        'nb' => is_numeric($energyData['nb']) ? (float) $energyData['nb'] : 0
                    ];
                }
                // Si la structure a seulement nb, convertir
                elseif (isset($energyData['nb'])) {
                    $normalized[$type] = [
                        'check' => true, // On considère que si nb est défini, c'est coché
                        'nb' => is_numeric($energyData['nb']) ? (float) $energyData['nb'] : 0
                    ];
                }
            }
        }

        return $normalized;
    }

    // Accesseur pour s'assurer que emission_data retourne toujours un tableau normalisé
    public function getEmissionDataAttribute()
    {
        $value = $this->attributes['emission_data'] ?? null;

        if (is_null($value)) {
            return [];
        }

        if (is_array($value)) {
            return $this->normalizeEmissionData($value);
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $this->normalizeEmissionData($decoded);
            }
        }

        return [];
    }

    /**
     * Normalise les données d'émissions vers le format attendu
     * Format attendu: {"type": {"check": boolean, "nb": number}}
     */
    private function normalizeEmissionData(array $data): array
    {
        $normalized = [];

        // Types d'émissions supportés
        $emissionTypes = [
            'voiture',
            'moto',
            'bus',
            'avion',
            'fumeur',
            'electricite',
            'gaz',
            'camion'
        ];

        foreach ($emissionTypes as $type) {
            if (isset($data[$type]) && is_array($data[$type])) {
                $emissionData = $data[$type];

                // Si la structure a déjà check et nb, la garder telle quelle
                if (isset($emissionData['check']) && isset($emissionData['nb'])) {
                    $normalized[$type] = [
                        'check' => (bool) $emissionData['check'],
                        'nb' => is_numeric($emissionData['nb']) ? (float) $emissionData['nb'] : 0
                    ];
                }
                // Si la structure a type et nb (ancien format), convertir
                elseif (isset($emissionData['type']) && isset($emissionData['nb'])) {
                    $normalized[$type] = [
                        'check' => true, // On considère que si c'est défini, c'est coché
                        'nb' => is_numeric($emissionData['nb']) ? (float) $emissionData['nb'] : 0
                    ];
                }
                // Si la structure a seulement nb ou quantite, convertir
                elseif (isset($emissionData['nb']) || isset($emissionData['quantite'])) {
                    $nb = $emissionData['nb'] ?? $emissionData['quantite'] ?? 0;
                    $normalized[$type] = [
                        'check' => true, // On considère que si nb/quantite est défini, c'est coché
                        'nb' => is_numeric($nb) ? (float) $nb : 0
                    ];
                }
            }
        }

        return $normalized;
    }

    // Accesseur pour le type de zone urbaine formaté
    public function getTypeZoneUrbaineFormattedAttribute()
    {
        $types = [
            'zone_industrielle' => 'Zone Industrielle',
            'quartier_residentiel' => 'Quartier Résidentiel',
            'centre_ville' => 'Centre Ville'
        ];

        return $this->type_zone_urbaine ? ($types[$this->type_zone_urbaine] ?? $this->type_zone_urbaine) : null;
    }

    /**
     * Prédire les émissions CO2 et le pourcentage renouvelable en utilisant une API IA
     */
    public static function predictEmissionsWithAI(array $buildingData): array
    {
        // Essayer d'abord Google Gemini (gratuit)
        try {
            $apiKey = config('services.google.api_key', env('GOOGLE_API_KEY'));

            if ($apiKey && $apiKey !== 'YOUR_GOOGLE_API_KEY_HERE') {
                \Illuminate\Support\Facades\Log::info('Tentative de prédiction avec Google Gemini');
                return self::predictWithGoogleGemini($buildingData);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Échec Google Gemini pour prédiction, tentative avec OpenAI', [
                'error' => $e->getMessage()
            ]);
        }

        // Essayer ensuite OpenAI
        try {
            $apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));

            if ($apiKey) {
                \Illuminate\Support\Facades\Log::info('Tentative de prédiction avec OpenAI');
                return self::predictWithOpenAI($buildingData);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Échec OpenAI pour prédiction, utilisation du fallback', [
                'error' => $e->getMessage()
            ]);
        }

        // Fallback en dernier recours
        return self::getDefaultPredictions($buildingData);
    }

    /**
     * Construire le prompt pour l'IA
     */
    private static function buildAIPrompt(array $data): string
    {
        $typeBatiment = $data['type_batiment'] ?? 'inconnu';
        $typeIndustrie = $data['type_industrie'] ?? 'général';

        $prompt = "En tant qu'expert en analyse environnementale et bâtiment, prédis les émissions de CO2 annuelles, le pourcentage d'énergie renouvelable et les émissions réelles pour le bâtiment suivant :\n\n";

        $prompt .= "Type de bâtiment: {$typeBatiment}\n";
        if ($typeIndustrie !== 'général') {
            $prompt .= "Type d'industrie: {$typeIndustrie}\n";
        }

        // Ajouter les données d'émission si disponibles
        if (!empty($data['emission_data'])) {
            $prompt .= "Données d'émission fournies: " . json_encode($data['emission_data']) . "\n";
        }

        // Ajouter les données d'énergies renouvelables
        if (!empty($data['energies_renouvelables_data'])) {
            $prompt .= "Énergies renouvelables installées: " . json_encode($data['energies_renouvelables_data']) . "\n";
        }

        // Ajouter les données de recyclage
        if (!empty($data['recyclage_data'])) {
            $prompt .= "Données de recyclage: " . json_encode($data['recyclage_data']) . "\n";
        }

        $prompt .= "\nFournis ta réponse au format JSON avec exactement ces clés :\n";
        $prompt .= "{\n";
        $prompt .= "  \"emission_c_o2\": <valeur numérique en tonnes par an>,\n";
        $prompt .= "  \"pourcentage_renouvelable\": <valeur entre 0 et 100>,\n";
        $prompt .= "  \"emission_reelle\": <valeur numérique calculée>\n";
        $prompt .= "}\n\n";
        $prompt .= "Sois précis et réaliste dans tes estimations basées sur des données environnementales standard.";

        return $prompt;
    }

    /**
     * Prédire avec Google Gemini
     */
    private static function predictWithGoogleGemini(array $buildingData): array
    {
        $apiKey = config('services.google.api_key');
        $model = config('services.google.model', 'gemini-2.0-flash-exp');
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey;

        $prompt = self::buildAIPrompt($buildingData);

        $client = new \GuzzleHttp\Client();

        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ]
            ],
            'timeout' => 30,
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        return self::parseGoogleGeminiPredictionResponse($responseData);
    }

    /**
     * Prédire avec OpenAI
     */
    private static function predictWithOpenAI(array $buildingData): array
    {
        $apiKey = config('services.openai.api_key');
        $apiUrl = 'https://api.openai.com/v1/chat/completions';

        $prompt = self::buildAIPrompt($buildingData);

        $client = new \GuzzleHttp\Client();

        $response = $client->post($apiUrl, [
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
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ],
            'timeout' => 30,
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        return self::parseAIResponse($responseData);
    }

    /**
     * Parser la réponse de Google Gemini pour les prédictions
     */
    private static function parseGoogleGeminiPredictionResponse(array $responseData): array
    {
        if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('Réponse Google Gemini invalide pour les prédictions');
        }

        $content = $responseData['candidates'][0]['content']['parts'][0]['text'];

        // Essayer de parser le JSON de la réponse
        $predictions = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si ce n'est pas du JSON valide, essayer d'extraire les valeurs avec regex
            $predictions = self::extractValuesFromText($content);
        }

        // Valider et nettoyer les valeurs
        return self::validatePredictions($predictions);
    }

    /**
     * Générer des recommandations IA pour protéger la nature et UrbanGreen
     * Utilise Google Gemini en priorité, puis OpenAI, puis fallback
     */
    public function generateNatureProtectionRecommendations(): array
    {
        // Essayer d'abord Google Gemini (gratuit)
        try {
            $apiKey = config('services.google.api_key', env('GOOGLE_API_KEY'));

            if ($apiKey && $apiKey !== 'YOUR_GOOGLE_API_KEY_HERE') {
                \Illuminate\Support\Facades\Log::info('Tentative avec Google Gemini', ['batiment_id' => $this->id]);
                return $this->generateWithGoogleGemini();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Échec Google Gemini, tentative avec OpenAI', [
                'batiment_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }

        // Essayer ensuite OpenAI
        try {
            $apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));

            if ($apiKey) {
                \Illuminate\Support\Facades\Log::info('Tentative avec OpenAI', ['batiment_id' => $this->id]);
                return $this->generateWithOpenAI();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Échec OpenAI, utilisation du fallback', [
                'batiment_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }

        // Fallback en dernier recours
        return $this->getFallbackRecommendations();
    }

    /**
     * Générer des recommandations avec Google Gemini
     */
    private function generateWithGoogleGemini(): array
    {
        $apiKey = config('services.google.api_key');
        $model = config('services.google.model', 'gemini-2.0-flash-exp');
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey;

        $prompt = $this->buildNatureProtectionPrompt();

        $client = new \GuzzleHttp\Client();

        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ]
            ],
            'timeout' => 30,
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        return $this->parseGoogleGeminiResponse($responseData);
    }

    /**
     * Générer des recommandations avec OpenAI
     */
    private function generateWithOpenAI(): array
    {
        $apiKey = config('services.openai.api_key');
        $apiUrl = 'https://api.openai.com/v1/chat/completions';

        $prompt = $this->buildNatureProtectionPrompt();

        $client = new \GuzzleHttp\Client();

        $response = $client->post($apiUrl, [
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
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ],
            'timeout' => 30,
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        return $this->parseNatureRecommendationsResponse($responseData);
    }

    /**
     * Parser la réponse de Google Gemini
     */
    private function parseGoogleGeminiResponse(array $response): array
    {
        if (!isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('Réponse Google Gemini invalide');
        }

        $content = $response['candidates'][0]['content']['parts'][0]['text'];

        // Essayer de parser le JSON de la réponse
        $recommendations = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si ce n'est pas du JSON valide, essayer d'extraire avec regex
            $recommendations = $this->extractRecommendationsFromText($content);
        }

        // Valider et nettoyer les recommandations
        $validated = $this->validateNatureRecommendations($recommendations);
        $validated['source'] = 'google_gemini';

        return $validated;
    }

    /**
     * Parser la réponse des recommandations IA
     */
    private function parseNatureRecommendationsResponse(array $response): array
    {
        if (!isset($response['choices'][0]['message']['content'])) {
            throw new \Exception('Réponse IA invalide - contenu manquant');
        }

        $content = $response['choices'][0]['message']['content'];

        // Essayer de parser le JSON de la réponse
        $recommendations = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si ce n'est pas du JSON valide, essayer d'extraire les valeurs avec regex
            $recommendations = $this->extractRecommendationsFromText($content);
        }

        // Valider et nettoyer les recommandations
        $validated = $this->validateNatureRecommendations($recommendations);
        $validated['source'] = 'openai';

        return $validated;
    }

    /**
     * Extraire les recommandations du texte si le JSON échoue
     */
    private function extractRecommendationsFromText(string $text): array
    {
        $recommendations = [];

        // Essayer d'extraire les différentes sections
        $patterns = [
            'recommandations_principales' => '/"recommandations_principales"\s*:\s*\[([^\]]*)\]/',
            'actions_courte_terme' => '/"actions_courte_terme"\s*:\s*\[([^\]]*)\]/',
            'actions_long_terme' => '/"actions_long_terme"\s*:\s*\[([^\]]*)\]/',
        ];

        foreach ($patterns as $key => $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                // Extraire les éléments du tableau
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
     * Valider et nettoyer les recommandations
     */
    private function validateNatureRecommendations(array $recommendations): array
    {
        // Valeurs par défaut minimales en cas d'extraction incomplète
        $defaults = [
            'recommandations_principales' => ['Recommandations générées par IA'],
            'actions_courte_terme' => ['Actions à court terme générées par IA'],
            'actions_long_terme' => ['Actions à long terme générées par IA'],
            'impact_estime' => 'Impact estimé par l\'IA',
            'cout_estime' => 'Coût estimé par l\'IA en TND',
            'duree_implementation' => 'Durée estimée par l\'IA',
        ];

        return [
            'recommandations_principales' => isset($recommendations['recommandations_principales']) && is_array($recommendations['recommandations_principales']) && !empty($recommendations['recommandations_principales'])
                ? $recommendations['recommandations_principales']
                : $defaults['recommandations_principales'],

            'actions_courte_terme' => isset($recommendations['actions_courte_terme']) && is_array($recommendations['actions_courte_terme']) && !empty($recommendations['actions_courte_terme'])
                ? $recommendations['actions_courte_terme']
                : $defaults['actions_courte_terme'],

            'actions_long_terme' => isset($recommendations['actions_long_terme']) && is_array($recommendations['actions_long_terme']) && !empty($recommendations['actions_long_terme'])
                ? $recommendations['actions_long_terme']
                : $defaults['actions_long_terme'],

            'impact_estime' => $recommendations['impact_estime'] ?? $defaults['impact_estime'],
            'cout_estime' => $recommendations['cout_estime'] ?? $defaults['cout_estime'],
            'duree_implementation' => $recommendations['duree_implementation'] ?? $defaults['duree_implementation'],
        ];
    }

    /**
     * Construire le prompt pour les recommandations de protection de la nature
     */
    private function buildNatureProtectionPrompt(): string
    {
        $prompt = "En tant qu'expert en environnement urbain et développement durable, analyse ce bâtiment et fournis des recommandations concrètes pour protéger la nature et améliorer UrbanGreen :\n\n";

        $prompt .= "Informations du bâtiment :\n";
        $prompt .= "- Type : {$this->type_batiment}\n";
        $prompt .= "- Adresse : {$this->adresse}\n";
        $prompt .= "- Zone urbaine : {$this->type_zone_urbaine}\n";
        $prompt .= "- Émissions CO2 : {$this->emission_c_o2} tonnes/an\n";
        $prompt .= "- Pourcentage renouvelable : {$this->pourcentage_renouvelable}%\n";
        $prompt .= "- Émissions réelles : {$this->emission_reelle} tonnes/an\n";
        $prompt .= "- Nombre d'arbres nécessaires : {$this->nb_arbres_besoin}\n";

        if ($this->nb_habitants) {
            $prompt .= "- Nombre d'habitants : {$this->nb_habitants}\n";
        }

        if ($this->nb_employes) {
            $prompt .= "- Nombre d'employés : {$this->nb_employes}\n";
        }

        if ($this->type_industrie && $this->type_industrie !== 'général') {
            $prompt .= "- Type d'industrie : {$this->type_industrie}\n";
        }

        // Ajouter les données environnementales
        if (!empty($this->energies_renouvelables_data)) {
            $prompt .= "- Énergies renouvelables : " . json_encode($this->energies_renouvelables_data) . "\n";
        }

        if (!empty($this->recyclage_data)) {
            $prompt .= "- Recyclage : " . json_encode($this->recyclage_data) . "\n";
        }

        if (!empty($this->emission_data)) {
            $prompt .= "- Données d'émission : " . json_encode($this->emission_data) . "\n";
        }

        $prompt .= "\nFournis ta réponse au format JSON avec ces clés :\n";
        $prompt .= "{\n";
        $prompt .= "  \"recommandations_principales\": [\"recommandation 1\", \"recommandation 2\", ...],\n";
        $prompt .= "  \"actions_courte_terme\": [\"action 1\", \"action 2\", ...],\n";
        $prompt .= "  \"actions_long_terme\": [\"action 1\", \"action 2\", ...],\n";
        $prompt .= "  \"impact_estime\": \"description de l'impact environnemental\",\n";
        $prompt .= "  \"cout_estime\": \"estimation des coûts en dinar tunisien (TND)\",\n";
        $prompt .= "  \"duree_implementation\": \"temps nécessaire pour l'implémentation\"\n";
        $prompt .= "}\n\n";
        $prompt .= "Sois spécifique, réalisable et concentre-toi sur des solutions pratiques pour UrbanGreen. Fournis tous les coûts en dinar tunisien (TND).";

        return $prompt;
    }

    /**
     * Recommandations de fallback en cas d'échec des APIs IA
     */
    private function getFallbackRecommendations(): array
    {
        $typeBatiment = $this->type_batiment ?? 'Maison';

        $recommendationsBase = [
            'Maison' => [
                'recommandations_principales' => [
                    'Installer des panneaux solaires sur le toit',
                    'Créer un jardin potager écologique',
                    'Mettre en place un système de récupération d\'eau de pluie'
                ],
                'actions_courte_terme' => [
                    'Planter des arbres indigènes dans le jardin',
                    'Installer des ampoules LED économes en énergie',
                    'Trier les déchets et recycler'
                ],
                'actions_long_terme' => [
                    'Isoler thermiquement les murs et le toit',
                    'Installer une pompe à chaleur géothermique',
                    'Créer une toiture végétalisée'
                ],
                'impact_estime' => 'Réduction de 30-40% des émissions CO2 et amélioration de la biodiversité locale',
                'cout_estime' => '15,000 - 25,000 TND pour les améliorations de base',
                'duree_implementation' => '6-12 mois selon les travaux choisis'
            ],
            'Immeuble' => [
                'recommandations_principales' => [
                    'Mettre en place un système de chauffage collectif écologique',
                    'Créer des espaces verts partagés sur les toits-terrasses',
                    'Installer des panneaux solaires pour l\'éclairage commun'
                ],
                'actions_courte_terme' => [
                    'Organiser des campagnes de sensibilisation environnementale',
                    'Mettre en place des composteurs collectifs',
                    'Installer des récupérateurs d\'eau de pluie'
                ],
                'actions_long_terme' => [
                    'Rénover l\'isolation thermique de l\'ensemble du bâtiment',
                    'Installer un système de cogénération',
                    'Créer des jardins verticaux sur les façades'
                ],
                'impact_estime' => 'Réduction de 25-35% des émissions CO2 collectives',
                'cout_estime' => '50,000 - 150,000 TND selon la taille de l\'immeuble',
                'duree_implementation' => '12-24 mois pour les travaux majeurs'
            ],
            'Bureau' => [
                'recommandations_principales' => [
                    'Adopter une politique de télétravail partiel',
                    'Mettre en place un système de gestion énergétique intelligent',
                    'Créer des espaces de coworking écologiques'
                ],
                'actions_courte_terme' => [
                    'Sensibiliser les employés aux économies d\'énergie',
                    'Mettre en place le tri sélectif des déchets',
                    'Utiliser des matériaux recyclés pour les fournitures'
                ],
                'actions_long_terme' => [
                    'Installer des panneaux solaires sur le toit',
                    'Rénover avec des matériaux écologiques',
                    'Créer un parking pour vélos et véhicules électriques'
                ],
                'impact_estime' => 'Réduction de 20-30% de l\'empreinte carbone professionnelle',
                'cout_estime' => '30,000 - 80,000 TND pour les aménagements écologiques',
                'duree_implementation' => '8-18 mois selon l\'ampleur des changements'
            ],
            'Usine' => [
                'recommandations_principales' => [
                    'Optimiser les processus de production pour réduire les déchets',
                    'Installer des systèmes de récupération d\'énergie thermique',
                    'Mettre en place une chaîne d\'approvisionnement durable'
                ],
                'actions_courte_terme' => [
                    'Former le personnel aux pratiques écologiques',
                    'Mettre en place un système de mesure des émissions',
                    'Réduire les pertes énergétiques dans les processus'
                ],
                'actions_long_terme' => [
                    'Investir dans des technologies de production propres',
                    'Créer des bassins de rétention pour les eaux industrielles',
                    'Développer des produits à base de matériaux recyclés'
                ],
                'impact_estime' => 'Réduction significative des émissions industrielles et amélioration de l\'efficacité énergétique',
                'cout_estime' => '200,000 - 500,000 TND selon la taille et le secteur d\'activité',
                'duree_implementation' => '18-36 mois pour les transformations majeures'
            ]
        ];

        // Retourner les recommandations adaptées ou des recommandations générales
        return $recommendationsBase[$typeBatiment] ?? $recommendationsBase['Maison'];
    }
}