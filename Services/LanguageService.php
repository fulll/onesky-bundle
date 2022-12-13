<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;

interface LanguageService
{
    /**
     * @return Language[]
     */
    public function getLanguages(array $locales = []): array;
}
