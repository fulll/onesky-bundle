<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use Symfony\Contracts\EventDispatcher\Event;

class TranslationUpdateEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.update';

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }
}
