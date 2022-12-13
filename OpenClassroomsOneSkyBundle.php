<?php

namespace OpenClassrooms\Bundle\OneSkyBundle;

use OpenClassrooms\Bundle\OneSkyBundle\DependencyInjection\OpenClassroomsOneSkyExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsOneSkyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new OpenClassroomsOneSkyExtension();
    }
}
