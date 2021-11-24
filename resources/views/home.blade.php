@extends('layouts.app')
@section('head-content')
    <script>
        window.config = JSON.parse("@php
            use App\Models\ProductCategory;
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
            ], JSON_THROW_ON_ERROR))
        @endphp");
    </script>
@endsection
