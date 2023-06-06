<x-app-layout>

    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/top.css') }}">
    @endsection

    <x-slot name=header>Home</x-slot>

    <div class="tweet">
        @foreach ($tweets as $tweet)
            <div class="tweet-container">
                <div class="user-name">{{ $tweet->user->name }}</div>
                <div class="tweet-content">{{ $tweet->content }}</div>
                @if ($tweet->image)
                    <img src="../../storage/{{ $tweet->image }}" alt="投稿画像" class="tweet-image">
                @endif
                <div class="tweet-date">{{ $tweet->created_at }}</div>

                <x-primary-button>いいね</x-primary-button>
                <x-primary-button>投稿</x-primary-button>
            </div>
        @endforeach
    </div>

</x-app-layout>
