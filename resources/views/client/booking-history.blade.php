<x-app-layout title="Booking History">
    <x-client-layout active="booking-history">
        <section class="section-card p-10 max-w-6xl mx-auto">
            <div class="mb-10">
                <h1 class="page-title">Booking History</h1>
                <p class="section-subtitle mt-4">Track your previous bookings and review the status of each event.</p>
            </div>

            @if($bookings->isEmpty())
                <div class="rounded-3xl border border-white/10 bg-white/5 p-12 text-center text-white/70">
                    <p class="text-lg font-medium">You have no past bookings yet.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-3xl border border-white/10 bg-white/5 p-5">
                    <table class="min-w-full text-left text-sm text-white/80">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="px-4 py-3">Booking #</th>
                                <th class="px-4 py-3">Event</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Quoted Total</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="px-4 py-4 font-medium">#{{ $booking->id }}</td>
                                    <td class="px-4 py-4 capitalize">{{ $booking->event_type }}</td>
                                    <td class="px-4 py-4">{{ optional($booking->event_date)->format('F j, Y') }}</td>
                                    <td class="px-4 py-4 uppercase tracking-wide">{{ str_replace('_', ' ', $booking->status) }}</td>
                                    <td class="px-4 py-4">₱{{ number_format($booking->total_quoted ?? 0, 2) }}</td>
                                    <td class="px-4 py-4">
                                        <a href="{{ route('bookings.analysis', ['booking' => $booking->id]) }}" class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-4 py-2 text-sm font-semibold text-white/90 hover:bg-white/20 transition">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </x-client-layout>
</x-app-layout>
