<?php

namespace App\Classes;

use App\User;
use ATehnix\VkClient\Client;

class Vk
{

    protected function request(string $request, array $vk, array $data) {
        return (new Client)->request($request, array_merge($vk, $data));
    }

    public function getGroups(User $user): Array
    {
        if (!$user->vk) {
            return [];
        }

        $data = $this->request('groups.get', $user->vk, [
            'extended' => 1
        ]);

        $response = $data['response'];

        foreach ($response['items'] as &$item) {
            $item['id'] = -$item['id'];
        }

        return [[
            'id' => (int) $user->vk['user_id'],
            'name' => 'На моей стене'
        ]] + $response['items'];
    }
}


