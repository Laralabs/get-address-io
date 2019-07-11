<?php

namespace Laralabs\GetAddress\Responses;

class Usage
{
    /**
     * Number of requests made within the time period.
     *
     * @var int
     */
    protected $count = 0;

    /**
     * Limits imposed on your account of number of lookups allowed.
     *
     * @var array
     */
    protected $limits = [0, 0];

    /**
     * Constructor.
     *
     * @param int $count
     * @param int $limit1
     * @param int $limit2
     *
     * @return void
     */
    public function __construct($count, $limit1, $limit2)
    {
        $this->count = (int) $count;
        $this->limits = [
            (int) $limit1,
            (int) $limit2,
        ];
    }

    /**
     * Get Count.
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * Get Limit 1.
     *
     * @return int
     */
    public function getLimit1(): int
    {
        return $this->limits[0];
    }

    /**
     * Get Limit 2.
     *
     * @return int
     */
    public function getLimit2(): int
    {
        return $this->limits[1];
    }

    /**
     * Get Limit.
     *
     * @param int $limitNumber
     *
     * @return int
     */
    public function getLimit($limitNumber): int
    {
        return $this->limits[$limitNumber - 1];
    }

    /**
     * Get Limits.
     *
     * @return array
     */
    public function getLimits(): array
    {
        return $this->limits;
    }

    /**
     * Requests Remaining.
     *
     * @param bool $untilSlowed Will return requests remaining until calls are slowed by getAddress
     *
     * @return int
     */
    public function requestsRemaining($untilSlowed = false): int
    {
        $limit = $untilSlowed ? $this->limits[0] : $this->limits[1];

        return $limit - $this->count;
    }

    /**
     * Requests Remaining Until Slowed.
     *
     * @return int
     */
    public function requestsRemainingUntilSlowed(): int
    {
        return $this->requestsRemaining(true);
    }

    /**
     * Has Exceeded Limit.
     *
     * @return bool
     */
    public function hasExceededLimit(): bool
    {
        return $this->count > $this->limits[1];
    }

    /**
     * Returns whether the initial limit has been reached and whether subsequent
     * requests have been slowed down by getAddress.
     *
     * @return bool
     */
    public function isRestricted(): bool
    {
        return $this->count >= $this->limits[0];
    }
}
