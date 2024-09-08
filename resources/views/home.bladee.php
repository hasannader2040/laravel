<!DOCTYPE html>
<html lang="en">

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <!-- Subscription Form -->
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

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
        function updateHiddenInput() {
            var select = document.getElementById('category_id_select');
            var selectedOption = select.options[select.selectedIndex];
            var info = selectedOption.getAttribute('data-info');
            document.getElementById('category_id').value = info;
        }
    </script>

</body>


</html>
