@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card mt-3">
                    <div class="card-header">
                        Edit Discount {{ $discount->name }}
                    </div>

                    <div class="card-body overflow-scroll">
                        <form action="{{ route('admin.discount.update', $discount->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $discount->id }}" />

                            <div class="form-group mb-4">
                                <label for="inputName" class="form-label">Name</label>
                                <input name="name" id="inputName" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" value="{{ old('name') ?: $discount->name }}" requireds />
                            </div>

                            @if ($errors->has('name'))
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            @endif

                            <div class="form-group mb-4">
                                <label for="inputCode" class="form-label">Code</label>
                                <input name="code" id="inputCode" type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : ''}}" value="{{ old('code') ?: $discount->code }}" requireds />
                            </div>

                            @if ($errors->has('code'))
                                <p class="text-danger">{{ $errors->first('code') }}</p>
                            @endif

                            <div class="form-group mb-4">
                                <label for="inputDescription" class="form-label">Description</label>
                                <textarea name="description" id="inputDescription" type="text" class="form-control" cols="0" rows="2">{{ old('description') ?: $discount->description }}</textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label for="inputDiscount" class="form-label">Discount Percentage (%)</label>
                                <input name="percentage" id="inputDiscount" type="number" min="1" max="100"
                                class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" value="{{ old('percentage') ?: $discount->percentage }}" requireds />
                            </div>

                            @if ($errors->has('percentage'))
                                <p class="text-danger">{{ $errors->first('percentage') }}</p>
                            @endif

                            <div class="form-group mb-4">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
