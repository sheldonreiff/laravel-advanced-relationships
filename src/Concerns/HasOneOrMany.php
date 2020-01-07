<?php
namespace Reiff\AdvancedRelationships\Concerns;

trait HasOneOrMany
{
    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        if (static::$constraints) {
            $foreignKey = $this->getForeignKeyName();
            $parentKeyValue = $this->getParentKey();

            //If the foreign key is an array (multi-column relationship), adjust the query.
            if (is_array($this->foreignKey)) {
                foreach ($this->foreignKey as $index => $key) {
                    $this->query->where($key, '=', $parentKeyValue[$index]);
                    $this->query->whereNotNull($key);
                }
            } else {
                $fullKey = $this->getRelated()
                        ->getTable().'.'.$foreignKey;
                $this->query->where($fullKey, '=', $parentKeyValue);
                $this->query->whereNotNull($fullKey);
            }
        }
    }
}