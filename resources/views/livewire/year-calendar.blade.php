<div x-data="{ openModal: false, selectedDate: '' }" class="p-6 max-w-7xl mx-auto">

    <!-- Jahr-Auswahl -->
    <div class="mb-4">
        <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Jahr:</label>
        <select wire:model="year" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
            @for ($i = now()->year - 10; $i <= now()->year + 10; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <!-- Kalender -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($months as $month => $days)
            <div class="col-span-1 shadow-lg p-4 bg-white">
                <h2 class="text-xl font-semibold mb-3">{{ $month }}</h2>
                <div class="grid grid-cols-7 gap-1 border-b pb-2 mb-2">
                    @foreach (['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'] as $d)
                        <span class="text-gray-500 text-center">{{ $d }}</span>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-1">
                    @foreach ($days as $data)
                        <div class="text-center {{ $loop->iteration == 1 ? 'col-start-' . $data['offset'] : '' }}">
                            <div @click="openModal = true; selectedDate = '{{ $year }}-{{ $loop->parent->iteration }}-{{ $data['day'] }}'" class="hover:bg-green-200 p-2 transition duration-300 cursor-pointer">
                                {{ $data['day'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Zentrales Modal für Buchungen -->
    <div
        x-show="openModal"
        class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50"
        @click.away="openModal = false"
    >
        <div class="bg-white p-4 rounded shadow-lg w-1/3">
            <h3 class="text-lg font-semibold mb-4">Buchung für: <span x-text="selectedDate"></span></h3>

            <form action="/bookings" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="arrival" class="block text-sm font-medium text-gray-700">Anreise</label>
                    <input type="text" name="arrival" x-bind:value="selectedDate" id="arrival" class="mt-1 block w-full">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Buchen</button>
            </form>

            <button @click="openModal = false" class="absolute top-2 right-2">Schließen</button>
        </div>
    </div>

</div>
