
@extends('layouts.lsuppo-base')

@section('title')
エルコイン登録ページ
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
        <form method="POST" action="/lc/regist/" class="row g-2">
            @csrf

            <div class="col-md-3">
                <label for="StudentCd" class="form-label">生徒コード</label>
                <select class="form-select" id="StudentCd" name="StudentCd">
                @foreach($students as $student)
                    <option value="{{$student->StudentCd}}" @if(old('StudentCd')==$student->StudentCd) selected @endif >{{$student->getCdName()}}</option>
                @endforeach
                </select>
                <div class="valid-feedback">
                good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="HasseiDate" class="form-label">発生日</label>
                <input type="date" id="HasseiDate" name="HasseiDate" class="form-control" required></input>
            </div>
            <div class="col-md-12">
                <label for="ZiyuuCd" class="form-label">事由</label>
                <select class="form-select" id="ZiyuuCd" name="ZiyuuCd">
                @foreach($ziyuus as $ziyuu)
                    <option value="{{$ziyuu->ZiyuuCd}}" @if(old('ZiyuuCd')==$ziyuu->ZiyuuCd) selected @endif >{{$ziyuu->getCdName()}}</option>
                @endforeach
                </select>
                <div class="valid-feedback">
                good!
                </div>
            </div>
            <div class="col-md-12">
                <label for="ZiyuuHosoku" class="form-label">事由補足</label>
                <input type="text" id="ZiyuuHosoku" name="ZiyuuHosoku" value="{{old('ZiyuuHosoku')}}" class="form-control" required></input>
                <div class="valid-feedback">
                good!
                </div>
            </div>
            <div class="col-md-12">
                <label for="amount" class="form-label">コイン数量　※減額の場合はマイナスで入力</label>
                <input type="number" id="amount" name="amount" value="{{old('amount')}}" class="form-control" required></input>
                <div class="valid-feedback">
                good!
                </div>
            </div>
            <div class="col-md-12">
                <label for="TourokuSupporterCd" class="form-label">登録サポーターコード</label>
                <input type="text" id="TourokuSupporterCd" name="TourokuSupporterCd" value="{{$TourokuSupporterCd}}" class="form-control" readonly></input>
                <div class="valid-feedback">
                good!
                </div>
            </div>
            <div class="col-12">
                <input type="submit" name="create" value="登録" class="btn btn-primary" >
            </div>
        </form>


    <br>

@endsection