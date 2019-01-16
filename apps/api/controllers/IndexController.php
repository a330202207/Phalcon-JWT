<?php
/**
 * @purpose: 默认控制器
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */

namespace Apps\Api\Controllers;

use core\library\Jwt\Token;
use core\common\ErrorCode;

class IndexController extends ApiBaseController
{

    public function indexAction()
    {
        $this->view->pick('index/index');
    }

    public function loginAction()
    {
//        var_dump($this->claims);die;
//        $data = $this->request->getPost();
        $data = [
            'user_name' => $this->claims['user_name'],
            'pass_word' => $this->claims['pass_word'],
        ];
        return $this->jsonApi->return(ErrorCode::SUCCESS, 'Success!', $data);

    }

    public function getTokenAction()
    {
        $data = [
            'user_name' => $this->request->getPost('user_name'),
            'pass_word' => $this->request->getPost('pass_word'),
        ];

        $key = $this->request->getPost('key');
        $iss = $this->request->getPost('iss');
        $aud = $this->request->getPost('aud');
        $jti = $this->request->getPost('jti');

        $token = Token::builderToken($data, $key, $iss, $aud, $jti);
        $token->getHeaders();
        $token->getClaims();

        $res['token'] = (string)$token;
        return $this->jsonApi->return(ErrorCode::SUCCESS, 'Success!', $res);
    }


    /**
     * 404页面
     */
    public function notfoundAction()
    {
        return $this->response->setHeader('status', '404 Not Found');
    }

}

