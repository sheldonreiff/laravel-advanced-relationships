<?php
namespace Reiff\AdvancedRelationships;

use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use \Awobaz\Compoships\Compoships;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Reiff\AdvancedRelationships\Relations\HasOne;
use Reiff\AdvancedRelationships\Relations\HasMany;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentJsonRelations\Relations\Postgres\HasOne as HasOnePostgres;
use Staudenmeir\EloquentJsonRelations\Relations\Postgres\HasMany as HasManyPostgres;
use Staudenmeir\EloquentJsonRelations\Relations\Postgres\BelongsTo as BelongsToPostgres;

trait HasAdvancedRelationships
{
    use HasJsonRelationships, Compoships {
        HasJsonRelationships::getAttribute as HasJsonRelationshipsGetAttribute;
        Compoships::getAttribute as ComposhipsGetAttribute;

        HasJsonRelationships::newHasOne as HasJsonRelationshipsNewHasOne;
        Compoships::newHasOne as ComposhipsNewHasOne;

        HasJsonRelationships::newHasMany as HasJsonRelationshipsNewHasMany;
        Compoships::newHasMany as ComposhipsNewHasMany;
    }

    /**
     * Get an a JSON column or default to parent method.
     *
     * @param string $key
     * @return mixed
     */
    protected function getJsonAttributeOrDefault($key)
    {
        //check for JSON column
        $attribute = preg_split('/(->|\[\])/', $key)[0];
        if (array_key_exists($attribute, $this->attributes)) {
            return $this->getAttributeValue($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (is_array($key)) { //Check for multi-columns relationship
            return array_map(function ($k) {
                return $this->getJsonAttributeOrDefault($k);
            }, $key);
        }

        return $this->getJsonAttributeOrDefault($key);
    }

    /**
     * Instantiate a new HasOne relationship.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Model   $parent
     * @param string|array                          $foreignKey
     * @param string|array                          $localKey
     *
     * @return \Reiff\AdvancedRelationships\Relations\HasOne
     */
    protected function newHasOne(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        if ($query->getConnection()->getDriverName() === 'pgsql') {
            return new HasOnePostgres($query, $parent, $foreignKey, $localKey);
        }
        return new HasOne($query, $parent, $foreignKey, $localKey);
    }

    /**
     * Instantiate a new HasMany relationship.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Model   $parent
     * @param string|array                          $foreignKey
     * @param string|array                          $localKey
     *
     * 
     * @return \Reiff\AdvancedRelationships\Relations\HasMany
     */
    protected function newHasMany(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        if ($query->getConnection()->getDriverName() === 'pgsql') {
            return new HasManyPostgres($query, $parent, $foreignKey, $localKey);
        }
        return new HasMany($query, $parent, $foreignKey, $localKey);
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @param string            $related
     * @param string|array|null $foreignKey
     * @param string|array|null $ownerKey
     * @param string            $relation
     *
     * @return \Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo
     */
    protected function newBelongsTo(Builder $query, Model $child, $foreignKey, $ownerKey, $relation)
    {
        if ($query->getConnection()->getDriverName() === 'pgsql') {
            return new BelongsToPostgres($query, $child, $foreignKey, $ownerKey, $relation);
        }
        return new BelongsTo($query, $child, $foreignKey, $ownerKey, $relation);
    }
}