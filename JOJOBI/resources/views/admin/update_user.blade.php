@extends('admin.layout')

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .text_cat {
        margin-bottom: 20px;
        text-align: center;
        font-weight: 700;
        font-size: 24px;
        color: #ddd;
    }

    form {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
        background-color: #2d3035;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #ddd;
    }

    .form-group input {
        width: calc(100% - 22px);
        height: 40px;
        padding: 0 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #3a3f44;
        color: #fff;
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .form-group input[type="checkbox"] {
        width: auto;
        height: auto;
    }
</style>

@section('content')
<div class="container">
    <h1 class="text_cat">Edit User</h1>

    <!-- Edit User Form -->
    <form action="{{ route('admin.user.edit', $data->uuid) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">User Name</label>
            <input id="name" type="text" name="name" value="{{ $data->name }}" required autofocus autocomplete="name" />
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ $data->email }}" required autocomplete="email" />
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input id="phone" type="text" name="phone" value="{{ $data->phone }}" required autocomplete="phone" />
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input id="address" type="text" name="address" value="{{ $data->address }}" required autocomplete="address" />
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="usertype">User Type</label>
            <input id="usertype" type="text" name="usertype" value="{{ $data->usertype }}" required autocomplete="usertype" />
            @if ($errors->has('usertype'))
                <span class="text-danger">{{ $errors->first('usertype') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="blocked">Blocked</label>
            <input id="blocked" type="checkbox" name="blocked" {{ $data->blocked ? 'checked' : '' }} />
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">Update User</button>
        </div>
    </form>
</div>
@endsection
