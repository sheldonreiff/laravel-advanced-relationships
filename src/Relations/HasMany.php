<?php

namespace Reiff\AdvancedRelationships\Relations;

use Awobaz\Compoships\Database\Eloquent\Relations\HasMany as ComposhipsHasMany;
use Reiff\AdvancedRelationships\Concerns\HasOneOrMany;

class HasMany extends ComposhipsHasMany
{
    use HasOneOrMany;
}
