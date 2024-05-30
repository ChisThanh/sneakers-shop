<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class PaymentStatusEnum extends Enum
{
    public const UNPAID = 0;
    public const PAID = 1;
}