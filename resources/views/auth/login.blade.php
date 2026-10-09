@extends('layouts.app')

@section('title_key', 'login_title')
@section('title_text', 'چوونەژوورەوە')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <div class="page_head page_head_end">
        @include('partials.page-actions', ['showLogout' => false])
    </div>

    <section class="auth_card">
        <h1 class="brand">School</h1>

        @if ($errors->any())
            <p class="form_error" role="alert" data-i18n="login_error">ناوی بەکارهێنەر یان وشەی نهێنی هەڵەیە.</p>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="auth_form">
            @csrf
            <div class="field">
                <label for="username" data-i18n="login_username">ناوی بەکارهێنەر</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>
            </div>
            <div class="field">
                <label for="password" data-i18n="login_password">وشەی نهێنی</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <button type="submit" class="primary_btn" data-i18n="login_submit">چوونەژوورەوە</button>
        </form>
    </section>
@endsection
