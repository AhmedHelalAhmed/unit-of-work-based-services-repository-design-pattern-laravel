<?php

namespace App\Validators;


class TagValidator
{
    public function validate(array $attributes): array
    {
        return validator($attributes, [
            'title' => ['required', 'string', 'unique:tags,title'],
            'links' => ['array'],
            'links.*.title' => ['required', 'string', 'distinct'],
            'links.*.url' => ['required', 'url'],
        ])->validate();
    }
}
