@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center">
        <div class="w-4/6 my-6"> 
            <form action="{{route('image.process')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for=""> Email </label>
                    <input type="email" name="email" class="p-2 mt-3 border-2 w-full">
                </div>

                <div class="form-group my-4">
                    <label for=""> Image </label>
                    <input type="file" name="image" class="p-2 mt-3 border-2 w-full">
                </div>

                <button type="save" class="bg-blue-800 text-white py-2 px-4"> Save </button>
            </form>
        </div>
    </div>
@endsection