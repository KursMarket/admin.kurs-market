<div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
        <ol class="breadcrumb">
            @isset($breadcrumbs)
                @foreach($breadcrumbs as $breadcrumb)
                    @if($breadcrumb['url'])
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                    @else
                        <li class="breadcrumb-item">{{ $breadcrumb['title'] }}</li>
                    @endif
                @endforeach
            @endisset
        </ol>

    </nav>
</div><!-- End Page Title -->
