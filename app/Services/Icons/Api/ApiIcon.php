<?php

namespace App\Services\Icons\Api;

/**
 * A class representing an Icon in an API response from https://api.thenounproject.com/icons
 */
class ApiIcon
{
    public const LICENSE_PUBLIC_DOMAIN = 1;
    public const LICENSE_CC_BY_3_0 = 2;

    /**
     * @var string The id of the icon
     */

    public string $id;
    /**
     * @var string The attribution to the author of the icon and providers
     */

    public string $attribution;
    /**
     * @var string The url to the icon
     */

    public string $icon_url;
    /**
     * @var string The url to the icon preview
     */

    public string $preview_url;
    /**
     * @var string The license used
     */

    public string $license;
    /**
     * @var string The name of the icon
     */

    public string $name;
    /**
     * @var string The artist who created the icon
     */

    public string $artist;
    /**
     * @var string The mimetype of the icon image (main see {@link $icon_url})
     */

    public string $mimetype;

    /**
     * @param string $id
     * @param string $attribution
     * @param string $icon_url
     * @param string $preview_url
     * @param string $license
     * @param string $name
     * @param string $artist
     * @param string $mimetype
     */
    public function __construct(string $id, string $attribution, string $icon_url, string $preview_url, string $license, string $name, string $artist, string $mimetype)
    {
        $this->id = $id;
        $this->attribution = $attribution;
        $this->icon_url = $icon_url;
        $this->preview_url = $preview_url;
        $this->license = $license;
        $this->name = $name;
        $this->artist = $artist;
        $this->mimetype = $mimetype;
    }

}
