<?php
namespace App\Repositories;

use App\Animal;
use App\Color;
use App\City;
use Illuminate\Database\Eloquent\Collection;

class DictionariesRepository
{

    /**
     * Get All Animals
     *
     * @return Ad
     */
    public function animals(): Collection
    {
        return Animal::with('breeds')->get();
    }

    /**
     * Get All Animals
     *
     * @return Ad
     */
    public function colors(): Collection
    {
        return Color::all();
    }

    /**
     * Get All Animals
     *
     * @return Ad
     */
    public function findCities(string $q, bool $includeRegions = true, int $count = 10): Collection
    {

        if (!$q) {
            $qyery = City::where('parent_id', 15);

            if ($includeRegions) {
                $qyery->OrWhere('id', 15);
            }

            return $qyery->take($count)
                ->orderBy('population', 'desc')
                ->get();
        }

        $query = City::where('name', 'like', "%$q%");

        if (!$includeRegions) {
           $query->whereNotNull('parent_id');
        }

        return $query
            ->take($count)
            ->orderBy('population', 'desc')
            ->get();
    }
}