<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoard extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'bo_subject'	=> 'required'
        ];
    }

    // 에러 메세지
    public function messages() {
        return [
        'bo_subject.required' => '글 제목을 입력해 주세요.'
        ];
    }
}
