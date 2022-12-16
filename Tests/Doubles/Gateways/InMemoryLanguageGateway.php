<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Gateways;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageNotFoundException;
use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;

class InMemoryLanguageGateway implements LanguageGateway
{
    /**
     * @var Language[]
     */
    public static array $languages;

    public function __construct(array $languages = [])
    {
        self::$languages = $languages;
    }

    public function findLanguages(array $locales = []): array
    {
        $languages = [];
        foreach ($locales as $locale) {
            if (!isset(self::$languages[$locale])) {
                throw new LanguageNotFoundException();
            }
            $languages[] = self::$languages[$locale];
        }

        return $languages;
    }
}
