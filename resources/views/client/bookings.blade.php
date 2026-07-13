<x-app-layout title="My Bookings">
    <x-client-layout active="bookings">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="serif text-3xl font-bold text-white">My Bookings</h1>
                <a href="{{ route('bookings.create') }}" class="inline-flex items-center gap-2 bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-lg transition">
                    <i class="fa-solid fa-plus"></i>
                    <span>New Booking</span>
                </a>
            </div>

            <!-- Filter Tabs -->
            <div class="flex gap-4 mb-6">
                <button onclick="filterBookings('all')" class="filter-tab active px-6 py-2 rounded-lg text-white font-semibold bg-purple-700 transition">All Bookings</button>
                <button onclick="filterBookings('active')" class="filter-tab px-6 py-2 rounded-lg text-white font-semibold bg-purple-600 hover:bg-purple-700 transition">Active</button>
                <button onclick="filterBookings('completed')" class="filter-tab px-6 py-2 rounded-lg text-white font-semibold bg-purple-600 hover:bg-purple-700 transition">Completed</button>
                <button onclick="filterBookings('cancelled')" class="filter-tab px-6 py-2 rounded-lg text-white font-semibold bg-purple-600 hover:bg-purple-700 transition">Cancelled</button>
            </div>

            <!-- Bookings Table -->
            <div class="glass-card p-6 overflow-x-auto">
                <table class="w-full text-white text-sm">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="text-left py-3 px-4">Event</th>
                            <th class="text-left py-3 px-4">Type</th>
                            <th class="text-left py-3 px-4">Date & Time</th>
                            <th class="text-left py-3 px-4">Address</th>
                            <th class="text-center py-3 px-4">Status</th>
                            <th class="text-center py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bookingsTableBody">
                        @forelse($bookings as $booking)
                            @php
                                $statusClass = match ($booking->status) {
                                    'quotation_sent' => 'bg-yellow-500',
                                    'payment_pending' => 'bg-orange-500',
                                    'downpayment_received' => 'bg-blue-500',
                                    'completed' => 'bg-green-500',
                                    'cancelled' => 'bg-red-500',
                                    default => 'bg-purple-500',
                                };
                            @endphp
                            <tr class="border-b border-white/10 hover:bg-white/5 transition booking-row all {{ $booking->status }}" data-status="{{ $booking->status }}">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://via.placeholder.com/48?text={{ ucfirst($booking->event_type ?? 'Event') }}" alt="{{ ucfirst($booking->event_type ?? 'Event') }}" class="w-12 h-12 rounded object-cover">
                                        <span class="font-semibold">{{ ucfirst($booking->event_type ?? 'Event') }} Booking</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">{{ ucfirst($booking->event_type ?? 'N/A') }}</td>
                                <td class="py-4 px-4">{{ optional($booking->event_date)->format('F j, Y') ?? 'TBD' }}</td>
                                <td class="py-4 px-4">{{ $booking->venue ?? 'TBD' }}</td>
                                <td class="py-4 px-4 text-center"><span class="inline-block {{ $statusClass }} px-3 py-1 rounded-full text-xs font-semibold">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span></td>
                                <td class="py-4 px-4">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('bookings.analysis', ['booking' => $booking->id]) }}" class="text-blue-400 hover:text-blue-300 transition" title="View Analysis"><i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-white/60">No bookings found. Create one to begin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div id="emptyState" class="hidden text-center py-12">
                    <p class="text-white/60">No bookings found</p>
                </div>
            </div>
        </div>

        <!-- Details Modal -->
        <div id="detailsModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70">
            <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-purple-700 to-purple-600 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white serif">Booking Details</h2>
                    <button onclick="closeModal('detailsModal')" class="text-white hover:text-gray-200 transition"><i class="fa-solid fa-xmark text-2xl"></i></button>
                </div>
                <div class="p-6 space-y-4" id="detailsContent">
                    <!-- Content will be filled by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70">
            <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-yellow-600 to-yellow-500 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white serif">Edit Booking</h2>
                    <button onclick="closeModal('editModal')" class="text-white hover:text-gray-200 transition"><i class="fa-solid fa-xmark text-2xl"></i></button>
                </div>
                <div class="p-6 space-y-4" id="editContent">
                    <!-- Content will be filled by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Cancel Modal -->
        <div id="cancelModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70">
            <div class="bg-white rounded-lg shadow-2xl max-w-lg w-full mx-4">
                <div class="bg-gradient-to-r from-red-600 to-red-500 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white serif">Cancel Booking</h2>
                    <button onclick="closeModal('cancelModal')" class="text-white hover:text-gray-200 transition"><i class="fa-solid fa-xmark text-2xl"></i></button>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-gray-700" id="cancelContent">Are you sure you want to cancel this booking?</p>
                    <div class="flex gap-4 justify-end">
                        <button onclick="closeModal('cancelModal')" class="px-4 py-2 rounded bg-gray-300 text-gray-800 font-semibold hover:bg-gray-400 transition">Keep Booking</button>
                        <button onclick="confirmCancel()" class="px-4 py-2 rounded bg-red-600 text-white font-semibold hover:bg-red-700 transition">Confirm Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const bookingData = {
                1: { name: "Sarah & John's Wedding", type: "Wedding", date: "June 15, 2026", time: "10:00 AM - 6:00 PM", address: "Marina Bay Resort, Manila", status: "Upcoming", guests: 250, budget: "₱500,000", florals: "White Roses, Orchids", notes: "Garden ceremony with tent setup", image: "Wedding" },
                2: { name: "ABC Corp Annual Gala", type: "Corporate Event", date: "July 20, 2026", time: "5:00 PM - 11:00 PM", address: "BGC Grand Ballroom, Manila", status: "Upcoming", guests: 500, budget: "₱750,000", florals: "Mixed Tropical Arrangements", notes: "Luxury corporate event with premium decor", image: "Corporate" },
                3: { name: "Maria's Birthday Bash", type: "Birthday Party", date: "May 10, 2026", time: "2:00 PM - 8:00 PM", address: "Quezon City Sports Club", status: "Completed", guests: 80, budget: "₱150,000", florals: "Pink & Purple Florals", notes: "Completed successfully", image: "Birthday" },
                4: { name: "Angela's 18th Debut", type: "Debut", date: "April 5, 2026", time: "6:00 PM - 12:00 AM", address: "Pasay Convention Center", status: "Cancelled", guests: 300, budget: "₱600,000", florals: "White & Gold Theme", notes: "Cancelled per client request", image: "Debut" }
            };

            function openDetailsModal(id) {
                const booking = bookingData[id];
                const content = `
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">${booking.name}</h3>
                            <p class="text-sm text-gray-600">${booking.type}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase">Date</label>
                                <p class="text-gray-800">${booking.date}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase">Time</label>
                                <p class="text-gray-800">${booking.time}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase">Address</label>
                            <p class="text-gray-800">${booking.address}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase">Guests</label>
                                <p class="text-gray-800">${booking.guests}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase">Budget</label>
                                <p class="text-gray-800">${booking.budget}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase">Floral Arrangements</label>
                            <p class="text-gray-800">${booking.florals}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase">Special Notes</label>
                            <p class="text-gray-800">${booking.notes}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase">Status</label>
                            <p class="text-gray-800 font-semibold">${booking.status}</p>
                        </div>
                    </div>
                `;
                document.getElementById('detailsContent').innerHTML = content;
                document.getElementById('detailsModal').classList.remove('hidden');
            }

            function openEditModal(id) {
                const booking = bookingData[id];
                const content = `
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Event Name</label>
                            <input type="text" value="${booking.name}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Event Date</label>
                                <input type="text" value="${booking.date}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Time</label>
                                <input type="text" value="${booking.time}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Number of Guests</label>
                            <input type="number" value="${booking.guests}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Budget</label>
                            <input type="text" value="${booking.budget}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Floral Arrangement</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 resize-none" rows="3">${booking.florals}</textarea>
                        </div>
                        <div class="flex gap-4 justify-end">
                            <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 rounded bg-gray-300 text-gray-800 font-semibold hover:bg-gray-400 transition">Cancel</button>
                            <button type="button" onclick="saveEdit(${id})" class="px-4 py-2 rounded bg-yellow-600 text-white font-semibold hover:bg-yellow-700 transition">Save Changes</button>
                        </div>
                    </form>
                `;
                document.getElementById('editContent').innerHTML = content;
                document.getElementById('editModal').classList.remove('hidden');
            }

            function openCancelModal(id) {
                document.getElementById('cancelContent').innerHTML = `Are you sure you want to cancel <strong>${bookingData[id].name}</strong>?`;
                document.getElementById('cancelModal').classList.remove('hidden');
                window.currentCancelId = id;
            }

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

            function filterBookings(status) {
                const rows = document.querySelectorAll('.booking-row');
                const tabs = document.querySelectorAll('.filter-tab');
                
                tabs.forEach(tab => tab.classList.remove('active', 'bg-purple-700'));
                tabs.forEach(tab => tab.classList.add('bg-purple-600'));
                event.target.classList.add('active', 'bg-purple-700');

                rows.forEach(row => {
                    if (status === 'all' || row.classList.contains(status)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });

                const visibleRows = document.querySelectorAll('.booking-row:not(.hidden)');
                document.getElementById('emptyState').classList.toggle('hidden', visibleRows.length > 0);
            }
        </script>
    </x-client-layout>
</x-app-layout>
