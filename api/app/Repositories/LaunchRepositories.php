<?php

namespace App\Repositories;

use App\Dto\UsersDto;
use App\Exception\ParametersException;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\Config\Annotation\Value;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Repositories\LaunchRepositories
 */
class LaunchRepositories
{

    #[Inject]
    protected UsersDto $usersDto;

    #[Inject]
    protected Factory $applicationFactory;

    #[Value("wechat")]
    protected array $wechatConfigure;


    /**
     * @param string $code
     * @return array
     * @throws InvalidConfigException|ParametersException
     */
    public function getAuth2Session(string $code)
    {
        // 获取 sessionProfile
        $sessionProfile = ($this->applicationFactory)::miniProgram($this->wechatConfigure)->auth->session($code);

        if (is_array($sessionProfile) && array_key_exists("session_key", $sessionProfile)) {

            $userProfile = [];

            $users = $this->usersDto->createOrFindUserByOpenID($sessionProfile["openid"], []);

            if ($users->getAttribute("userName") && $users->getAttribute("userAvatar")) {

                $userProfile["userName"] = $users->getAttribute("userName");
                $userProfile["userAvatar"] = $users->getAttribute("userAvatar");
            }

            return [
                "token" => $users->getAttribute("openID"),
                "users" => $userProfile,
            ];
        }

        throw new ParametersException();
    }

}