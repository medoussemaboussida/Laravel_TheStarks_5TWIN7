<?php

namespace App\Helpers;

class BadWordsHelper
{
    /**
     * Liste des mots interdits (bad words)
     */
    private static $badWords = [
        'merde', 'putain', 'connard', 'salope', 'enculé', 'bordel', 'cul', 'bite', 'chatte', 'con', 'pute', 'salopard', 'foutre', 'emmerder', 'chier', 'pisser', 'couilles', 'branler', 'sucer', 'baiser', 'foutre', 'emmerde', 'chiasse', 'pisse', 'couille', 'branle', 'suce', 'baise', 'fout', 'emmerd', 'chi', 'piss', 'couill', 'branl', 'suc', 'bais', 'fuck', 'shit', 'asshole', 'bitch', 'cunt', 'dick', 'pussy', 'bastard', 'damn', 'hell', 'crap', 'piss', 'suck', 'fuck', 'shit', 'ass', 'bitch', 'cunt', 'dick', 'pussy', 'bastard', 'damn', 'hell', 'crap', 'piss', 'suck'
    ];

    /**
     * Vérifie si le texte contient des mots interdits
     *
     * @param string $text
     * @return bool
     */
    public static function containsBadWords($text)
    {
        $text = strtolower($text);
        foreach (self::$badWords as $badWord) {
            if (strpos($text, $badWord) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Obtient la liste des mots interdits trouvés dans le texte
     *
     * @param string $text
     * @return array
     */
    public static function getBadWordsInText($text)
    {
        $text = strtolower($text);
        $found = [];
        foreach (self::$badWords as $badWord) {
            if (strpos($text, $badWord) !== false) {
                $found[] = $badWord;
            }
        }
        return array_unique($found);
    }
}
