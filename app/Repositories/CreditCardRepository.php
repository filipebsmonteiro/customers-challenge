<?php

namespace App\Repositories;

use App\Models\CreditCard ;
use Illuminate\Database\Eloquent\Model;

class CreditCardRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(CreditCard $creditCard)
    {
        $this->model = $creditCard;
    }

    public function create(array $attributes): CreditCard
    {
        return $this->model->create($attributes);
    }
}
