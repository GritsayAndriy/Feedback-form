@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(isset($successfully))
                            <div class="alert alert-success" role="alert">
                                {{$successfully}}
                            </div>
                        @endif

                        @role('manager')
                        @if(isset($orders))
                            <ul>
                                @foreach($orders as $order)
                                    <li>{{$order->user->name}}</li>
                                @endforeach
                            </ul>
                        @endif
                        @endrole

                        @role('customer')
                        <form method="POST" action="{{route('home.form')}}">
                            <div class="form-group">
                                @csrf
                                <div class="col-lg-6">
                                    <label for="subject">Subject</label>
                                    <input id="subject" name="subject" type="text"
                                           class="form-control @error('subject') is-invalid @enderror">
                                </div>
                                <div class="col-lg-6">
                                    <label for="message">Message</label>
                                    <textarea id="message" name="message"
                                              class=" form-control @error('message') is-invalid @enderror"></textarea>
                                </div>
                                <div class="col-lg-6 my-1">
                                    <input type="file" name="file_link">
                                </div>
                                <div class="col-lg-6 my-1">
                                    <input type="submit" class="btn btn-primary">
                                </div>
                                @error('repetition')
                                <div class="col-lg-6 my-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </form>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
