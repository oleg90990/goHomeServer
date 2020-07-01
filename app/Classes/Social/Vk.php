<?php

namespace App\Classes\Social;

use View;
use App\Ad;
use App\User;
use ATehnix\VkClient\Client;
use App\DTO\VkInfoData;
use App\Classes\Helpers\VkPhotoUploader;

class Vk implements SocialInterface
{
    public static function request(string $request, array $data) {
        return (new Client)->request($request, $data)['response'];
    }

    public static function render(string $template, Ad $ad, User $user) {
        return View::make($template, ['ad' => $ad, 'user' => $user ])->render(); 
    }

    public static function getGroups(VkInfoData $vk): Array
    {
        $data = self::request('groups.get', [
            'user_id' => $vk->user_id,
            'access_token' => $vk->access_token,
            'extended' => 1
        ]);

        foreach ($data['items'] as &$item) {
            $item['id'] = -$item['id'];
        }

        return [[
            'id' => (int) $vk->user_id,
            'name' => 'На моей стене'
        ]] + $data['items'];
    }

    public static function access(User $user) {
        return !!$user->getVkInfo();
    }

    public static function publish(Ad $ad, User $user) {
        $vk = $user->getVkInfo();

        foreach ($user->getVkGroupsIds() as $owner_id) {
            self::request('wall.post', [
                'access_token' => $vk->access_token,
                'owner_id' => $owner_id,
                'message' => self::render('social.vk', $ad, $user),
                'attachments' => VkPhotoUploader::getAttachments($ad, $vk)
            ]);
        }
    }

    public static function update(Ad $ad, User $user) {
        // dd('update');
    }

    public static function delete(Ad $ad, User $user) {
        // dd('delete');
    }
}


