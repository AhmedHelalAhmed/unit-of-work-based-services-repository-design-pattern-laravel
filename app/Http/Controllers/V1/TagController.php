<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Link;
use App\Models\Tag;
use App\Validators\TagValidator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;

class TagController extends Controller
{
    /**
     * Scenario 1
     * business required no tag created without links and
     * links maybe attached to a tag
     * @return TagResource
     */
    public function store()
    {
        $data = (new TagValidator)->validate(request()->all());
        $title = Arr::get($data, 'title');

        try {
            // Database exception happened so tag not created
            Tag::query()
                ->create([
                    'title' => $title,
                ]);

        } catch (QueryException $e) {
            dump('===== Error =====');
            dump($e->getMessage());
            dump('===== Error =====');
        }

        $tag = optional(Tag::query()
            ->where('title', $title)
            ->first());

        // Links will create with no tag linked to it
        collect(Arr::get($data, 'links'))
            ->each(function ($link) use ($tag) {
                Link::query()
                    ->create([
                        'title' => Arr::get($link, 'title'),
                        'url' => Arr::get($link, 'url'),
                        'tag_id' => $tag->id
                    ]);
            });


        return TagResource::make($tag->load('links'));
    }
}
