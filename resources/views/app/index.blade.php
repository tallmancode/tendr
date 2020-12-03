@extends('layouts.base')

@section('template-css')
    <link href="{{ mix('css/front.css') }}" rel="stylesheet">
@endsection

@section('body')
    <router-view></router-view>
@endsection

@section('template-js')
    <script src="{{ mix('js/backend.js') }}"></script>
@endsection
