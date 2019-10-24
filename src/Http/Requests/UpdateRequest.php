<?php

namespace FaithGen\News\Http\Requests\News;

use FaithGen\News\Models\News;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $news = News::findOrFail(request()->news_id);
        return $this->user()->can('news.update', $news);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|between:3,255',
            'news' => 'required|string',
        ];
    }
}
