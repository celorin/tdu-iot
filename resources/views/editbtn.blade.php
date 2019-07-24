@extends('layouts.app')
<link href="{{ asset('css/editbutton.css') }}" rel="stylesheet">
@section('content')
    <div class="button_edit">
        <form method="POST" action="{{ action('EditButtonController@editButton', ['id'=>$button_id])}}">
            @csrf
            <p>ボタン名の変更</p>
            <p>新しい名前</p>
            <input type="text" name="new_name" class="new_botton_name" required><br><br>
            <input type="submit" class="button" value="決定"><br><br>
        </form>
        <form method="POST" action="{{ action('EditButtonController@deleteButton',['id' => $button_id]) }}">
            @csrf
            @method('delete')
            <hr>
            <p>ボタンの削除</p>
            <p>ボタンを削除しますか</p>
            @method('delete')
            <input type="submit" class="button" value="はい"> <input type="button" class="button" value="いいえ" onclick="location.href='{{url('/')}}'"><br><br>
        </form>
    </div>
@endsection