<?php

namespace App\Classes\Social;

use View;
use App\Ad;
use App\User;
use ATehnix\VkClient\Client;
use App\DTO\Vk\VkInfoData;
use App\Classes\Helpers\VkPhotoUploader;
use ATehnix\VkClient\Exceptions\InternalErrorVkException;
use ATehnix\VkClient\Exceptions\AccessDeniedVkException;

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

        $posts = [];

        foreach ($user->getVkGroupsIds() as $owner_id) {
            try {
                $post = self::request('wall.post', [
                    'access_token' => $vk->access_token,
                    'owner_id' => $owner_id,
                    'message' => self::render('social.vk', $ad, $user),
                    'attachments' => VkPhotoUploader::getAttachments($ad, $vk)
                ]);

                $posts[] = [
                    'owner_id' => $owner_id,
                    'post_id' => $post['post_id']
                ];
            } catch (Exception $e) {
                \Log::error($e);
            } catch (AccessDeniedVkException $e) {
                \Log::error($e);
            }
        }

        $ad->vkPosts()
           ->createMany($posts);
    }

    public static function update(Ad $ad, User $user) {
        $vk = $user->getVkInfo();

        foreach ($ad->vkPosts as $vkPost) {
            try {
                self::request('wall.edit', [
                    'access_token' => $vk->access_token,
                    'post_id' => $vkPost->post_id,
                    'owner_id' => $vkPost->owner_id,
                    'message' => self::render('social.vk', $ad, $user),
                    'attachments' => VkPhotoUploader::getAttachments($ad, $vk)
                ]);
            } catch (InternalErrorVkException $e) {
                \Log::error($e);
            } catch (AccessDeniedVkException $e) {
                \Log::error($e);
            }
        }
    }

    public static function delete(Ad $ad, User $user) {
        $vk = $user->getVkInfo();

        foreach ($ad->vkPosts as $vkPost) {
            try {
                self::request('wall.delete', [
                    'access_token' => $vk->access_token,
                    'post_id' => $vkPost->post_id,
                    'owner_id' => $vkPost->owner_id
                ]);
            } catch (InternalErrorVkException $e) {
                \Log::error($e);
            } catch (AccessDeniedVkException $e) {
                \Log::error($e);
            }
        }

        $ad
            ->vkPosts()
            ->delete();
    }
}


