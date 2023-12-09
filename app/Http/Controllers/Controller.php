<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $domain = 'http://jwgl.bzmc.edu.cn';

    public function login(Request $request)
    {
        $username = $request->input('uid');
        $password = $request->input('pwd');
        $login = shell_exec("/usr/bin/python3 ../login.py {$username} {$password}");
        return $login;
    }

    public function course(Request $request)
    {
        $username = $request->input('uid');
        $password = $request->input('pwd');
        $cookie = shell_exec("/usr/bin/python3 ../login.py {$username} {$password}");
        $cookie = json_decode($cookie, true);
        $cookie = "JSESSIONID={$cookie['JSESSIONID']}; route={$cookie['route']}";


        $url = $this->domain . '/jwglxt/kbcx/xskbcx_cxXsgrkb.html?gnmkdm=N2151&su=';
        $postData = 'xnm=2023&xqm=3&kzlx=ck&xsdm=';
        $result = $this->httpPost($url, $postData, $cookie);
        return $result;
    }

    public function httpPost($url, $postData = '', $cookie = '')
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => array(
                'Accept: */*',
                'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
                'Cache-Control: no-cache',
                'Connection: keep-alive',
                'Origin: http://jwgl.bzmc.edu.cn',
                'Pragma: no-cache',
//                'Referer: http://jwgl.bzmc.edu.cn/jwglxt/kbcx/xskbcx_cxXskbcxIndex.html?gnmkdm=N2151&layout=default',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36 Edg/119.0.0.0',
                'X-Requested-With: XMLHttpRequest',
                'Cookie: ' . $cookie,
                'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    public function httpGet($url, $cookie, $method = "GET", $postData = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
                'Cache-Control: no-cache',
                'Connection: keep-alive',
                'Pragma: no-cache',
                'Upgrade-Insecure-Requests: 1',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36 Edg/119.0.0.0',
                'Cookie: ' . $cookie
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}
