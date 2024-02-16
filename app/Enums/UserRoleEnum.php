<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class UserRoleEnum extends Enum
{
    public const ADMIN = 0;
    public const CUSTOMER = 1;
}
