<x-app-layout>

    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    @endsection

    <x-slot name=title>FreeShare | 新規投稿</x-slot>

    <x-slot name=header>新規投稿</x-slot>

    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf
        <div class="form-item">
            <textarea name="content" class="content__area">{{ old('content') }}</textarea>
            @error('content'){{ $message }}@enderror
        </div>

        <div class="form-item">
            <label for="image" accept="image/png, image/jpeg, image/jpg">ファイルを選択</label><br>
            <input type="file" name="image" value="{{ old('image') }}">
            @error('image'){{ $message }}@enderror
        </div>
        <x-primary-button>投稿</x-primary-button>
    </form>

</x-app-layout>
