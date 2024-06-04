
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>


<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>




@extends('Layouts.authentication')

@section('content')
<div class="container mt-5 mb-5">
    <div class="text-right">

    <a href="/addproduct" class="btn btn-primary mt-5 mb-5 w-50">
        <i class="fas fa-plus"></i>{{ __('string.addProduct') }}</a>
    </div>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->quantity}}</td>
            <td><img src="{{$item->imagepath}}" width="100" height="100" /></td>

            <td><a href="/removeproduct/{{$item->id}}" class="btn btn-danger">
                <i class="fas fa-trash"></i>{{ __('string.delete') }}</a>

                <a href="/editproduct/{{$item->id}}" class="btn btn-success">
                    <i class="fas fa-edit"></i>{{ __('string.edit') }}</a>

                    <a href="/AddProductImages/{{$item->id}}" class="btn btn-dark">
                        <i class="fas fa-image"></i> اضافة صور المنتج</a>

                    </td>
        </tr>
        @endforeach


    </tbody>
</table>
</div>

@endsection

<script>
    $(document).ready( function () {
        let table = new DataTable('#myTable');
} );
</script>
