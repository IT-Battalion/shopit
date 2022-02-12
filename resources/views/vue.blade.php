@extends('layouts.app')
@section('head-content')
    <script>
        window.initialConfig = JSON.parse("@php
            use App\Models\ProductCategory;
            use Illuminate\Support\Facades\Auth;

            $user = Auth::user();

            $userData = [
                'isLoggedIn' => !is_null($user),
                'user' => $user?->only([
                    'id',
                    'username',
                    'firstname',
                    'lastname',
                    'email',
                    'lang',
                    'isAdmin',
                    'enabled',
                ]),
            ];

            $categoryColors = config('shop.category.colors');

            echo str_replace(
                '"',
                '\\"',
                json_encode(
                    [
                        'categories' => ProductCategory::whereHas('products')
                            ->get()
                            ->map(function (ProductCategory $category, int $key) use ($categoryColors) {
                                return [
                                    'id' => $category->id,
                                    'name' => $category->name,
                                    'color' => $categoryColors[$key % sizeof($categoryColors)],
                                ];
                            }),
                        'userState' => $userData,
                    ],
                    JSON_THROW_ON_ERROR,
                ),
            );
        @endphp");
    </script>
@endsection
