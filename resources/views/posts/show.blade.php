<x-layout>
    @include('posts-header')

    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        <x-post-card :post="$post"/>

        <!-- Comment form -->
        @auth
            <form method="POST" action="/posts/{{ $post->slug }}/comments">
                @csrf

                <header class="flex items-center">
                    <img src="https://i.pravatar.cc/60?u={{ auth()->id() }}"
                         alt=""
                         width="40"
                         height="40"
                         class="rounded-full">

                    <h2 class="ml-4">Want to participate?</h2>
                </header>

                <div class="mt-6">
                    <textarea
                        name="body"
                        class="w-full text-sm focus:outline-none focus:ring"
                        rows="5"
                        placeholder="Quick, thing of something to say!"
                        required>
                    </textarea>

                    @error('body')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
                    <button type="submit"
                            class="bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-10 rounded-2xl hover:bg-blue-600"
                    >
                        Post
                    </button>
                </div>
            </form>
        @else
            <p class="font-semibold">
                <a href="/register" class="hover:underline">Register</a> or
                <a href="/login" class="hover:underline">log in</a> to leave a comment.
            </p>
        @endauth
        <!-- Comment form end -->

        <!-- Comment Section view -->
        <section class="col-span-8 col-start-5 mt-10 space-y-6">
            @foreach ($post->comments as $comment)
                <article class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <img src="https://i.pravatar.cc/60?u={{ $comment->user_id }}" alt="" width="60" height="60" class="rounded-xl">
                    </div>

                    <div>
                        <header class="mb-4">
                            <h3 class="font-bold">{{ $comment->author->username }}</h3>

                            <p class="text-xs">
                                Posted
                                <time>{{ $comment->created_at->format('F j, Y, g:i a') }}</time>
                            </p>
                        </header>

                        <p>
                            {{ $comment->body }}
                        </p>
                    </div>
                </article>
            @endforeach
        </section>
    </main>

</x-layout>

