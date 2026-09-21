@extends('layouts.app')

@section('content')

    <h1>会員登録</h1>

    <form action="/register" method="post">
    @csrf

    <div>
    <label for="name">お名前</label>
    <input type="text" name="name" id="name">
    
    @error('name')
    <p>{{ $message }}</p>
    @enderror

</div>

<div>
    <label for="email">メールアドレス</label>
    <input type="email" name="email" id="email">

    @error('email')
    <p>{{ $message }}</p>
    @enderror

</div>

<div>
    <label for="password">パスワード</label>
    <input type="password" name="password" id="password">

    @error('password')
    <p>{{ $message }}</p>
    @enderror

</div>

<div>
    <label for="password_confirmation">パスワード確認</label>
    <input
        type="password"
        name="password_confirmation"
        id="password_confirmation"
    >
</div>

<button type="submit">登録する</button>

</form>

@endsection