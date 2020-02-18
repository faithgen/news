<?php

namespace FaithGen\News\Http\Requests;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\News\Services\NewsService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(NewsService $newsService)
    {
        return $newsService->getNews()
            && $this->user()->can('update', $newsService->getNews());
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

    function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this article');
    }
}
