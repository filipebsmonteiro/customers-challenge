<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

class AddressRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    public function create(array $attributes): Address
    {
        return $this->model->create($attributes);
    }
}
