<?php

namespace FaithGen\News\Http\Requests;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\News\Services\NewsService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class GetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(NewsService $newsService)
    {
        return $this->user()->can('view', $newsService->getNews());
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

    function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this article');
    }
}
