@extends('layouts.app')
@section('head-content')
    <script>
        window.config = JSON.parse("@php
        use App\Models\ProductCategory;
        use Illuminate\Support\Facades\Auth;

        $user = Auth::user();

        if (Auth::check()) {
            $userData = [
                'isLoggedIn' => true,
                'name' => $user->name,
                'username' => $user->username,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'employeeType' => $user->employeeType,
                'class' => $user->class,
                'lang' => $user->lang,
                'isAdmin' => $user->is_admin,
            ];
        } else {
            $userData = [
                'isLoggedIn' => false,
            ];
        }

        echo str_replace(
            '"',
            '\\"',
            json_encode(
                [
                    'categories' => ProductCategory::nonEmpty()
                        ->get()
                        ->map(function (ProductCategory $category) {
                            $icon = $category->icon;

                            return [
                                'id' => $category->id,
                                'name' => $category->name,
                                'icon_name' => $icon->name,
                                'icon_url' => route('icon', $icon->id),
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
