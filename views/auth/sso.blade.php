<div>
    @if (config('base.hybridauth.enabled'))
        <div class="text-center">
            @if (config('base.hybridauth.facebook.enabled'))
                <a href="{{route('social-auth', 'facebook')}}" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="la la-facebook"></span></a>
            @endif
            @if (config('base.hybridauth.twitter.enabled'))
                <a href="{{route('social-auth', 'twitter')}}" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="la la-twitter"></span></a>
            @endif
            @if (config('base.hybridauth.google.enabled'))
                <a href="{{route('social-auth', 'google')}}" class="btn btn-social-icon mr-1 mb-1 btn-outline-google"><span class="la la-google font-medium-4"></span></a>
            @endif
        </div>
    @endif
</div>