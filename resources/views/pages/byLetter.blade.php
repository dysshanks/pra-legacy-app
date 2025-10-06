<x-layouts.app>
    @section('content')
        <h1>Merken die beginnen met {{ $letter }}</h1>

        <ul>
            @forelse($brands as $brand)
                <li>
                    <a href="{{ url('/' . $brand->id . '/' . $brand->slug . '/') }}">
                        {{ $brand->name }}
                    </a>
                </li>
            @empty
                <li>Geen merken gevonden voor deze letter.</li>
            @endforelse
        </ul>
    @endsection

</x-layouts.app>
