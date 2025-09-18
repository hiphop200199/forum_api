<div class="header">
    <div class="links">
        @if (!empty($_SESSION['user']))
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">logout</button>
        </form>
        @else
            <a href="/login">login</a>
        @endif
    </div>
</div>
<div class="container">
    @php
        if (!empty($_SESSION['user'])) {
            $name = $_SESSION['name'];
            echo "<h1>Hi! $name</h1>";
        } else {
            echo '<h1>Home.</h1>';
        }
    @endphp
</div>
