<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;

interface LanguageGateway
{
    public const LANGUAGES_METHOD = 'languages';

    /**
     * @return Language[]
     * @throws LanguageException
     */
    public function findLanguages(array $locales);
}
