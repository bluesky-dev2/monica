<?php

namespace App\Services\Contact\Tag;

use App\Models\Contact\Tag;
use App\Services\BaseService;

class UpdateTag extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id' => 'required|integer|exists:accounts,id',
            'tag_id' => 'required|integer',
            'name' => 'required|string',
        ];
    }

    /**
     * Update a tag.
     *
     * @param array $data
     * @return Tag
     */
    public function execute(array $data) : Tag
    {
        $this->validate($data);

        $tag = Tag::where('account_id', $data['account_id'])
                            ->findOrFail($data['tag_id']);

        $tag->name = $data['name'];
        $tag->name_slug = str_slug($data['name']);
        $tag->save();

        return $tag;
    }
}
