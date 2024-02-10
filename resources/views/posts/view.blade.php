<x-layout>
    @include('posts-header')

    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">

        <!--div class="lg:grid lg:grid-cols-2">
            <x-post-card />
        </div-->
        <div class="lg:grid lg:grid-cols-3">
            <x-post-card :post="$post"/>

        </div>
    </main>
</x-layout>

