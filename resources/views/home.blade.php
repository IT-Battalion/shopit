@extends('layouts.app')
@section('head-content')
    <script>
        window.config = JSON.parse("<?php
            echo str_replace('"', '\\"', json_encode([
                'categories' => \App\Models\ProductCategory::all()->map(function (\App\Models\ProductCategory $category) {
                    $icon = $category->icon;

                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'icon_name' => $icon->name,
                        'icon_url' => route('icon', $icon->id),
                    ];
                }),
            ]))
        ?>");
    </script>
@endsection
