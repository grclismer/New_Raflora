<x-app-layout title="Packages">
    <div class="py-16 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-slate-900 tracking-tight mb-4">Our Curated Packages</h1>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Explore our pre-set packages designed to bring your vision to life effortlessly. Select a package to start your booking.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($packages as $package)
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col transition hover:shadow-md">
                        @if($package->image_path)
                            <img src="{{ asset('storage/' . $package->image_path) }}" alt="{{ $package->title }}" class="w-full h-56 object-cover" />
                        @else
                            <div class="w-full h-56 bg-purple-100 flex items-center justify-center text-purple-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="p-8 flex flex-col flex-grow">
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $package->title }}</h2>
                            <p class="text-3xl font-extrabold text-purple-700 mb-6">₱{{ number_format($package->price, 2) }}</p>
                            
                            @if($package->description)
                                <p class="text-slate-600 mb-6 flex-grow">{{ $package->description }}</p>
                            @endif

                            @if($package->included_items && count($package->included_items) > 0)
                                <ul class="space-y-3 mb-8 flex-grow">
                                    @foreach($package->included_items as $item)
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-purple-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span class="text-slate-700 text-sm">{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <a href="{{ route('booking.start', ['package_id' => $package->id]) }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white text-center font-medium py-3 rounded-xl transition mt-auto">
                                Book This Package
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900">No Packages Available</h3>
                        <p class="mt-1 text-slate-500">We are currently updating our packages. Please check back later or start a custom booking.</p>
                        <div class="mt-6">
                            <a href="{{ route('booking.start') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                Create Custom Booking
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
