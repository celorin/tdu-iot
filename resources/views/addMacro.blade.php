@extends('layouts.app')
@section('content')
    <div>
        <h3>ボタン一覧</h3>
        @foreach($devices as $device)
            <h4>{{$device->name}}</h4>
            @foreach($device->button as $button)
                {{$button->name}}<button onclick="add('{{$button->id}}','{{$button->name}}')">追加</button>
                <br>
            @endforeach
        @endforeach
        <hr>
        <label>マクロ名：
            <input type="text" name="macro_name">
        </label>
        <h3>実行リスト</h3>
        <div id="order-list"></div>
        <button onclick="send()">マクロ作成</button>
    </div>
    <script type="text/javascript">
        let calls = [];//呼び出し順に配列に格納

        function add(buttonId,buttonName) {
            calls.push({buttonId:buttonId,buttonName:buttonName});
            updateElement();
        }
        function remove(index) {
            calls.splice(index, 1);
            updateElement();
        }
        function updateElement() {
            let body = "";
            calls.forEach((items,index)=>{
                body = body + "<div>"+(index+1)+" : "+items.buttonName+"<button onclick='remove("+index+")'>remove</button>"+"</div>";
                // console.log(calls);
            });
            document.getElementById('order-list').innerHTML = body;
        }
        function send() {
            let send = [];
            calls.forEach((items,index)=>{
                send.push({number:index,buttonId:items.buttonId,buttonName:items.buttonName})
            });

            let csrf = document.getElementsByName('csrf-token').item(0).content;
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    console.log(this.responseText);
                } else if (this.readyState === 4) {
                    console.error(this.responseText);
                }
            };
            xhr.open('POST', '{{ Request::root()}}/macro/add');
            xhr.setRequestHeader( 'Content-Type', 'application/json');
            xhr.setRequestHeader( 'X-CSRF-Token', csrf );
            xhr.send(JSON.stringify(send));
            // console.log(JSON.stringify(calls));
        }
    </script>

    {{--    <div id="app">--}}
    {{--        <example-component></example-component>--}}
    {{--    </div>--}}

@endsection
