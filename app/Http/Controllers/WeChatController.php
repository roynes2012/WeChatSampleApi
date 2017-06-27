<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class WeChatController extends BaseController
{
    protected $wechat_app;
    protected $server;
    protected $user;

    public function __construct()
    {
        $config = array(
            'app_id' => env('WECHAT_APP_ID', 'wx5cb1eb81f8432e7d'),
            'secret' => env('WECHAT_APP_SECRET', '777f02638e0bda0041a69b8966afa97a'),
            'token' => env('WECHAT_TOKEN', 'wechat_kungfuenglish')
        );

        $this->wechat_app = new Application($config);
        $this->server = $this->wechat_app->server;
        $this->user = $this->wechat_app->user;
    }

    public function index()
    {
        return $this->user->lists();
    }

    public function show($openIds)
    {
        $array_ids = explode(',', $openIds);

        return $this->user->batchGet($array_ids);
    }

    public function sendMessage()
    {
        $user = $this->user;

        $this->server->setMessageHandler(function ($message) use ($user)
        {
            return 'Hello this is an automated message';
        });

        $server = $this->server->serve()->send();

        return $server;
    }
}
