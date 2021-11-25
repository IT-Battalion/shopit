@extends('layouts.app')
@section('head-content')
    <script>
        window.config = JSON.parse("@php
            use App\Models\ProductCategory;
            use Illuminate\Support\Facades\Auth;

            if (Auth::check())
            {
                $user = [
					'logged_in' => true,
					'username' => Auth::user()->name,
					'firstname' => Auth::user()->firstname,
					'lastname' => Auth::user()->lastname,
					'email' => Auth::user()->email,
                    'employeeType' => Auth::user()->employeeType,
                    'class' => Auth::user()->class,
                    'lang' => Auth::user()->lang,
                    'isAdmin' => Auth::user()->isAdmin,
                ];
            } else {
                $user = [
					'logged_in' => false,
                ];
            }

            echo str_replace('"', '\\"', json_encode([
                'categories' => ProductCategory::all()->map(function (ProductCategory $category) {
                    $icon = $category->icon;

                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'icon_name' => $icon->name,
                        'icon_url' => route('icon', $icon->id),
                    ];
                }),
                'user' => $user,
            ], JSON_THROW_ON_ERROR))
        @endphp");
    </script>
@endsection
