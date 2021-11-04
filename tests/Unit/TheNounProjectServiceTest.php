<?php

use App\Exceptions\IconNotFoundException;
use App\Services\Icons\NounProjectApi\ApiClient;
use App\Services\Icons\NounProjectApi\ApiIcon;
use App\Services\Icons\TheNounProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Illuminate\Http\Client\Response;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertStringStartsWith;

uses(RefreshDatabase::class);

test('search for valid icons', function () {
    $testData = '{
    "generated_at": "Fri, 22 Oct 2021 06:52:02 GMT",
    "icons": [
        {
            "attribution": "test by Forma from Noun Project",
            "collections": [
                {
                    "author": {
                        "location": "Barcelona, ES",
                        "name": "Forma",
                        "permalink": "/formaandco",
                        "username": "formaandco"
                    },
                    "author_id": "6746142",
                    "date_created": "2020-11-10 10:20:22.852717",
                    "date_updated": "2020-11-10 10:20:22.852719",
                    "description": "",
                    "id": "127624",
                    "is_collaborative": "",
                    "is_featured": "0",
                    "is_published": "1",
                    "is_store_item": "0",
                    "name": "Coronavirus. Covid-19. Generic Line Style 24 px Grid. By Forma.",
                    "permalink": "/formaandco/collection/coronavirus-covid-19-generic-line-style-24-px-grid",
                    "slug": "coronavirus-covid-19-generic-line-style-24-px-grid",
                    "sponsor": {},
                    "sponsor_campaign_link": "",
                    "sponsor_id": "",
                    "tags": [],
                    "template": "24"
                }
            ],
            "date_uploaded": "2020-11-10",
            "icon_url": "https://static.thenounproject.com/noun-svg/4115061.svg?Expires=1634889122&Signature=QYfHNYLT9QP9L-fsoc5zrb3u-xy5c0lVogV8ZIScvApZIJsCwYa8zaN38MASCErzCMdASiPLsJ9dMRW0HMDuMKgnhGZxfMW8BsvGgk5xQ0TeuCirOkRaERw3v01DWX~x1MFAa9JZdm2xHJGOgGR0iSj2tOEgYLV6zYgRxGgyYhk_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q",
            "id": "4115061",
            "is_active": "1",
            "is_explicit": "0",
            "license_description": "public-domain",
            "nounji_free": "0",
            "permalink": "/term/test/4115061",
            "preview_url": "https://static.thenounproject.com/png/4115061-200.png",
            "preview_url_42": "https://static.thenounproject.com/png/4115061-42.png",
            "preview_url_84": "https://static.thenounproject.com/png/4115061-84.png",
            "sponsor": {},
            "sponsor_campaign_link": null,
            "sponsor_id": "",
            "tags": [
                {
                    "id": 3430,
                    "slug": "test"
                },
                {
                    "id": 445763,
                    "slug": "coronavirus"
                },
                {
                    "id": 452714,
                    "slug": "covid-19"
                },
                {
                    "id": 6381,
                    "slug": "testing"
                },
                {
                    "id": 1679,
                    "slug": "virus"
                }
            ],
            "term": "test",
            "term_id": 3430,
            "term_slug": "test",
            "updated_at": "2021-07-30 00:20:56",
            "uploader": {
                "location": "Barcelona, ES",
                "name": "Forma",
                "permalink": "/formaandco",
                "username": "formaandco"
            },
            "uploader_id": "6746142",
            "year": 2020
        },
        {
            "attribution": "Water Quality by Iconathon from Noun Project",
            "collections": [
                {
                    "author": {
                        "location": "Los Angeles, California, US",
                        "name": "Iconathon",
                        "permalink": "/Iconathon1",
                        "username": "Iconathon1"
                    },
                    "author_id": "12701",
                    "date_created": "2014-10-24 00:00:01",
                    "date_updated": "2014-10-24 00:00:01",
                    "description": "With the City of Los Angeles and the Friends of the LA River",
                    "id": "1581",
                    "is_collaborative": "",
                    "is_featured": "0",
                    "is_published": "1",
                    "is_store_item": "0",
                    "name": "LA River",
                    "permalink": "/Iconathon1/collection/la-river",
                    "slug": "la-river",
                    "sponsor": {},
                    "sponsor_campaign_link": "",
                    "sponsor_id": "",
                    "tags": [
                        "iconathon",
                        "los angeles",
                        "LA"
                    ],
                    "template": "24"
                }
            ],
            "date_uploaded": "2012-10-15",
            "icon_url": "https://static.thenounproject.com/noun-svg/6294.svg?Expires=1634889122&Signature=E7aQ4YfG3EDJso2DEJKtNSutyTCCpmSzyeURRdisaFZpyclidietHvDB5kuqo-4qkQd9bSh59KF3djQ-4UZw6-sS1dB3Uf~apAg3-FJVivaa-ArCNgnawXb9E1l~xkeQeP2OPQKjd0a6ZhpEtS9NxSeOfcCw3~c2eFvHmUX1fS0_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q",
            "id": "6294",
            "is_active": "1",
            "is_explicit": "0",
            "license_description": "public-domain",
            "nounji_free": "0",
            "permalink": "/term/water-quality/6294",
            "preview_url": "https://static.thenounproject.com/png/6294-200.png",
            "preview_url_42": "https://static.thenounproject.com/png/6294-42.png",
            "preview_url_84": "https://static.thenounproject.com/png/6294-84.png",
            "sponsor": {},
            "sponsor_campaign_link": null,
            "sponsor_id": "",
            "tags": [
                {
                    "id": 7337,
                    "slug": "water-quality"
                },
                {
                    "id": 3430,
                    "slug": "test"
                },
                {
                    "id": 2882,
                    "slug": "river"
                },
                {
                    "id": 7338,
                    "slug": "quality"
                },
                {
                    "id": 618,
                    "slug": "pollution"
                },
                {
                    "id": 1319,
                    "slug": "plus"
                },
                {
                    "id": 1323,
                    "slug": "minus"
                },
                {
                    "id": 1660,
                    "slug": "measure"
                },
                {
                    "id": 3262,
                    "slug": "drop"
                },
                {
                    "id": 2481,
                    "slug": "conservation"
                },
                {
                    "id": 1093,
                    "slug": "clean"
                },
                {
                    "id": 205,
                    "slug": "water"
                }
            ],
            "term": "Water Quality",
            "term_id": 7337,
            "term_slug": "water-quality",
            "updated_at": "2019-04-22 19:22:17",
            "uploader": {
                "location": "Los Angeles, California, US",
                "name": "Iconathon",
                "permalink": "/Iconathon1",
                "username": "Iconathon1"
            },
            "uploader_id": "12701",
            "year": 2012
        },
        {
            "attribution": "Traffic Cone by Arthur Schmitt from Noun Project",
            "collections": [],
            "date_uploaded": "2013-06-13",
            "icon_url": "https://static.thenounproject.com/noun-svg/18161.svg?Expires=1634889122&Signature=QVVMDV67L953xMfOhGODiDMbOnIn2lSSgnQQGK66TpjhUIZM8R4wNwpujYDwgFE4mQvcjEMIuMI1hozeZlNh23K3fFxZ7akX66fMXBxf1-RDyyccLo-AtdDj1zImBv~-cZSkfQnuiDlh7i97h0vWfdwRlmu5n466DNWpiXDOEr8_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q",
            "id": "18161",
            "is_active": "1",
            "is_explicit": "0",
            "license_description": "public-domain",
            "nounji_free": "0",
            "permalink": "/term/traffic-cone/18161",
            "preview_url": "https://static.thenounproject.com/png/18161-200.png",
            "preview_url_42": "https://static.thenounproject.com/png/18161-42.png",
            "preview_url_84": "https://static.thenounproject.com/png/18161-84.png",
            "sponsor": {},
            "sponsor_campaign_link": null,
            "sponsor_id": "",
            "tags": [
                {
                    "id": 518,
                    "slug": "traffic-cone"
                },
                {
                    "id": 15636,
                    "slug": "wip"
                },
                {
                    "id": 946,
                    "slug": "warning"
                },
                {
                    "id": 3430,
                    "slug": "test"
                },
                {
                    "id": 9990,
                    "slug": "street-cone"
                },
                {
                    "id": 2088,
                    "slug": "roadworks"
                },
                {
                    "id": 459,
                    "slug": "construction"
                },
                {
                    "id": 311,
                    "slug": "caution"
                },
                {
                    "id": 15635,
                    "slug": "beta"
                },
                {
                    "id": 3353,
                    "slug": "alert"
                },
                {
                    "id": 6784,
                    "slug": "work-in-progress"
                }
            ],
            "term": "Traffic Cone",
            "term_id": 518,
            "term_slug": "traffic-cone",
            "updated_at": "2019-04-22 19:22:17",
            "uploader": {
                "location": "Montreal, Quebec, CA",
                "name": "Arthur Schmitt",
                "permalink": "/tart2000",
                "username": "tart2000"
            },
            "uploader_id": "16233",
            "year": 2013
        }
    ]
}
';
    $testResult = [
        new ApiIcon(
            '4115061',
            'test by Forma from Noun Project',
            'https://static.thenounproject.com/noun-svg/4115061.svg?Expires=1634889122&Signature=QYfHNYLT9QP9L-fsoc5zrb3u-xy5c0lVogV8ZIScvApZIJsCwYa8zaN38MASCErzCMdASiPLsJ9dMRW0HMDuMKgnhGZxfMW8BsvGgk5xQ0TeuCirOkRaERw3v01DWX~x1MFAa9JZdm2xHJGOgGR0iSj2tOEgYLV6zYgRxGgyYhk_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q',
            'https://static.thenounproject.com/png/4115061-200.png',
            strval(ApiIcon::LICENSE_PUBLIC_DOMAIN),
            'test',
            'Forma',
            'image/svg+xml'
        ),
        new ApiIcon(
            '6294',
            'Water Quality by Iconathon from Noun Project',
            'https://static.thenounproject.com/noun-svg/6294.svg?Expires=1634889122&Signature=E7aQ4YfG3EDJso2DEJKtNSutyTCCpmSzyeURRdisaFZpyclidietHvDB5kuqo-4qkQd9bSh59KF3djQ-4UZw6-sS1dB3Uf~apAg3-FJVivaa-ArCNgnawXb9E1l~xkeQeP2OPQKjd0a6ZhpEtS9NxSeOfcCw3~c2eFvHmUX1fS0_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q',
            'https://static.thenounproject.com/png/6294-200.png',
            strval(ApiIcon::LICENSE_PUBLIC_DOMAIN),
            'Water Quality',
            'Iconathon',
            'image/svg+xml'
        ),
        new ApiIcon(
            '18161',
            'Traffic Cone by Arthur Schmitt from Noun Project',
            'https://static.thenounproject.com/noun-svg/18161.svg?Expires=1634889122&Signature=QVVMDV67L953xMfOhGODiDMbOnIn2lSSgnQQGK66TpjhUIZM8R4wNwpujYDwgFE4mQvcjEMIuMI1hozeZlNh23K3fFxZ7akX66fMXBxf1-RDyyccLo-AtdDj1zImBv~-cZSkfQnuiDlh7i97h0vWfdwRlmu5n466DNWpiXDOEr8_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q',
            'https://static.thenounproject.com/png/18161-200.png',
            strval(ApiIcon::LICENSE_PUBLIC_DOMAIN),
            'Traffic Cone',
            'Arthur Schmitt',
            'image/svg+xml'
        )
    ];

    $response = $this->partialMock(Response::class, function (MockInterface $mock) use ($testData) {
        $mock->shouldReceive('failed')->once()->andReturnFalse();
        $mock->shouldReceive('body')->once()->andReturn($testData);
    });

    $this->instance(
        ApiClient::class,
        $this->mock(ApiClient::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('fetch')->once()->andReturn($response);
        })
    );

    $service = $this->app->make(TheNounProjectService::class);

    assertEquals($testResult, $service->findByName('test'), 'Couldn\'t find related icons');
});

