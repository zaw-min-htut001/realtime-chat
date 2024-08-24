<div class="max-w-6xl mx-auto my-16">
    <h5 class="text-center text-2xl font-bold py-3">Users</h5>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 ">
        @foreach ($users as $key =>  $user)
        <div class="w-full bg-white border border-gray-200 rounded-lg shadow">
            <div class="flex flex-col items-center p-2">
                <img src="https://avatar.iran.liara.run/public/{{$key }}" alt="image" class="w-24 h-24 p-5 m-2.5 rounded-full shadow-lg">
                <h5 class="mb-1 text-xl font font-medium text-gray-900">
                    {{ $user->name }}
                </h5>
                <span class="text-sm text-gray-500">{{ $user->email }}</span>
                <div class="flex mt-3 space-x-3 md:mt-6 mb-2">
                    <x-secondary-button>
                        Add friend
                    </x-secondary-button>

                    <x-primary-button wire:click='message({{$user->id}})'>
                        Message
                    </x-primary-button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
