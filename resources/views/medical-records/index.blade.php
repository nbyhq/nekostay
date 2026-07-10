<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-2xl text-gray-800">

            Medical Records

        </h2>

    </x-slot>

    <div class="space-y-6">

        @if(session('success'))

            <div
                id="success-alert"
                class="rounded-xl border border-green-200 bg-green-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="text-2xl">

                        ✅

                    </div>

                    <div>

                        <h3 class="font-semibold text-green-700">

                            Success

                        </h3>

                        <p class="text-green-600">

                            {{ session('success') }}

                        </p>

                    </div>

                </div>

            </div>

        @endif

        <div class="grid grid-cols-12 gap-6">

            <div class="col-span-3">

                @include('medical-records.partials.cat-list')

            </div>

            <div class="col-span-9">

                <div class="grid grid-cols-12 gap-6">

                    <div class="col-span-4">

                        @include('medical-records.partials.profile-card')

                    </div>

                    <div class="col-span-8">

                        @include('medical-records.partials.timeline')

                    </div>

                </div>

            </div>

        </div>

    </div>

    @push('scripts')

    <script>

        setTimeout(function(){

            let alert=document.getElementById('success-alert');

            if(alert){

                alert.style.transition='0.5s';

                alert.style.opacity='0';

                setTimeout(()=>{

                    alert.remove();

                },500);

            }

        },3000);

    </script>

    @endpush

</x-app-layout>
