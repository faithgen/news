<?php

namespace FaithGen\News\Http\Requests;

use FaithGen\News\Services\NewsService;
use FaithGen\SDK\Helpers\Helper;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(NewsService $newsService)
    {
        return $newsService->getNews()
            && $this->user()->can('view', $newsService->getNews());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'news_id' => Helper::$idValidation,
            'comment' => 'required',
        ];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this article');
    }
}
