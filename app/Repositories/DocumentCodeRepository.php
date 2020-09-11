<?php

namespace App\Repositories;

use App\Models\DocumentCode;
use App\Repositories\BaseRepository;

/**
 * Class DocumentCodeRepository
 * @package App\Repositories
 * @version August 27, 2020, 4:57 pm UTC
*/

class DocumentCodeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'documentcode_id',
        'short_code',
        'description',
        'prefix',
        'starting_no',
        'format_length',
        'common_difference',
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
        return DocumentCode::class;
    }
}
