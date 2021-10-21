<?php

namespace App\Services\Icons;

use App\Models\Icon;
use App\Services\Icons\Api\ApiIcon;
use Illuminate\Database\Eloquent\Collection;

interface IconServiceInterface
{

    /**
     * @return ApiIcon[] The API response in form of an array of {@link ApiIcon}s
     */

    public function findByName(
        string $iconName,
        int $offset = null,
        int $page = null,
        int $limit = null) : array;

    /**
     * @param string $id The id of the icon to search
     * @return ApiIcon The icon that the API found in response to the id
     */

    public function findById(string $id) : ApiIcon;

    /**
     * @param ApiIcon $apiIcon the icon to download and add to the database/the application
     * @return Icon the icon saved to the database
     */

    public function add(ApiIcon $apiIcon) : Icon;

    /**
     * @param string $iconName The icon name to search for in the database
     * @return Collection The icons with a name matching the $iconName
     */

    public function getByName(string $iconName) : Collection;

    /**
     * @param string $id The database id of the icon to get
     * @return Icon The icon to get
     */

    public function getById(string $id) : Icon;

}
