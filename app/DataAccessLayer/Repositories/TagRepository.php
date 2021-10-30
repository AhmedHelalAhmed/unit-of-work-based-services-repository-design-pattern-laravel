<?php

namespace App\DataAccessLayer\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository
{
    public function __construct(Tag $model)
    {
        parent::__construct($model); // Inject the model that you need to build queries from
    }
}
