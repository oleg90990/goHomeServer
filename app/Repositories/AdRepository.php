<?php
namespace App\Repositories;

use App\Ad;
use App\User;
use Exeption;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\Gender;
use App\Enums\YesNo;
use App\Enums\Social;
use App\Classes\SocialProvider;
use App\DTO\{
    CreateAdData,
    UpdateAdData,
    FindAdData
};

class AdRepository
{

    /**
     * Create Ad from request
     *
     * @param CreateAdData
     * @param User
     * @return Ad
     */
    public function create(CreateAdData $data, User $user): Ad
    {

        $ad = $user->ads()
            ->create([
                'title' => $data->title,
                'content' => $data->content,
                'age' => $data->age,
                'gender' => $data->gender,
                'sterilization' => $data->sterilization,
                'user_id' => $user->id,
                'breed_id' => $data->breed_id,
                'animal_id' => $data->animal_id,
                'city_id' => $data->city_id,
                'active' => true
            ]);

        $ad->setPhotos($data->images);
        $ad->setColors($data->colors);

        SocialProvider::publish($ad, $user, $data->socials);

        return $ad;
    }

    /**
     * CreateAdData Ad from request
     *
     * @param CreateAdData
     * @param User
     * @return Ad
     */
    public function update(Ad $ad, UpdateAdData $data, User $user): Ad
    {
        $ad->title = $data->title;
        $ad->content = $data->content;
        $ad->age = $data->age;
        $ad->gender = $data->gender;
        $ad->sterilization = $data->sterilization;
        $ad->breed_id = $data->breed_id;
        $ad->animal_id = $data->animal_id;
        $ad->city_id = $data->city_id;
        $ad->save();

        $ad->setPhotos($data->images);
        $ad->setColors($data->colors);

        SocialProvider::update($ad, $user, [Social::Vk]);

        return $ad;
    }

    /**
     * get Ads from user
     *
     * @param User
     * @return Ad
     */
    public function getAllFromUser(User $user): Collection
    {
        return $user
            ->ads()
            ->with('user', 'photos')
            ->get();
    }


    /**
     * get Ads by id from user
     *
     * @param User
     * @param int
     * @return ?Ad
     */
    public function getByIdFromUser(User $user, int $id): ?Ad
    {
        return $user->ads()->where('id', $id)->first();
    }

    /**
     * Publish Ad
     *
     * @param Ad
     * @param bool
     * @return void
     */
    public function publish(Ad $ad, User $user, bool $active): void
    {
        $ad->active = $active;
        $ad->save();

        if (!$active) {
            SocialProvider::delete($ad, $user, [Social::Vk]);
        } else {
            // SocialProvider::publish($ad, $user, ['vk']);
        }
    }

    /**
     * Publish Ad
     *
     * @param Ad
     * @param bool
     * @return void
     */
    public function find(FindAdData $data): LengthAwarePaginator
    {
        $city = $data->city;
        $colors = $data->colors;

        $query = Ad::query()
            ->with('user', 'photos')
            ->select('ads.*');

        $query->where('active', 1);
        $query->where('age', '>=', $data->ages['from']);
        $query->where('age', '<=', $data->ages['to']);

        if ($city && !$city['parent_id']) {
            $query->join('cities', 'cities.id', '=', 'city_id');
            $query->where('cities.parent_id', $city['id']);
        } elseif ($city) {
            $query->where('city_id', $city['id']);
        }

        if ($data->animal) {
            $query->where('animal_id', $data->animal);
        }

        if ($data->breeds) {
            $query->whereIn('breed_id', $data->breeds);
        }

        if (in_array($data->gender, [Gender::Male, Gender::Female])) {
            $query->where('gender', $data->gender);
        }

        if (in_array($data->sterilization, [YesNo::Yes, YesNo::No])) {
            $query->where('sterilization', $data->sterilization);
        }

        if (count($colors) > 0) {
            $query->whereHas('colors', function($q) use ($colors) {
                $q->whereIn('id', $colors);
            });
        }

        if ($data->sortBy == 'date') {
           $query->orderBy('updated_at', 'desc');
        }

        if ($data->sortBy == 'age') {
           $query->orderBy('age', 'asc');
        }

        return $query->paginate(5, ['*'], 'page', $data->page);
    }
}
