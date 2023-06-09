<x-app-layout>

    <x-slot name=title>編集 / FreeShare</x-slot>

    <x-slot name=header>編集</x-slot>

    <form method="POST" action="{{ route('tweet.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-item">
            <textarea name="content" class="content__area">{{ $tweet->content }}</textarea>
            @error('content')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-item">
            <label for="image" accept="image/png, image/jpeg, image/jpg"></label><br>
            <input type="file" name="image">
            @error('image')<div class="error">{{ $message }}</div>@enderror
        </div>
        
        <!-- tweet_idを送信 -->
        <input type="hidden" name="id" value="{{ $tweet->id }}">
        <!-- user_idを送信 -->
        <input type="hidden" name="user_id" value="{{ $tweet->user_id }}">
        
        <x-primary-button onclick="updateDialog();">更新</x-primary-button>
    </form>

</x-app-layout>
