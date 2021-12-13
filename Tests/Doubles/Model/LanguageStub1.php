<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Impl\LanguageImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class LanguageStub1 extends LanguageImpl
{
    public const LOCALE = 'en';

    protected $locale = self::LOCALE;

    protected $translationProgress = '100%';

    public function __construct()
    {
    }
}
