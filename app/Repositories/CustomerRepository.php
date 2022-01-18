<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function create(array $attributes): Customer
    {
        return $this->model->create($attributes);
    }
}
