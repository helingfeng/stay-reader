<?php
/**
 * User: helingfeng
 */

namespace App\Http\Controllers;


class AuthController
{
    // https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code

    protected $code2sessionApi = 'https://api.weixin.qq.com/sns/jscode2session';

    public function code2session()
    {
        $param['js_code'] = request()->input('code', '');
        $param['appid'] = config('app.mini_program_app_id');
        $param['secret'] = config('app.mini_program_secret');
        $param['grant_type'] = 'authorization_code';

        $response = curl_get($this->code2sessionApi . '?' . http_build_query($param));
        return response()->json(json_decode($response['content'], true));
    }


}