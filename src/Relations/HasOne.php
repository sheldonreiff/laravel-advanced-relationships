<?php

namespace Reiff\AdvancedRelationships\Relations;

use Awobaz\Compoships\Database\Eloquent\Relations\HasOne as ComposhipsHasOne;
use Reiff\AdvancedRelationships\Concerns\HasOneOrMany;

class HasOne extends ComposhipsHasOne
{
    use HasOneOrMany;
}
