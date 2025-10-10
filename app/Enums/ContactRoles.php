<?php

namespace App\Enums;

enum ContactRoles:string
{
    case Evaluators = 'evaluator';
    case Evaluated = 'evaluated';
}
