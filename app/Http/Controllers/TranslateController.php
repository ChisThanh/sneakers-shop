<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateController extends Controller
{
    use ResponseTrait;
    public function translate(Request $request)
    {
        $result = GoogleTranslate::trans($request->text, $request->language);
        return $this->successResponse($result, 'Thành công');
    }
}
