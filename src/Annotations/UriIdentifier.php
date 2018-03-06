<?php

namespace MNC\Bundle\RestBundle\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class UriIdentifier
{
    /**
     * @var string
     * @Required()
     */
    public $name;
}