<?php

namespace Laralabs\GetAddress\Models;

use Illuminate\Database\Eloquent\Model;

class CachedAddress extends Model
{
    /** @var string */
    protected $table = 'getaddress_cache';

    /** @var array */
    protected $fillable = [
        'line_1',
        'line_2',
        'line_3',
        'line_4',
        'locality',
        'town_or_city',
        'county',
        'postcode',
        'thoroughfare',
        'building_name',
        'sub_building_name',
        'sub_building_number',
        'building_number',
        'district',
        'country',
        'latitude',
        'longitude',
        'expanded_result',
    ];

    public static array $expandedFields = [
        'thoroughfare',
        'building_name',
        'sub_building_name',
        'sub_building_number',
        'building_number',
        'line_1',
        'line_2',
        'line_3',
        'line_4',
        'locality',
        'town_or_city',
        'county',
        'district',
        'country',
    ];

    public static array $fields = [
        'line_1',
        'line_2',
        'line_3',
        'line_4',
        'locality',
        'town_or_city',
        'county',
    ];

    public function getFormattedStringAttribute(): string
    {
        return $this->toString(true);
    }

    /**
     * Returns a string based on the address.
     *
     * @param bool $removeEmptyElements Prevents strings having conjoining commas
     */
    public function toString(bool $removeEmptyElements = false): string
    {
        if (!$removeEmptyElements) {
            return implode(',', $this->only(self::$fields));
        }

        return implode(', ', array_filter($this->only(self::$fields)));
    }
}
