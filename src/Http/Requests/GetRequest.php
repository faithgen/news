<?php

namespace FaithGen\News\Http\Requests\News;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\News\Models\News;
use Illuminate\Foundation\Http\FormRequest;

class GetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $news = News::findOrFail(request()->news_id);
        return $this->user()->can('news.view', $news);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'news_id' => Helper::$idValidation
        ];
    }
}
