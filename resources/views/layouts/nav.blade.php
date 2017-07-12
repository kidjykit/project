<div class="blog-masthead">
      <div class="container">
        <nav class="nav blog-nav">
          <a class="nav-link active" href="/text">Home</a>
          <a class="nav-link" href="/file">File</a>
          <a class="nav-link ml-auto" href="#"></a>

            @if (Auth::guest())
                <li><a class="nav-link ml-auto"  href="{{ route('login') }}">Login</a></li>
                <li><a class="nav-link ml-auto"  href="{{ route('register') }}">Register</a></li>
            @else
                <li><a href="#" class="nav-link ml-auto" >
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a></li>
                <li><a class="nav-link ml-auto" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a></li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
            @endif
        </nav>
      </div>
    </div>