test('search for non-existent icons', function () {
    $response = $this->partialMock(Response::class, function (MockInterface $mock) {
        $mock->shouldReceive('failed')->once()->andReturnTrue();
        $mock->shouldReceive('status')->once()->andReturn(404);
    });

    $this->instance(
        ApiClient::class,
        $this->mock(ApiClient::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('fetch')->once()->andReturn($response);
        })
    );

    $service = $this->app->make(TheNounProjectService::class);
    $icons = $service->findByName('surely no icons are called this way not found');

    assertIsArray($icons, 'Icon API Service didn\'t return an array');
    assert(function () use ($icons) {
        return sizeof($icons) === 0;
    }, 'The resulting list of icons isn\'t empty');
});

test('search for invalidly structured icons', function () {
    $testData = '{
    "generated_at": "Fri, 22 Oct 2021 07:16:54 GMT",
    "icons": [
        {
            "attribution": "test by ChangHoon Baek from Noun Project",
            "attribution_preview_url": "https://static.thenounproject.com/attribution/84093-600.png",
            "collections": [],
            "date_uploaded": "2014-11-19",
            "id": "84093",
            "is_active": "1",
            "is_explicit": "0",
            "license_description": "creative-commons-attribution",
            "nounji_free": "0",
            "permalink": "/term/test/84093",
            "preview_url": "https://static.thenounproject.com/png/84093-200.png",
            "preview_url_42": "https://static.thenounproject.com/png/84093-42.png",
            "preview_url_84": "https://static.thenounproject.com/png/84093-84.png",
            "sponsor": {},
            "sponsor_campaign_link": null,
            "sponsor_id": "",
            "tags": [
                {
                    "id": 3430,
                    "slug": "test"
                },
                {
                    "id": 7517,
                    "slug": "user-interface"
                },
                {
                    "id": 11284,
                    "slug": "user-experience"
                },
                {
                    "id": 19319,
                    "slug": "ui"
                },
                {
                    "id": 6147,
                    "slug": "register"
                },
                {
                    "id": 469,
                    "slug": "paper"
                },
                {
                    "id": 4065,
                    "slug": "list"
                },
                {
                    "id": 6032,
                    "slug": "form"
                },
                {
                    "id": 2286,
                    "slug": "design"
                },
                {
                    "id": 4903,
                    "slug": "checklist"
                },
                {
                    "id": 1149,
                    "slug": "check"
                },
                {
                    "id": 1290,
                    "slug": ""
                },
                {
                    "id": 6757,
                    "slug": "ux"
                }
            ],
            "term": "test",
            "term_id": 3430,
            "term_slug": "test",
            "updated_at": "2019-04-22 19:22:17",
            "uploader": {
                "location": "Toronto, ON, CA",
                "name": "ChangHoon Baek",
                "permalink": "/changhoon.baek.50",
                "username": "changhoon.baek.50"
            },
            "uploader_id": "37574",
            "year": 2014
        },
        {
            "attribution": "test by Arthur Shlain from Noun Project",
            "attribution_preview_url": "https://static.thenounproject.com/attribution/247442-600.png",
            "collections": [
                {
                    "author": {
                        "location": "Perm, RU",
                        "name": "Arthur Shlain",
                        "permalink": "/ArtZ91",
                        "username": "ArtZ91"
                    },
                    "author_id": "15311",
                    "date_created": "2014-08-20 19:59:47",
                    "date_updated": "2015-08-25 19:15:04",
                    "description": "",
                    "id": "866",
                    "is_collaborative": "",
                    "is_featured": "0",
                    "is_published": "1",
                    "is_store_item": "0",
                    "name": "Assemblage",
                    "permalink": "/ArtZ91/collection/assemblage",
                    "slug": "assemblage",
                    "sponsor": {},
                    "sponsor_campaign_link": "",
                    "sponsor_id": "",
                    "tags": [],
                    "template": "24"
                }
            ],
            "date_uploaded": "2015-11-13",
            "id": "247442",
            "is_active": "1",
            "is_explicit": "0",
            "license_description": "creative-commons-attribution",
            "nounji_free": "0",
            "permalink": "/term/test/247442",
            "preview_url": "https://static.thenounproject.com/png/247442-200.png",
            "preview_url_42": "https://static.thenounproject.com/png/247442-42.png",
            "preview_url_84": "https://static.thenounproject.com/png/247442-84.png",
            "sponsor": {},
            "sponsor_campaign_link": null,
            "sponsor_id": "",
            "tags": [
                {
                    "id": 3430,
                    "slug": "test"
                },
                {
                    "id": 5282,
                    "slug": "tasks"
                },
                {
                    "id": 8435,
                    "slug": "result"
                },
                {
                    "id": 4875,
                    "slug": "plan"
                },
                {
                    "id": 11469,
                    "slug": "grade"
                },
                {
                    "id": 3149,
                    "slug": "goal"
                },
                {
                    "id": 8540,
                    "slug": "exam"
                },
                {
                    "id": 58355,
                    "slug": "check-list"
                },
                {
                    "id": 16012,
                    "slug": "challenge"
                },
                {
                    "id": 10926,
                    "slug": "validation"
                }
            ],
            "term": "test",
            "term_id": 3430,
            "term_slug": "test",
            "updated_at": "2019-04-22 19:22:17",
            "uploader": {
                "location": "Perm, RU",
                "name": "Arthur Shlain",
                "permalink": "/ArtZ91",
                "username": "ArtZ91"
            },
            "uploader_id": "15311",
            "year": 2015
        },
        {
            "attribution": "test by Dmitry Mirolyubov from Noun Project",
            "attribution_preview_url": "https://static.thenounproject.com/attribution/283081-600.png",
            "collections": [
                {
                    "author": {
                        "location": "Санкт-Петербург, Санкт-Петербург, RU",
                        "name": "Dmitry Mirolyubov",
                        "permalink": "/dmitriy.mir",
                        "username": "dmitriy.mir"
                    },
                    "author_id": "19979",
                    "date_created": "2015-12-14 00:08:52",
                    "date_updated": "2015-12-14 00:08:52",
                    "description": "",
                    "id": "9459",
                    "is_collaborative": "",
                    "is_featured": "0",
                    "is_published": "1",
                    "is_store_item": "0",
                    "name": "SEO 1",
                    "permalink": "/dmitriy.mir/collection/seo-1",
                    "slug": "seo-1",
                    "sponsor": {},
                    "sponsor_campaign_link": "",
                    "sponsor_id": "",
                    "tags": [],
                    "template": "24"
                }
            ],
            "date_uploaded": "2015-12-14",
            "id": "283081",
            "is_active": "1",
            "is_explicit": "0",
            "license_description": "creative-commons-attribution",
            "nounji_free": "0",
            "permalink": "/term/test/283081",
            "preview_url": "https://static.thenounproject.com/png/283081-200.png",
            "preview_url_42": "https://static.thenounproject.com/png/283081-42.png",
            "preview_url_84": "https://static.thenounproject.com/png/283081-84.png",
            "sponsor": {},
            "sponsor_campaign_link": null,
            "sponsor_id": "",
            "tags": [
                {
                    "id": 3430,
                    "slug": "test"
                },
                {
                    "id": 566,
                    "slug": "shelter"
                },
                {
                    "id": 712,
                    "slug": "research"
                },
                {
                    "id": 4065,
                    "slug": "list"
                },
                {
                    "id": 11870,
                    "slug": "lense"
                },
                {
                    "id": 2654,
                    "slug": "clipboard"
                },
                {
                    "id": 1149,
                    "slug": "check"
                },
                {
                    "id": 1960,
                    "slug": "board"
                },
                {
                    "id": 131491,
                    "slug": "aalysis"
                },
                {
                    "id": 1802,
                    "slug": "storage"
                }
            ],
            "term": "test",
            "term_id": 3430,
            "term_slug": "test",
            "updated_at": "2019-04-22 19:22:17",
            "uploader": {
                "location": "Санкт-Петербург, Санкт-Петербург, RU",
                "name": "Dmitry Mirolyubov",
                "permalink": "/dmitriy.mir",
                "username": "dmitriy.mir"
            },
            "uploader_id": "19979",
            "year": 2015
        }
    ]
}
';
    $testResult = [];

    $response = $this->partialMock(Response::class, function (MockInterface $mock) use ($testData) {
        $mock->shouldReceive('failed')->once()->andReturnFalse();
        $mock->shouldReceive('body')->andReturn($testData);
    });

    $this->instance(
        ApiClient::class,
        $this->mock(ApiClient::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('fetch')->once()->andReturn($response);
        })
    );

    $service = $this->app->make(TheNounProjectService::class);

    assertEquals($testResult, $service->findByName('test'), 'Couldn\'t find related icons');
});

