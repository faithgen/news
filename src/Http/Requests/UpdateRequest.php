<?php

namespace FaithGen\News\Http\Requests;

use FaithGen\News\Services\NewsService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(NewsService $newsService)
    {
        return $this->user()->can('news.update', $newsService->getNews());
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

    function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this article');
    }
}
