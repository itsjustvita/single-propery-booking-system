<div x-data="{ openModal: false, displayDate: '', formattedDate: '' }" class="p-6 max-w-7xl mx-auto">

    <!-- Jahr-Auswahl -->
    <div class="mb-4 max-w-xs mx-auto flex align-middle justify-center items-center gap-4 ">
        <select wire:model="year" class="appearance-none block w-full  bg-gray-600 backdrop-blur-lg bg-opacity-40  text-white border text-center font-bold rounded py-3 px-4 mb-3 leading-tight focus:outline-none>
            @for ($i = now()->year - 3; $i <= now()->year + 3; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
        @endfor
        </select>
    </div>

    <!-- Kalender -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
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
                            $dateForDisplay = str_pad($data['day'], 2, '0', STR_PAD_LEFT) . '.' . str_pad($loop->parent->iteration, 2, '0', STR_PAD_LEFT) . '.' . $year;
                            $formattedDate = $year . '-' . str_pad($loop->parent->iteration, 2, '0', STR_PAD_LEFT) . '-' . str_pad($data['day'], 2, '0', STR_PAD_LEFT);
                            $isBooked = isset($data['booked']) && $data['booked'];
                        @endphp
                        <div class="text-center {{ $loop->iteration == 1 ? 'col-start-' . $data['offset'] : '' }}">
                            <div
                                @click="$dispatch('openedModal', '{{ $dateForDisplay }}' ); openModal = true; displayDate = '{{ $dateForDisplay }}'; formattedDate = '{{ $formattedDate }}'"
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
        <div class="rounded-xl text-white bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
            <h3 class="text-lg font-semibold mb-4">Buchung für: <span id="displayDate" x-text="displayDate"></span></h3>

            <form action="/bookings" method="POST">
                @csrf
                <div class="mb-4">
                    <div class="flex gap-4">
                        <div class="input">
                            <div

                                class="max-w-sm w-full"
                            >
                                <div class="mb-2 font-bold">Zeitraum</div>

                                <input name="start_date" id="picker" class="rounded-3xl text-white border-none bg-green-400 bg-opacity-50 px-6 py-2 text-center  placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" x-ref="picker"
                                       type="text">
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="rounded-3xl mt-4 bg-green-600 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-green-800">Buchen</button>
                </div>
            </form>
            <button @click="openModal = false" class="absolute top-4 right-4">✕</button>
        </div>
    </div>

</div>


<script>
    document.addEventListener('openedModal', (e) => {
        let picker = flatpickr('#picker', {
            mode: 'range',
            locale: 'de',
            dateFormat: 'd.m.Y',
            defaultDate: e.detail,
            onChange: (date, dateString) => {
                this.value = dateString.split(' to ')
            }
        })
    });

</script>
