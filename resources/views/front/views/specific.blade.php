@extends('front.layouts.app')
@section('title', 'specific-page')
@section('content')

<section class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#FCF7F1] overflow-x-hidden pb-4">
    <div class="header flex flex-col bg-[#FA9852] rounded-b-[50px] overflow-hidden h-[320px] -mb-[181px]">
        <nav class="pt-5 px-3 flex justify-between items-center">
            <div class="flex items-center gap-[10px]">
                <a href="{{ route('front.index') }}" class="w-10 h-10 flex shrink-0">
                    <img src="{{ asset('assets/images/icons/back-pet.svg')}}" alt="icon">
                </a>
            </div>
            <p class="font-semibold text-sm text-white">Daftar Kategori</p>
            <a href="" class="w-10 h-10 flex shrink-0">
            </a>
        </nav>
    </div>
    <div class="flex flex-col gap-4 px-4">

        @forelse($categories as $category)
        <a href="{{ route('front.category', $category) }}" class="card">
            <div class="w-full flex items-center p-[14px] gap-3 rounded-2xl bg-white">
                <div class="w-[80px] h-[90px] flex shrink-0 rounded-2xl overflow-hidden">
                    <img src="{{Storage::url($category->icon)}}" class="w-full h-full object-cover" alt="thumbnail">
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-\[48px\] line-clamp-1 hover:line-clamp-none">{{ $category->name }}</p>
                </div>
            </div>
        </a>
        @empty
        <p>Belum ada data tersedia.</p>
        @endforelse

    </div>
</section>

@endsection
