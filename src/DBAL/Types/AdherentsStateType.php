<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * @extends AbstractEnumType<string,string>
 */
final class AdherentsStateType extends AbstractEnumType
{
    public const STATE_CREATED = 'created';
    public const STATE_VALIDATED = 'validated';

    public const TYPES = [
        self::STATE_CREATED,
        self::STATE_VALIDATED,
    ];

    /**
     * @var array<string,string>
     */
    protected static array $choices = [
        self::STATE_CREATED => 'En attente',
        self::STATE_VALIDATED => 'Validé',
    ];
}