<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * This class acts as a query scope class for filtering
 * Class ThreadFilters
 * @package App\Filters
 */
class ThreadFilters {

    /**
     * ThreadFilters constructor.
     * @param Request $request  laravel will inject it
     */
    public function __construct(protected Request $request)
    {
    }


    /**
     * local query scope method, return same query applied with 'by' filter
     * query scope classes has to have an apply method
     *
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        if( !$username = $this->request->by) return $builder;

        $user = User::where('name', $username)->firstOrFail();
        return $builder->where('user_id', $user->id);
    }
}
