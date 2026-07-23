<x-app-layout title="My Bookings">
    <x-client-layout active="bookings">
        <section class="section-card p-10 max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-10">
                <div>
                    <h1 class="page-title">My Bookings</h1>
                    <p class="section-subtitle mt-3">Manage your event requests, view quotations, and track booking status from one place.</p>
                </div>
                <a href="{{ route('bookings.create') }}" class="btn-primary">New Booking</a>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-white/10 bg-white/5 p-5">
                <table class="min-w-full text-left text-sm text-white/80">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="px-4 py-3">Event</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Time</th>
                            <th class="px-4 py-3">Venue</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($bookings as $booking)
                            @php
                                $statusClass = match ($booking->status) {
                                    'quotation_sent' => 'bg-yellow-500 text-black',
                                    'payment_pending' => 'bg-orange-500 text-black',
                                    'downpayment_received' => 'bg-blue-500 text-white',
                                    'completed' => 'bg-green-500 text-white',
                                    'cancelled' => 'bg-red-500 text-white',
                                    default => 'bg-purple-500 text-white',
                                };
                            @endphp
                            <tr>
                                <td class="px-4 py-4 font-semibold">{{ ucfirst($booking->event_type ?? 'Event') }}</td>
                                <td class="px-4 py-4">{{ optional($booking->event_date)->format('F j, Y') ?? 'TBD' }}</td>
                                <td class="px-4 py-4">{{ $booking->event_time ?? 'TBD' }}</td>
                                <td class="px-4 py-4">{{ $booking->venue ?? 'TBD' }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                        {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <a href="{{ route('bookings.analysis', ['booking' => $booking->id]) }}" class="inline-flex items-center gap-2 text-white bg-white/10 hover:bg-white/20 rounded-full px-4 py-2 transition">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-white/60">No bookings found. Start by creating a new booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <script>
            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            function saveEdit(id) {
                alert('Edit saved for booking ' + id + '! (Mock - no backend yet)');
                closeModal('editModal');
            }

            function confirmCancel() {
                alert('Booking cancelled! (Mock - no backend yet)');
                closeModal('cancelModal');
            }

            function filterBookings(status, event) {
                const rows = document.querySelectorAll('.booking-row');
                const tabs = document.querySelectorAll('.filter-tab');

                tabs.forEach(tab => tab.classList.remove('active', 'bg-purple-700'));
                tabs.forEach(tab => tab.classList.add('bg-purple-600'));
                if (event && event.target) event.target.classList.add('active', 'bg-purple-700');

                rows.forEach(row => {
                    if (status === 'all' || row.classList.contains(status)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });

                const visibleRows = document.querySelectorAll('.booking-row:not(.hidden)');
                const emptyEl = document.getElementById('emptyState');
                if (emptyEl) emptyEl.classList.toggle('hidden', visibleRows.length > 0);
            }
        </script>
    </x-client-layout>
</x-app-layout>
