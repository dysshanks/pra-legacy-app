<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand bg-blue button" href="/" title="{{ __('misc.home_alt') }}">{{ __('misc.homepage_title') }}</a>
        </div>
        <nav class="mr-auto ml-1 flex flex-row"><a href="{{route('home')}}" class="mr-3">home</a><a href="{{route('contact')}}">contact</a></nav>
        <div id="navbar" class="form-inline">

            <script>
                (function () {
                    var cx = 'partner-pub-6236044096491918:8149652050';
                    var gcse = document.createElement('script');
                    gcse.type = 'text/javascript';
                    gcse.async = true;
                    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(gcse, s);
                })();
            </script>
            <gcse:searchbox-only></gcse:searchbox-only>


        </div><!--/.navbar-collapse -->
    </div>
</nav>
