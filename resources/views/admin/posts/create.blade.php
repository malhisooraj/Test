<x-layout>
    <section class="py-8 max-w-4xl mx-auto">
        <h1 class="text-lg font-bold mb-8 pb-2 border-b">
            Publish New Post
        </h1>

        <div class="flex">
            <aside class="w-48 flex-shrink-0">
                <h4 class="font-semibold mb-4">Links</h4>

                <ul>
                    <li>
                        <a href="/admin/posts" class="{{ request()->is('admin/posts') ? 'text-blue-500' : '' }}">All Posts</a>
                    </li>

                    <li>
                        <a href="/admin/posts/create" class="{{ request()->is('admin/posts/create') ? 'text-blue-500' : '' }}">New Post</a>
                    </li>
                </ul>
            </aside>

            <main class="flex-1">
                <div class="border border-gray-200 p-6 rounded-xl">
                    <form method="POST" action="/admin/posts" enctype="multipart/form-data">
                        @csrf

                        <x-form.input name="title" required />
                        <x-form.input name="slug" required />
                        <x-form.input name="thumbnail" type="file" required />
                        <x-form.textarea name="excerpt" required />
                        <x-form.textarea name="body" required />

                        <x-form.field>
                            <x-form.label name="status"/>

                            <select name="status" id="status" required>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected': '' }}>Draft</option>
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected': '' }}>Published</option>
                            </select>

                            <x-form.error name="status"/>
                        </x-form.field>

                        <x-form.field>
                            <x-form.label name="category"/>

                            <select name="category_id" id="category_id" required>
                                @foreach (\App\Models\Category::all() as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >{{ ucwords($category->name) }}</option>
                                @endforeach
                            </select>

                            <x-form.error name="category"/>
                        </x-form.field>

                        <x-form.button>Publish</x-form.button>
                    </form>
                </div>
            </main>
        </div>
    </section>
</x-layout>
