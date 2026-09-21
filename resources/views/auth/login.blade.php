<h1>ログイン</h1>

<form action="/login" method="post">
    @csrf

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

    <button type="submit">ログイン</button>

</form>