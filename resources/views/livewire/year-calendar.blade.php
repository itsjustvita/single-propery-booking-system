<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="mb-4">
        <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Jahr:</label>
        <select wire:model="year" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
            @for ($i = now()->year - 10; $i <= now()->year + 10; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <div class="grid grid-cols-4 gap-4">
        @foreach ($months as $month => $days)
            <div class="col-span-1">
                <h2 class="text-xl font-semibold mb-3">{{ $month }}</h2>

                <div class="grid grid-cols-7 gap-1 border-b pb-2 mb-2">
                    @foreach (['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'] as $d)
                        <span class="text-gray-500 text-center">{{ $d }}</span>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-1">
                    @foreach ($days as $data)
                        <div class="text-center {{ $loop->iteration == 1 ? 'col-start-' . $data['offset'] : '' }}">
                            {{ $data['day'] }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
