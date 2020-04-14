<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルール
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//         $rule = parent::rules();

        $status_rule = Rule::in(array_keys(Task::STATUS));

        return [
            'status' => 'required|' . $status_rule,
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::attributes()
     */
    public function attributes() {
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages() {
        $messages = parent::messages();

        $status_labels = array_map(function($items) {
            return $items['label'];
        }, Task::STATUS);

        $status_labels = implode(',', $status_labels);

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels . ' のいずれかを指定してください。',
        ];
    }
}
