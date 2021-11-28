@extends('layouts.app')
@section('head-content')
    <script>
        window.config = JSON.parse("@php
            use App\Models\ProductCategory;
            use Illuminate\Support\Facades\Auth;

            $user = Auth::user();

            if (Auth::check())
            {
                $userData = [
                    'logged_in' => true,
                    'username' => $user->name,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'employeeType' => $user->employeeType,
                    'class' => $user->class,
                    'lang' => $user->lang,
                    'is_admin' => $user->is_admin,
                ];
            } else {
                $userData = [
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
                'user' => $userData,
            ], JSON_THROW_ON_ERROR))
        @endphp");
    </script>
@endsection
