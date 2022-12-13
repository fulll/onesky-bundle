<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;
use OpenClassrooms\Bundle\OneSkyBundle\Services\LanguageService;

class LanguageServiceMock implements LanguageService
{
    public static bool $calledGetLanguages;
    public static array $languages;
    public static array $locales;

    public function __construct()
    {
        self::$calledGetLanguages = false;
        self::$languages = [];
        self::$locales = [];
    }

    public function getLanguages(array $locales = []): array
    {
        self::$calledGetLanguages = true;
        self::$locales = $locales;

        return self::$languages;
    }
}
