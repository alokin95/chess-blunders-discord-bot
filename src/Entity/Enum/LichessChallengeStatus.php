<?php

namespace App\Entity\Enum;

enum LichessChallengeStatus: string
{
    case Pending = 'Pending';
    case Accepted = 'Accepted';
    case Rejected = 'Rejected';
    case Finished = 'Finished';
}