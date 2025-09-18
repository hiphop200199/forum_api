<div class="container">
    <form class="form" action="{{route('login')}}" method="post">
        @csrf
        <input type="email" required name="email"  placeholder="email" />
        <input type="password" required name="password"  placeholder="password" />
        <button type="submit">Login</button>
        <p>or</p>
        <a href="/google-login">Login By Google</a>
    </form>
</div>
