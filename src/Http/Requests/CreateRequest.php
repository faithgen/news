<?php

namespace FaithGen\News\Http\Requests;

use FaithGen\News\Models\News;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', News::class);
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
            'image' => 'required|base64image'
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('You need to upgrade subscription to be able to send more than 2 news articles');
    }
}
