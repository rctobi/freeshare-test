<x-app-layout>

    <x-slot name=title>{{ $tweet->user->name }} on FreeShare: "{{ $tweet->content }}" / FreeShare</x-slot>

    <style>
        .tweet-container:hover {
            background: inherit;
        }
    </style>

    <x-slot name=header>投稿詳細</x-slot>

    <div class="tweet">
        <div class="tweet-container">
            <div class="user-name">{{ $tweet->user->name }}</div>
            <div class="tweet-content">{{ $tweet->content }}</div>
            @if ($tweet->image)
                <img src="{{ asset('storage/' . $tweet->image) }}" alt="投稿画像" class="tweet-image" onclick="showModal(this)">
            @endif
            <!-- モーダル表示 -->
            <div id="modal" class="modal" onclick="hideModal()">
                <img src="{{ asset('storage/' . $tweet->image) }}" alt="投稿画像" class="modal-image">
            </div>

            <div class="tweet-date">{{ $tweet->updated_at }}</div>
            <x-primary-button>イイネ&nbsp;<img src="{{ asset('images/good_icon.png') }}" alt=""></x-primary-button>
            <x-primary-button>シェア&nbsp;<img src="{{ asset('images/share_icon.png') }}" alt=""></x-primary-button>

            @if ($tweet->user_id == Auth::id())
                <div class="tweet_menu">
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    @auth
                                        <img src="{{ asset('images/3dot.png') }}" alt="3点リーダー">
                                    @endauth
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('tweet.edit', $tweet->id)">
                                    {{ __('編集') }}
                                </x-dropdown-link>
                                <form id="delete-form" method="POST" action="{{ route('tweet.destroy', $tweet->id) }}">
                                    @csrf
                                    <x-dropdown-link href="javascript:void(0);" onclick="deleteDialog(); event.preventDefault(); document.getElementById('delete-form').submit();">
                                        {{ __('削除') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- コメント一覧 -->
    @auth
        <div class="comment-container">
            <!-- コメント投稿フォーム -->
            <div class="comment-form">
                <h2 class="comment-title">コメント投稿</h2>
                <form method="post" action="{{ route('comment.store') }}">
                    @csrf

                    <textarea name="content" class="comment-text" placeholder="コメントを投稿してみよう">{{ old('content') }}</textarea>
                    @error('content'){{ $message }}@enderror

                    <x-primary-button onclick="storeDialog();">投稿</x-primary-button>

                    <!-- tweet_idを送信 -->
                    <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                    <!-- user_idを送信 -->
                    <input type="hidden" name="user_id" value="{{ $tweet->user_id }}">
                </form>
            </div>

            <!-- コメント一覧 -->
            <h2 class="comment-title">コメント一覧</h2>
            <div class="comment-lists">
                @foreach ($comments as $comment)
                    <div class="comment-list">
                        <div class="comment-user">{{ $comment->user->name }}</div>
                        <div class="comment-content">{{ $comment->content }}</div>
                        <!-- 削除ボタン -->
                        <form id="delete-form" method="POST" action="{{ route('comment.destroy') }}">
                            @csrf

                            <div class="comment_menu">
                                <button href="javascript:void(0);" onclick="deleteDialog();">
                                    削除
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endauth

</x-app-layout>
