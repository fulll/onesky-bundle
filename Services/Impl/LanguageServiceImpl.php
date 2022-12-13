<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;
use OpenClassrooms\Bundle\OneSkyBundle\Services\LanguageService;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class LanguageServiceImpl implements LanguageService
{
    /**
     * @var LanguageGateway
     */
    private LanguageGateway $languageGateway;

    /**
     * @var string[]
     */
    private array $requestedLocales;

    /**
     * @return Language[]
     */
    public function getLanguages(array $locales = []): array
    {
        if (empty($locales)) {
            $locales = $this->requestedLocales;
        }

        return $this->languageGateway->findLanguages($locales);
    }

    public function setLanguageGateway(LanguageGateway $languageGateway): void
    {
        $this->languageGateway = $languageGateway;
    }

    public function setRequestedLocales(array $requestedLocales): void
    {
        $this->requestedLocales = $requestedLocales;
    }
}
