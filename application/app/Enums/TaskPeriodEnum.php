<?php

namespace App\Enums;

enum TaskPeriodEnum : string
{
    case DAILY = 'daily';
    case HOURLY = 'hourly';
}