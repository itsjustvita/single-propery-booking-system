<div x-data="{ openModal: false, selectedDate: '' }" class="p-6 max-w-7xl mx-auto" >

    <!-- Jahr-Auswahl -->
    <div class="mb-4 max-w-xs mx-auto flex align-middle justify-center items-center gap-4 ">
        <select wire:model="year" class="appearance-none block w-full  bg-gray-600 backdrop-blur-lg bg-opacity-40  text-white border text-center font-bold rounded py-3 px-4 mb-3 leading-tight focus:outline-none>
            @for ($i = now()->year - 10; $i <= now()->year + 10; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <!-- Kalender -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" >
        @foreach ($months as $month => $days)
            <div class="col-span-1 shadow-lg p-4 bg-gray-600 backdrop-blur-lg bg-opacity-40 rounded-xl">
                <h2 class="text-xl font-semibold text-white mb-3 text-center">{{ $month }}</h2>

                <div class="grid grid-cols-7 gap-1 border-b pb-2 mb-2">
                    @foreach (['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'] as $d)
                        <span class="text-white text-center">{{ $d }}</span>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-1">
                    @foreach ($days as $data)
                        @php
                            $formattedDate = $year . '-' . str_pad($loop->parent->iteration, 2, '0', STR_PAD_LEFT) . '-' . str_pad($data['day'], 2, '0', STR_PAD_LEFT);
                            $isBooked = isset($data['booked']) && $data['booked'];
                        @endphp
                        <div class="text-center {{ $loop->iteration == 1 ? 'col-start-' . $data['offset'] : '' }}">
                            <div
                                @click="openModal = true; selectedDate = '{{ $formattedDate }}'"
                                class="{{ $isBooked ? 'bg-red-300 text-red-700' : 'hover:bg-green-200 hover:text-green-700' }} p-2 transition text-white font-bold duration-300 cursor-pointer"
                            >
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
                    <input type="text" name="start_date" x-bind:value="selectedDate" id="start_date" class="mt-1 block w-full">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Buchen</button>
            </form>

            <button @click="openModal = false" class="absolute top-2 right-2">Schließen</button>
        </div>
    </div>

</div>
