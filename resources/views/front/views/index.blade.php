@extends('front.layouts.app')
@section('title', 'index-page')
@section('content')

<section class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-white overflow-x-hidden pb-[134px]">
    {{-- komponen untuk pewarnaan gradien --}}
    <div class="header flex flex-col bg-[#FEFEFF] rounded-b-[50px] overflow-hidden">
        {{-- nav login dan register --}}
        <nav class="pt-5 px-3 flex justify-between items-center">  
            <div class="flex items-center gap-[10px]">
                <div class="w-10 h-10 flex shrink-0">
                    <a href="{{ route('register') }}" class="w-10 h-10 flex shrink-0">
                        <img src="{{asset('assets/images/icons/menu-pet.svg')}}" alt="icon">
                    </a>
                </div>
                <div class="flex flex-col text-black">
                    <p class="font-semibold text-sm">Login/Register</p>
                </div>
            </div>
        </nav>
        <div class="my-[50px] z-10">
            <h1 class="font-extrabold text-2xl leading-[48px] text-primary-700 text-black text-center drop-shadow-lg">PawCare</h1>
        </div>
        <div class="mt-[30px] z-10">
            <h2 class="font-bold text-1xl leading-[24px] text-black text-center">Berbagi Kebaikan.<br>Salurkan Kebahagiaan.</h2>
        </div>
        <div class="w-full h-fit overflow-hidden -mt-[33px]">
            <img src="{{asset('assets/images/backgrounds/pet-background.png')}}" class="w-full h-full object-contain" alt="background">
        </div>
    </div>
    <div id="popular-fundrising" class="mt-8">
        <div class="px-4 flex justify-between items-center">
            <h2 class="font-bold text-lg">Kategori <br>Bantuan</h2>
            <a href="{{ route('front.specific')  }}" class="p-[6px_12px] rounded-full bg-[#E8E9EE] font-semibold text-sm">Lihat Semua</a>
        </div>
        <div class="main-carousel mt-[14px]">

            @foreach($categories as $category)
            <div class="px-2 first-of-type:pl-4 last-of-type:pr-4">
                <a href="{{ route('front.category', $category) }}" class="fundrising-card bg-[#2F9297] rounded-[30px] w-[135px] min-h-[160px] flex flex-col items-center gap-3 p-5 border border-[#E8E9EE]">
                    <div class="w-[60px] h-[60px] flex shrink-0 overflow-hidden">
                        <img src="{{ Storage::url($category->icon)}}" alt="icon">
                    </div>
                    <span class="font-semibold text-center my-auto text-white">{{ $category->name }}</span>
                </a>
            </div>
            @endforeach

        </div>
    </div>
    <div id="best-choices" class="mt-8 -mb-6">
        <div class="px-4 flex justify-between items-center">
            <h2 class="font-bold text-lg">Penggalangan Dana <br>Favorite</h2>
            <a href="{{ route('front.specific-fund') }}" class="p-[6px_12px] rounded-full bg-[#E8E9EE] font-semibold text-sm">Lihat Semua</a>
        </div>
        <div class="main-carousel mt-[14px]">

            @forelse($fundraisings as $fundraising)
            <div class="px-2 first-of-type:pl-4 last-of-type:pr-4 mb-6">
                <div class="flex flex-col gap-[14px] rounded-2xl border bg-[#2F9297] border-[#E8E9EE] p-[14px] w-[208px]">
                    <a href="{{ route('front.details', $fundraising) }}">
                        <div class="rounded-2xl w-full h-[120px] flex shrink-0 overflow-hidden">
                            <img src="{{Storage::url($fundraising->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnail">
                        </div>
                    </a>
                    <div class="flex flex-col gap-[6px]">
                        <a href="{{ route('front.details', $fundraising) }}" class="font-bold line-clamp-2 hover:line-clamp-none text-white">{{ $fundraising->name }}</a>
                        <p class="text-xs text-white leading-[18px]">Target <span class="font-bold text-white">Rp {{ number_format($fundraising->target_amount, 0, ',','.') }}</span></p>
                    </div>
                    <progress id="fund" value="{{ $fundraising->getPercentageAttribute() }}" max="100" class="w-full h-[6px] rounded-full overflow-hidden "></progress>
                </div>
            </div>
            @empty
            <p>Belum ada data tersedia.</p>
            @endforelse

        </div>
    </div>  
    <div id="latest-fundrising" class="mt-8">
        <div class="px-4 flex justify-between items-center">
            <h2 class="font-bold text-lg">Penggalangan Dana <br>Terbaru</h2>
            <a href="{{ route('front.specific-fund') }}" class="p-[6px_12px] rounded-full bg-[#E8E9EE] font-semibold text-sm">Lihat Semua</a>
        </div>
        <div class="flex flex-col gap-4 mt-[14px] px-4">

            @forelse($fundraisings as $fundraising)
            <a href="{{ route('front.details', $fundraising) }}" class="card">
                <div class="w-full border bg-[#2F9297] border-[#E8E9EE] flex items-center p-[14px] gap-3 rounded-2xl ">
                    <div class="w-20 h-[90px] flex shrink-0 rounded-2xl overflow-hidden">
                        <img src="{{Storage::url($fundraising->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnail">
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="font-bold line-clamp-1 text-white hover:line-clamp-none">{{ $fundraising->name }}</p>
                        <p class="text-xs text-white leading-[18px]">Target <span class="font-bold text-white">Rp {{ number_format($fundraising->target_amount, 0, ',','.') }}</span></p>
                        <div class="flex items-center gap-1 sm:flex-row-reverse sm:justify-end">
                            <p class="font-semibold sm:font-medium text-xs text-white leading-[18px]">{{ $fundraising->fundraiser->user->name }}</p>
                            <div class="flex shrink-0">
                                <img src="{{asset('assets/images/icons/tick-circle.svg')}}" alt="icon">
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <p>Belum ada data tersedia.</p>
            @endforelse

        </div>
    </div>

    {{-- Nav Bawah --}}
    {{-- <div id="menu" class="max-w-[341px] w-full fixed bottom-[20px] p-3 flex items-center justify-between rounded-[30px] bg-[#1E2037] transform -translate-x-1/2 left-1/2">
        <a href="" class="p-[14px_16px] flex items-center gap-[6px] rounded-full bg-[#FF7815]">
            <div class="flex shrink-0">
                <img src="{{asset('assets/images/icons/heart.svg')}}" alt="icon">
            </div>
            <span class="font-semibold text-sm text-white">Discover</span>
        </a>
        <a href="" class="flex items-center justify-center w-[56px] h-[52px] p-[14px_16px]">
            <div class="flex shrink-0 w-6 h-6 overflow-hidden">
                <img src="{{asset('assets/images/icons/crown.svg')}}" alt="icon">
            </div>
        </a>
        <a href="" class="flex items-center justify-center w-[56px] h-[52px] p-[14px_16px]">
            <div class="flex shrink-0 w-6 h-6 overflow-hidden">
                <img src="{{asset('assets/images/icons/3dcube.svg')}}" alt="icon">
            </div>
        </a>
        <a href="" class="flex items-center justify-center w-[56px] h-[52px] p-[14px_16px]">
            <div class="flex shrink-0 w-6 h-6 overflow-hidden">
                <img src="{{asset('assets/images/icons/setting-2.svg')}}" alt="icon">
            </div>
        </a>
    </div> --}}
</section>

@endsection

