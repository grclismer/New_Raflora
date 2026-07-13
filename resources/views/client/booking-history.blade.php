<x-app-layout title="Booking History">
    <x-client-layout active="booking-history">
        <div class="max-w-5xl mx-auto">
            <h1 class="serif text-3xl font-bold text-white mb-6">Booking History</h1>

            <div class="glass-card p-6">
                @if($bookings->isEmpty())
                    <p class="text-white/60 text-center py-12">You have no past bookings yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-white/80">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3">Booking ID</th>
                                    <th class="px-4 py-3">Event Type</th>
                                    <th class="px-4 py-3">Event Date</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Quoted Total</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td class="px-4 py-3 font-mono text-xs">{{ \Illuminate\Support\Str::limit($booking->id, 10, '...') }}</td>
                                        <td class="px-4 py-3 capitalize">{{ $booking->event_type }}</td>
                                        <td class="px-4 py-3">{{ optional($booking->event_date)->format('F j, Y') }}</td>
                                        <td class="px-4 py-3 uppercase tracking-wide">{{ str_replace('_', ' ', $booking->status) }}</td>
                                        <td class="px-4 py-3">₱{{ number_format($booking->total_quoted ?? 0, 2) }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('bookings.analysis', ['booking' => $booking->id]) }}" class="text-indigo-300 hover:text-white">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </x-client-layout>
</x-app-layout>
