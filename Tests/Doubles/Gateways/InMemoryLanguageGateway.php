<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Gateways;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageNotFoundException;
use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class InMemoryLanguageGateway implements LanguageGateway
{
    /**
     * @var Language[]
     */
    public static $languages;

    public function __construct(array $languages = [])
    {
        self::$languages = $languages;
    }

    /**
     * {@inheritdoc}
     */
    public function findLanguages(array $locales = [])
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
