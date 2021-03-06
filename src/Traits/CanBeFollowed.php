<?php


namespace Liliom\Acquaintances\Traits;

use Liliom\Acquaintances\Interaction;


/**
 * Trait CanBeFollowed.
 */
trait CanBeFollowed
{
    /**
     * Check if user is followed by given user.
     *
     * @param int $user
     *
     * @return bool
     */
    public function isFollowedBy($user)
    {
        return Interaction::isRelationExists($this, 'followers', $user);
    }

    /**
     * Return followers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->morphToMany(config('auth.providers.users.model'), 'subject',
            config('acquaintances.tables.interactions'))
                    ->wherePivot('relation', '=', Interaction::RELATION_FOLLOW)
                    ->withPivot(...Interaction::$pivotColumns);
    }

    public function followersCount()
    {
        return $this->followers()->count();
    }

    public function getFollowersCountAttribute()
    {
        return $this->followersCount();
    }

    public function followersCountReadable($precision = 1, $divisors = null)
    {
        return Interaction::numberToReadable($this->followersCount(), $precision, $divisors);
    }
}
