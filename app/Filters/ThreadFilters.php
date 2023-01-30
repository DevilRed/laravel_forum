<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * This class acts as a query scope class for filtering query by a given username
 * Class ThreadFilters
 * @package App\Filters
 */
class ThreadFilters extends Filters {
    // override value from parent filters
    // to run them they need to match method name
    protected $filters = ['by', 'popular'];

    /**
     * @param mixed $username
     * @param $builder
     * @return mixed
     */
    public function by(string $username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter query according to most popular threads by replies count
     * @return $this
     */
    protected function popular()
    {
        // reset order by made previously to query builder to apply orderBy
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
