
@extends('layouts.lsuppo-base')

@section('title')
<p>ユーザーと保護者の紐づけ登録ページ</p>
@endsection
      
@section('content')
        @if ($msg !='')
        <p> {{$msg}}</p>
        @endif
        @if(count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="/fb/regist/{{$id}}" class="row g-2">
            @csrf

            <div class="col-md-12">
                <label for="validationDefaultTitle" class="form-label">タイトル</label>
                <input type="text" id="validationDefaultTitle" name="fbTitle" value="{{old('fbTitle')}}" class="form-control" required></input>
                <div class="valid-feedback">
                good!
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationDefaultDetail" class="form-label">フィードバック詳細</label>
            <!-- <input type="textarea" name="fbDetail" value="{{old('fbDetail')}}" style="width:300px; height=100px;"></input><br> -->

                <textarea id="validationDefaultDetail" name="fbDetail" value="{{old('fbDetail')}}" rows="4" class="form-control" required></textarea>
            </div>
            <div class="col-md-12">
                <label for="validationDefaultKikanFrom" class="form-label">フィードバック詳細</label>
                <div class="input-group">
                    <input type="date" id="validationDefaultKikanFrom" name="TaishoukikanFrom" class="form-control"></input>
                    <span class="input-group-text" id="inputGroupbar"> ～</span>
                    <input type="date" id="validationDefaultKikanTo" name="TaishoukikanTo" class="form-control"></input>    
                </div>
            </div>
            <div class="col-12">
                <input type="submit" name="create" value="登録" class="btn btn-primary" >
            </div>
        </form>


    <br>

@endsection