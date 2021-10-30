<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Services\CreatingTagService;
use App\Validators\TagValidator;


class TagController extends Controller
{
    /**
     * Scenario 1
     * business required no tag created without links and
     * links maybe attached to a tag
     * @return TagResource
     */
    public function store(CreatingTagService $creatingTagService)
    {
        $data = (new TagValidator)->validate(request()->all());


        $tag = $creatingTagService->execute($data);

        return TagResource::make($tag->load('links'));
    }
}
