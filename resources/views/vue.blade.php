@extends('layouts.app')
@section('head-content')
    <script>
        window.initialConfig = JSON.parse("@php
        use App\Models\ProductCategory;
        use Illuminate\Support\Facades\Auth;

        $user = Auth::user();

        if (Auth::check()) {
            $userData = [
                'isLoggedIn' => true,
                ...$user->only([
					'id',
					'username',
					'email',
					'firstname',
					'lastname',
					'name',
					'employeeType',
					'class',
					'lang',
					'is_admin',
                ]),
            ];
        } else {
            $userData = [
                'isLoggedIn' => false,
            ];
        }

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
                    'user' => $userData,
                ],
                JSON_THROW_ON_ERROR,
            ),
        );
        @endphp");
    </script>
@endsection
