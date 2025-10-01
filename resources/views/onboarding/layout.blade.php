
@extends('layouts.base')

@section('content')
<div class="max-w-4xl mx-auto p-6">
  <div class="flex justify-between items-center mb-4">
    <div class="text-sm text-gray-600">Step {{ $step }} of 6</div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="text-red-500 hover:underline">Logout</button>
    </form>
  </div>

  <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
  </div>

  <div class="bg-white shadow p-6 rounded-md">
    @yield('form')
  </div>
</div>
@endsection
