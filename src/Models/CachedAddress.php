<?php

namespace Laralabs\GetAddress\Models;

use Illuminate\Database\Eloquent\Model;

class CachedAddress extends Model
{
    /**
     * @var string
     */
    protected $table = 'getaddress_cache';

    /**
     * @var array
     */
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
        'expanded_result'
    ];

    /**
     * @var array
     */
    public static $expandedFields = [
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

    /**
     * @var array
     */
    public static $fields = [
        'line_1',
        'line_2',
        'line_3',
        'line_4',
        'locality',
        'town_or_city',
        'county',
    ];

    /**
     * @return string
     */
    public function getFormattedStringAttribute(): string
    {
        return $this->toString(true);
    }

    /**
     * Returns a string based on the address
     *
     * @param boolean $removeEmptyElements Prevents strings having conjoining commas
     *
     * @return string
     */
    public function toString($removeEmptyElements = false): string
    {
        if (!$removeEmptyElements) {
            return implode(',', $this->only(self::$fields));
        }

        return implode(', ', array_filter($this->only(self::$fields)));
    }
}
