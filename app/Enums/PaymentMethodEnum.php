<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class PaymentMethodEnum extends Enum
{
    public const CASH = 0;
    public const VNPAY = 1;
}