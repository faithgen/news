<?php

namespace FaithGen\News\Http\Requests\News;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\News\Models\News;
use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
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
            'image' => 'required|base64image',
            'news_id' => Helper::$idValidation
        ];
    }
}
