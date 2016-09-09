<?php

namespace App\Service;

use App\Model\Friend;
use App\Model\Title;
use App\Model\User;
use App\Service\Interfaces\FriendServiceInterface;
use Core\Lib\Singleton;

class FriendService extends Singleton implements FriendServiceInterface
{

    const FRIEND_TITLE_TYPE = 3;

    /**
     * @return FriendService
     */
    public static function getInstance()
    {
        return parent::getInstance(); // TODO: Change the autogenerated stub
    }

    protected function getIdListByUserId(int $userId) : array
    {

        $result = Friend::getInstance()->getIdListByUserId($userId);
        $result = strlen($result) ? explode(',', $result) : [];

        return $result;
    }

    public function getInfoByUserId(int $userId): array
    {

        $idList = $userId == 0 ? [1, 3, 5, 7, 9, 11] : $this->getIdListByUserId($userId);

        $titles = Title::getInstance()->getTitlesByType(FriendService::FRIEND_TITLE_TYPE);

        $friends = User::getInstance()->getInfoByIdList($idList);

        foreach ($friends as $index => $friend) {
            $friends[$index]['img-src'] = imgSrc($friend[User::USER_ICON]);
        }

        foreach ($titles as $index => $title) {
            $titles[$index]['img-src'] = imgSrc($title[Title::TITLE_ICON]);
        }

        return [
            'title' => $titles,
            'list' => $friends
        ];
    }

}