test('search for icon', function () {
    $testData = '{
    "icon": {
        "attribution": "Traffic Cone by Arthur Schmitt from Noun Project",
        "collections": [],
        "date_uploaded": "2013-06-13",
        "icon_url": "https://static.thenounproject.com/noun-svg/18161.svg?Expires=1635802095&Signature=kxMDzQ1IIZTGNgGGuJEQ~Xi3YRZbb1vfgYnqe1zhbD4KyZw-EbmiF1v9GZE9aVSSPNsKtbXToUZcVL6zh~ilO1U0lIz3~spFvfokS0Q2fWT2FuGuZnQsz~EvW6UduQii-rjFMLeHOr5ic9A9i7BzWznV35xZxOkNruO2wLypqJE_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q",
        "id": "18161",
        "is_active": "1",
        "is_explicit": "0",
        "license_description": "public-domain",
        "nounji_free": "0",
        "permalink": "/term/traffic-cone/18161",
        "preview_url": "https://static.thenounproject.com/png/18161-200.png",
        "preview_url_42": "https://static.thenounproject.com/png/18161-42.png",
        "preview_url_84": "https://static.thenounproject.com/png/18161-84.png",
        "sponsor": {},
        "sponsor_campaign_link": null,
        "sponsor_id": "",
        "tags": [
            {
                "id": 518,
                "slug": "traffic-cone"
            },
            {
                "id": 15636,
                "slug": "wip"
            },
            {
                "id": 946,
                "slug": "warning"
            },
            {
                "id": 3430,
                "slug": "test"
            },
            {
                "id": 9990,
                "slug": "street-cone"
            },
            {
                "id": 2088,
                "slug": "roadworks"
            },
            {
                "id": 459,
                "slug": "construction"
            },
            {
                "id": 311,
                "slug": "caution"
            },
            {
                "id": 15635,
                "slug": "beta"
            },
            {
                "id": 3353,
                "slug": "alert"
            },
            {
                "id": 6784,
                "slug": "work-in-progress"
            }
        ],
        "term": "Traffic Cone",
        "term_id": 518,
        "term_slug": "traffic-cone",
        "updated_at": "2019-04-22 19:22:17",
        "uploader": {
            "location": "Montreal, Quebec, CA",
            "name": "Arthur Schmitt",
            "permalink": "/tart2000",
            "username": "tart2000"
        },
        "uploader_id": "16233",
        "year": 2013
    }
}';

    $testDataResult = new ApiIcon(
        '18161',
        'Traffic Cone by Arthur Schmitt from Noun Project',
        'https://static.thenounproject.com/noun-svg/18161.svg?Expires=1635802095&Signature=kxMDzQ1IIZTGNgGGuJEQ~Xi3YRZbb1vfgYnqe1zhbD4KyZw-EbmiF1v9GZE9aVSSPNsKtbXToUZcVL6zh~ilO1U0lIz3~spFvfokS0Q2fWT2FuGuZnQsz~EvW6UduQii-rjFMLeHOr5ic9A9i7BzWznV35xZxOkNruO2wLypqJE_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q',
        'https://static.thenounproject.com/png/18161-200.png',
        ApiIcon::LICENSE_PUBLIC_DOMAIN,
        'Traffic Cone',
        'Arthur Schmitt',
        'image/svg+xml'
    );

    $response = $this->partialMock(Response::class, function (MockInterface $mock) use ($testData) {
        $mock->shouldReceive('failed')->once()->andReturnFalse();
        $mock->shouldReceive('body')->andReturn($testData);
    });

    $this->instance(
        ApiClient::class,
        $this->mock(ApiClient::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('fetch')->once()->andReturn($response);
        })
    );

    $service = $this->app->make(TheNounProjectService::class);

    assertEquals($testDataResult, $service->findById($testDataResult->id), 'Couldn\'t find searched icon');
});

