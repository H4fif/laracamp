@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        My Camps
                    </div>

                    <div class="card-body overflow-scroll">
                        @include('components.alert')

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Camp</th>
                                    <th>Price</th>
                                    <th>Register Data</th>
                                    <th>Paid Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($checkouts as $checkout)
                                    <tr>
                                        <td>{{ $checkout->user->name }}</td>
                                        <td>{{ $checkout->camp->title }}</td>
                                        <td>{{ $checkout->camp->price }}</td>
                                        <td>{{ $checkout->created_at->format('M d Y') }}</td>

                                        <td>
                                            <b>{{ $checkout->payment_status }}</b>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No camps registered</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
