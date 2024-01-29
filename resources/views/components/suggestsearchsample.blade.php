<!-- https://www.laravelia.com/post/laravel-10-autocomplete-search-from-database -->

@extends('layouts.app')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Laravel 10 jQuery Autocomplete Search Example - Laravelia</div>
                 <div class="card-body">
                    <form action="{{ route('index') }}" method="get">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3" placeholder="search" name="q" id="searchUser">
                                <span id="userList"></span>
                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="form-control mb-3" value="Search">
                            </div>
                        </div>
                    </form>
                    <table style="width: 100%">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->status == 'active' ? 'Active' : 'Inactive'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <center class="mt-5">
                        {{  $users->withQueryString()->links() }}
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
 <script type="text/javascript">
    var path = "{{ route('index') }}";
    $( "#searchUser" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function(data) {
               response(data);
            }
          });
        },
        select: function (event, ui) {
           $('#searchUser').val(ui.item.label);
           return false;
        }
      });
</script>
@endpush