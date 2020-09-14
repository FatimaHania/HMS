<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\BaseRepository;

/**
 * Class CurrencyRepository
 * @package App\Repositories
 * @version September 14, 2020, 6:30 pm UTC
*/

class CurrencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'short_code',
        'description',
        'decimal_places',
        'exchange_rate',
        'is_default',
        'hospital_id',
        'branch_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Currency::class;
    }
}
