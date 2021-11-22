@extends('layouts.app')
@section('head-content')
    <script>
        window.config.categories = {{ json_encode(\App\Models\ProductCategory::all()->toArray()) }}
    </script>
@endsection
