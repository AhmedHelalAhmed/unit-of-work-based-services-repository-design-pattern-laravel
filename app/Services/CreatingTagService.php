<?php

namespace App\Services;

use App\DataAccessLayer\Repositories\TagRepository;
use App\DataAccessLayer\UnitOfWork;
use App\Models\Link;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CreatingTagService extends UnitOfWork
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function execute(array $data): Model
    {
        $this->begin();

        $title = Arr::get($data, 'title');

        $tag = $this->tagRepository->newQuery()
            ->create(
                [
                    'title' => $title,
                ]
            );


        collect(Arr::get($data, 'links'))
            ->each(function ($link) use ($tag) {
                Link::query()
                    ->create([
                        'title' => Arr::get($link, 'title'),
                        'url' => Arr::get($link, 'url'),
                        'tag_id' => $tag->id
                    ]);
            });

        $this->commit();

        return $tag;
    }
}
