<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface LanguageGateway
{
    public const LANGUAGES_METHOD = 'languages';

    /**
     * @return \OpenClassrooms\Bundle\OneSkyBundle\Model\Language[]
     *
     * @throws LanguageException
     */
    public function findLanguages(array $locales);
}
