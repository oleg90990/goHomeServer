<?php

namespace App\Classes\Social;

use View;
use App\Ad;
use App\User;
use ATehnix\VkClient\Client;
use App\Classes\ImageManipulator;
use App\DTO\VkInfoData;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;


class Vk implements SocialInterface
{
    protected static function request(string $request, VkInfoData $vk, array $data) {
        return (new Client)->request($request, array_merge([
            'access_token' => $vk->access_token
        ], $data))['response'];
    }

    public static function getGroups(VkInfoData $vk): Array
    {
        $data = self::request('groups.get', $vk, [
            'user_id' => $vk->user_id,
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

    public static function uploadPhotos($upload_url, $photos) {
        $client = new HttpClient;

        try {
            $result = $client->request('POST', $upload_url, [
                'multipart' => array_map(function($photo, $key) {
                    return [
                        'name' => "file$key",
                        'contents' => ImageManipulator::fopen($photo)
                    ];
                }, $photos, array_keys($photos))
            ]);

            return json_decode($result->getBody(), true);
        } catch (ClientException $e) {
        } catch (ConnectException $e) {
        } catch (RequestException $e) {
        }

        return false;
    }

    public static function getAttachments(array $media, VkInfoData $vk): string {
        $group = [
            'group_id' => $vk->user_id
        ];

        $server = self::request('photos.getWallUploadServer', $vk, $group);

        if (!isset($server['upload_url'])) {
            return '';
        }

        $photos = self::uploadPhotos(
            $server['upload_url'],
            $media
        );

        if (!$photos) {
            return '';
        }

        $result = self::request('photos.saveWallPhoto', $vk, $group + $photos);

        $media = array_map(function($data) {
            return "photo" . $data['owner_id'] . '_' . $data['id'];
        }, $result);

        return join(',', $media);
    }

    public static function access(User $user) {
        return !!$user->getVkInfo();
    }

    public static function publish(Ad $ad, User $user) {
        $vk = $user->getVkInfo();

        $view = View::make('social.vk', [
            'ad' => $ad,
            'user' => $user
        ]);

        $attachments = self::getAttachments($ad->images, $vk);

        foreach ($user->getVkGroupsIds() as $owner_id) {
            self::request('wall.post', $vk, [
                'owner_id' => $owner_id,
                'message' => $view->render(),
                'attachments' => $attachments
            ]);
        }
    }

    public static function update(Ad $ad, User $user) {
        dd('update');
    }

    public static function delete(Ad $ad, User $user) {
        dd('delete');
    }
}


