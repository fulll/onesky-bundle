<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationUpdateEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.update';

    /**
     * @return string
     */
    public static function getEventName()
    {
        return self::EVENT_NAME;
    }
}
