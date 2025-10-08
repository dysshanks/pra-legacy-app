<x-layouts.app>
    <x-slot:breadcrumb>
        <li><a href="{{ route('categories.index') }}">Categories</a></li>
        <li>{{ $category->name }}</li>
    </x-slot:breadcrumb>

    <h1>{{ $category->name }} Brands</h1>
    <ul>
        @foreach($category->brands as $brand)
            <li>
                <a href="/{{ $brand->id }}/{{ $brand->getNameUrlEncodedAttribute() }}/">{{ $brand->name }}</a>
            </li>
        @endforeach
    </ul>
</x-layouts.app>
