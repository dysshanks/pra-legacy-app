<x-layouts.app>

    <x-slot:breadcrumb>
        <li><a href="/{{ $brand->id }}/{{ $brand->name_url_encoded }}/" alt="Manuals for '{{$brand->name}}'" title="Manuals for '{{$brand->name}}'">{{ $brand->name }}</a></li>
    </x-slot:breadcrumb>

    <h1>{{ $brand->name }}</h1>

    <p>{{ __('introduction_texts.type_list', ['brand'=>$brand->name]) }}</p>

        <div class="container grid grid-gap grid-row-5">
            @foreach($types as $type)
                <a href="/{{ $brand->id }}/{{ $brand->name_url_encoded }}/{{ $type->id }}/{{ $type->name_url_encoded }}/" class="d-inline">{{ $type->name }}</a>
            @endforeach
        </div>

</x-layouts.app>
