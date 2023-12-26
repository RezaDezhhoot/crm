<?php

namespace App\Enums;

enum TaskOwnerEnum : string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case TEAM = 'team';
    case MANAGER = 'manager';
}
