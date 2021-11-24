<?php

namespace App\Services\Icons;

use App\Models\Icon;
use App\Services\Icons\NounProjectApi\ApiIcon;
use Illuminate\Database\Eloquent\Collection;

interface IconServiceInterface
{
    /**
     * Searches for an icon by title
     * @param string $iconName the name to search for
     * @param int|null $offset the number of icons to skip from the result
     * @param int|null $page the page is an offset calculated with  $limit * $page
     * @param int|null $limit the maximum number of icons to search for
     * @param array $options Additional implementation specific options
     * @return ApiIcon[] The API response in form of an array of {@link ApiIcon}s
     */

    public function findByName(
        string $iconName,
        int $offset = null,
        int $page = null,
        int $limit = null,
        array $options = []) : array;

    /**
     * Searches in the api for an icon by title
     * @param string $iconName the name to search for
     * @param int|null $offset the number of icons to skip from the result
     * @param int|null $page the page is an offset calculated with  $limit * $page
     * @param int|null $limit the maximum number of icons to search for
     * @param array $options Additional implementation specific options
     * @return ApiIcon[] The API response in form of an array of {@link ApiIcon}s
     */

    public function findByNameThroughApi(
        string $iconName,
        int $offset = null,
        int $page = null,
        int $limit = null,
        array $options = []) : array;

    /**
     * Searches in the database for an icon by title
     * @param string $iconName the name to search for
     * @param int|null $offset the number of icons to skip from the result
     * @param int|null $page the page is an offset calculated with  $limit * $page
     * @param int|null $limit the maximum number of icons to search for
     * @return ApiIcon[] The API response in form of an array of {@link ApiIcon}s
     */

    public function findByNameInDatabase(
        string $iconName,
        int $offset = null,
        int $page = null,
        int $limit = null) : array;

    /**
     * Searches for an icon by the icon id
     * @param string $id The id of the icon to search
     * @return ApiIcon The icon that the API found in response to the id
     */

    public function findById(string $id) : ApiIcon;

    /**
     * Searches for an icon by the icon id
     * @param string $id The id of the icon to search
     * @return ApiIcon|null The icon that the API found in response to the id
     */

    public function findByIdInDatabase(string $id) : ApiIcon|null;

    /**
     * Searches for an icon by the icon id
     * @param string $id The id of the icon to search
     * @return ApiIcon The icon that the API found in response to the id
     */

    public function findByIdThroughApi(string $id) : ApiIcon;

    /**
     * Downloads an icon and adds it to the application
     * @param ApiIcon $apiIcon the icon to download and add to the database/the application
     * @return Icon the icon saved to the database
     */

    public function add(ApiIcon $apiIcon) : Icon;

    /**
     * Searches for an icon by name in the application
     * @param string $iconName The icon name to search for in the database
     * @return Collection The icons with a name matching the $iconName
     */

    public function getByName(string $iconName) : Collection;

    /**
     * Searches for an icon by id in the application
     * @param string $id The database id of the icon to get
     * @return Icon The icon to get
     */

    public function getById(string $id) : Icon;

}
