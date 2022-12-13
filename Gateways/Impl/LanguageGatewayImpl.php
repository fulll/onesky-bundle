<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl;

use Onesky\Api\Client;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageException;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\LanguageNotFoundException;
use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;
use OpenClassrooms\Bundle\OneSkyBundle\Model\LanguageFactory;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class LanguageGatewayImpl implements LanguageGateway
{
    private Client $client;
    private LanguageFactory $languageFactory;
    private int $projectId;

    public function findLanguages(array $locales): array
    {
        $jsonResponse = $this->client->projects(self::LANGUAGES_METHOD, ['project_id' => $this->projectId]);
        $response = json_decode($jsonResponse, true, 512, \JSON_THROW_ON_ERROR);

        $this->checkResponse($response, $jsonResponse);

        $languages = $this->createLanguages($response);
        $requestedLanguages = [];
        foreach ($locales as $locale) {
            if (isset($languages[$locale])) {
                $requestedLanguages[] = $languages[$locale];
            } else {
                throw new LanguageNotFoundException($locale);
            }
        }

        return $requestedLanguages;
    }

    private function checkResponse($response, $jsonResponse): void
    {
        if (200 !== $response['meta']['status']) {
            throw new LanguageException($jsonResponse);
        }
    }

    /**
     * @return Language[]
     */
    private function createLanguages($response)
    {
        $languages = $this->languageFactory->createFromCollection($response['data']);

        return $this->formatLanguages($languages);
    }

    /**
     * @param Language[] $languages
     *
     * @return Language[]
     */
    private function formatLanguages(array $languages): array
    {
        $languageLocales = [];
        foreach ($languages as $language) {
            $languageLocales[$language->getLocale()] = $language;
        }

        return $languageLocales;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function setLanguageFactory(LanguageFactory $languageFactory): void
    {
        $this->languageFactory = $languageFactory;
    }

    public function setProjectId($projectId): void
    {
        $this->projectId = $projectId;
    }
}