test('search for non existent icon', function () {
    $exception = new Exception();

    $response = $this->mock(Response::class, function (MockInterface $mock) use ($exception) {
        $mock->shouldReceive('failed')->once()->andReturnTrue();
        $mock->shouldReceive('status')->once()->andReturn(404);
        $mock->shouldReceive('toException')->once()->andReturn($exception);
    });

    $this->instance(
        ApiClient::class,
        $this->mock(ApiClient::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('fetch')->once()->andReturn($response);
        })
    );

    $service = $this->app->make(TheNounProjectService::class);
    $service->findById('abc123');
})->throws(IconNotFoundException::class);

test('add icon', function () {
    $testData = new ApiIcon(
        '18161',
        'Traffic Cone by Arthur Schmitt from Noun Project',
        'https://static.thenounproject.com/noun-svg/18161.svg?Expires=1635802095&Signature=kxMDzQ1IIZTGNgGGuJEQ~Xi3YRZbb1vfgYnqe1zhbD4KyZw-EbmiF1v9GZE9aVSSPNsKtbXToUZcVL6zh~ilO1U0lIz3~spFvfokS0Q2fWT2FuGuZnQsz~EvW6UduQii-rjFMLeHOr5ic9A9i7BzWznV35xZxOkNruO2wLypqJE_&Key-Pair-Id=APKAI5ZVHAXN65CHVU2Q',
        'https://static.thenounproject.com/png/18161-200.png',
        ApiIcon::LICENSE_PUBLIC_DOMAIN,
        'Traffic Cone',
        'Arthur Schmitt',
        'image/svg+xml'
    );

    $response = $this->partialMock(Response::class, function (MockInterface $mock) use ($testData) {
        $mock->shouldReceive('failed')->andReturnFalse();
    });

    $this->instance(
        ApiClient::class,
        $this->mock(ApiClient::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('downloadIcon')->once()->andReturn($response);
        })
    );

    $service = $this->app->make(TheNounProjectService::class);

    $createdIcon = $service->add($testData);

    $this->assertModelExists($createdIcon);
    assertEquals('18161', $createdIcon->original_id, 'got wrong id');
    assertEquals('Traffic Cone', $createdIcon->name, 'got wrong icon name');
    assertEquals('Arthur Schmitt', $createdIcon->artist, 'got wrong artist');
    assertEquals('the Noun Project', $createdIcon->provider, 'got wrong provider');
    assertEquals(strval(ApiIcon::LICENSE_PUBLIC_DOMAIN), $createdIcon->license, 'got wrong license');
    assertEquals('image/svg+xml', $createdIcon->mimetype, 'got wrong mimetype');
    assertEquals('icons/' . $createdIcon->original_id, $createdIcon->path, 'got wrong path');

    Storage::delete($createdIcon->path);
});
