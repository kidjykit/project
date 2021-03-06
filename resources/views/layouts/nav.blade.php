<div class="blog-masthead">
      <div class="container">
          <script>
              $(function() {
                  if ((location.pathname.split("/")[1]) !== ""){
                      $('nav a[href^="/' + location.pathname.split("/")[1] + '"]').addClass('active');
                  }
                  else {
                      $('nav a[href^="/text"]').addClass('active');
                  }
              });
          </script>
        <nav class="nav blog-nav">
          <!-- <a class="nav-link" href="/text">Text</a>
          <a class="nav-link" href="/file">File</a> -->
          <a class="nav-link" href="/modal">TextVis</a>
          <!-- <a class="nav-link" href="/allvis">AllVis</a> -->
          <a class="nav-link" href="/apiview">API</a>
          <a class="nav-link" href="/apidoc">DOC API</a>
          <a class="nav-link ml-auto" href="#"></a>

            @if (Auth::guest())
                <li><a class="nav-link ml-auto"  href="/login">Login</a></li>
                <li><a class="nav-link ml-auto"  href="/register">Register</a></li>
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
                                <input type="hidden" name="logout" value="1">
                            </form>
            @endif
        </nav>
      </div>
</div>
