<x-app-layout>

    <x-slot name=title>投稿 / FreeShare</x-slot>

    <x-slot name=header>投稿</x-slot>

    <form method="POST" action="{{ route('tweet.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-item">
            <textarea name="content" class="content__area">{{ old('content') }}</textarea>
            @error('content')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-item">
            <label for="image" accept="image/png, image/jpeg, image/jpg"></label><br>
            <input type="file" name="image" value="{{ old('image') }}">
            @error('image')<div class="error">{{ $message }}</div>@enderror
        </div>
        
        <!-- user_id 送信 -->
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        
        <x-primary-button onclick="storeDialog">投稿</x-primary-button>
    </form>

</x-app-layout>
