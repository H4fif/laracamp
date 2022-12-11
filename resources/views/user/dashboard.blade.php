@extends('layouts.app')

@section('content')
    <section class="dashboard my-5">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        My Bootcamps
                    </h2>
                </div>
            </div>
            <div class="row my-5">
                @include('components.alert')

                <table class="table">
                    <tbody>
                        @forelse ($checkouts as $checkout)
                            <tr class="align-middle">
                                <td width="18%">
                                    <img src="{{ asset('images/item_bootcamp.png') }}" height="120" alt="">
                                </td>
                                <td>
                                    <p class="mb-2">
                                        <strong>{{ $checkout->camp->title }}</strong>
                                    </p>
                                    <p>
                                        {{ $checkout->created_at->format('F d, Y') }}
                                    </p>
                                </td>
                                <td>
                                    <strong>${{ number_format($checkout->camp->price, 0) }}k </strong>
                                </td>
                                <td>
                                    <b>{{ $checkout->payment_status }}</b>
                                </td>
                                <td>
                                    @if ($checkout->payment_status == 'waiting')
                                        <a href="{{ $checkout->midtrans_url }}" class="btn btn-primary">Pay Here</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="https://wa.me/08xxx?text=Hai, Saya ingin bertanya tentang kelas {{ $checkout->camp->title }}"
                                        class="btn btn-primary">
                                        Get Invoice
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr colspan="5">
                                <td>No camp registered</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
