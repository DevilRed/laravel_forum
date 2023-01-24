<?php

namespace App\Filters;
use Illuminate\Http\Request;


abstract class Filters
{
    protected $builder;
    protected $filters = [];

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
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {// each filter has the form ['by' =>'Johndoe']
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }


    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
