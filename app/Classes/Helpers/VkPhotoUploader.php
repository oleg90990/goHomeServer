<?php

namespace App\Classes\Helpers;

use App\Ad;
use App\DTO\VkInfoData;
use App\Classes\Social\Vk;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use App\Classes\ImageManipulator;
use Illuminate\Database\Eloquent\Collection;

class VkPhotoUploader
{

    public static function getAttachments(Ad $ad, VkInfoData $vk): string {
        $photos = $ad->photos->filter(function ($photo) {
            return !$photo->vk;
        })->values();


        if ($photos->count() > 0) {
            $items = self::upload($photos, $vk);

            foreach ($photos as $key => &$photo) {
                $photo->vk = $items[$key];
                $photo->save();
            }
        }

        return $ad->photos->map(function($photo) {
            return $photo->getVkId();
        })->join(',');
    }

    public static function upload($photos, VkInfoData $vk): array {
        $server = Vk::request('photos.getWallUploadServer', [
            'group_id' => $vk->user_id,
            'access_token' => $vk->access_token
        ]);

        $data = self::request(
            $server['upload_url'],
            $photos
        );

        if (!$data) {
            return new Collection;
        }

        return Vk::request('photos.saveWallPhoto', [
            'group_id' => $vk->user_id,
            'access_token' => $vk->access_token
        ] + $data); 
    }

    public static function request(string $uploadUrl, $photos) {
        $client = new HttpClient;

        try {

            $files = $photos->map(function($photo, $key) {
                return [
                    'name' => "file$key",
                    'contents' => ImageManipulator::fopen($photo->path)
                ];
            })->toArray();

            $result = $client->request('POST', $uploadUrl, [
                'multipart' => $files
            ]);

            return json_decode($result->getBody(), true);
        } catch (ClientException $e) {
        } catch (ConnectException $e) {
        } catch (RequestException $e) {
        }

        return false;
    }
}