<?php

namespace FaithGen\News\Http\Requests;

use FaithGen\News\Services\NewsService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param \FaithGen\News\Services\NewsService $newsService
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
            'title' => 'required|string|between:3,255',
            'news'  => 'required|string',
        ];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this article');
    }
}
