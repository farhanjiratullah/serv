<a href="{{ route('detail.landing', $service->id) }}" class="inline-block px-3">
    <div class="w-96 h-auto overflow-hidden md:p-5 p-4 bg-white rounded-2xl inline-block">
        <div class="flex items-center space-x-2 mb-6">
            <!--Author's profile photo-->
            @if ($service->User->DetailUser->photo)
                <img src="{{ Storage::url($service->User->DetailUser->photo) }}" alt="{{ $service->User->name }}"
                    class="w-14 h-14 object-cover object-center mr-1 rounded-full" loading="lazy">
            @else
                <svg class="w-14 h-14 mr-1 rounded-full text-gray-300 object-center object-cover" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            @endif

            <div>
                <!--Author name-->
                <p class="text-gray-900 font-semibold text-lg">{{ $service->User->name }}</p>
                <p class="text-serv-text font-light text-md">
                    {{ $service->User->DetailUser->role }}
                </p>
            </div>
        </div>

        <!--Banner image-->
        <img class="rounded-2xl object-cover h-48 w-full"
            src="{{ Storage::url($service->Thumbnails->first()->thumbnail) }}" alt="{{ $service->title }}"
            loading="lazy" />

        <!--Title-->
        <h1 class="font-semibold text-gray-900 text-lg mt-1 leading-normal py-4">
            {{ $service->title }}
        </h1>
        <!--Description-->
        <div class="max-w-full">
            @include('components.Landing.rating')
        </div>

        <div class="text-center mt-5 flex justify-between w-full">
            <span class="text-serv-text mr-3 inline-flex items-center leading-none text-md py-1 ">
                Price starts from:
            </span>
            <span class="text-serv-button inline-flex items-center leading-none text-md font-semibold">
                Rp{{ number_format($service->price, 0, ',', '.') }}
            </span>
        </div>
    </div>
</a>
