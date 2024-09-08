<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}


        </h2>



    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            {{-- Step 1: Create the Subscription Form --}}
            <form action="{{ route('subscribe') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>


            <!-- Create Post Form -->
            <div style="border: 3px solid black;">
                <h2>Create a New Post</h2>
                <form action="/create-post" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Post title" required>
                    <textarea name="body" placeholder="Body content..." required></textarea>

                    <!-- Dropdown for Category -->
                    <select id="category_id_select" required onchange="updateCategoryInput()">

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                    <input type="hidden" id="category_id" name="category_id" value="">
                    <!-- Automatically include the authenticated user's ID -->

                    @if (auth()->check())
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    @else
                        <p>You need to be logged in to create a post.</p>
                    @endif


                    <button type="submit">Save Post</button>
                </form>
            </div>

            <!-- Display Posts -->
            <div style="border: 3px solid black;">
                <h2>All Posts</h2>
                @foreach ($posts as $post)
                    <div style="background-color: gray; padding: 10px; margin: 10px;">
                        <h3>{{ $post->title }} by {{ $post->user->name }}</h3>
                        <p>{{ $post->body }}</p>
                        <p><a href="/edit-post/{{ $post->id }}">Edit</a></p>
                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button>Delete</button>
                        </form>
                    </div>
                @endforeach

                <!-- Pagination Links -->
                {{ $posts->links() }}
                {{-- @if ($posts->appends(request()->except(['page', '_token']))->links() != '')
        <div>
            {{ $section->appends(request()->except(['page', '_token']))->links() }}
    @endif --}}
            </div>
            <script>
                function updateCategoryInput() {

                    var select = document.getElementById('category_id_select');
                    //  var selectedOption = select.options[select.selectedIndex];
                    //var info = selectedOption.getAttribute('data-info');
                    var info = select.value;
                    console.log(info);
                    document.getElementById('category_id').value = info;
                }
            </script>

        </div>
    </div>
</x-app-layout>
