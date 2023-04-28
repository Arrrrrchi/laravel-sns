<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    public function attributes()
    {
        return[
            'title' => 'タイトル',
            'body' => '本文',
            'tags' => 'タグ',
        ];
    }

    /**
     * バリデーション成功後に自動的に呼ばれるメソッド
     *
     * json形式で受け取ったtagをコレクションに変換し、タグ数を5個以下に制限
     */
    public function passedValidation()
    {
        $maxTags = 5; 
        $tags = collect(json_decode($this->tags))
            ->unique()
            ->take($maxTags)
            ->values();
        $this->merge(['tags' => $tags]);
    }
}
