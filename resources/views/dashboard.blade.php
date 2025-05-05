<x-app-layout>
    <div class="relative min-h-screen">
        <!-- Hero Background Video -->
        <!-- <div class="absolute inset-0 z-0">
            <video
                src="{{ asset('images/bracu-new.mp4') }}"
                class="w-full h-full object-cover opacity-100 pointer-events-none"
                autoplay
                muted
                loop
                playsinline
            ></video>
        </div> -->

        <div class="absolute inset-0 z-0">
    <!-- background video -->
    <video
        src="{{ asset('images/bracu-new.mp4') }}"
        class="w-full h-full object-cover pointer-events-none"
        autoplay
        muted
        loop
        playsinline>
    </video>

    <!-- black overlay @ 20 % -->
    <div class="absolute inset-0 bg-black/50 z-10 pointer-events-none"></div>
</div>


        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-6 text-center">
            <!-- Main Title -->
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-extrabold text-white drop-shadow-lg mb-4">
                BRACU Research Portal
            </h1>

            <!-- Sub‑tagline -->
            <p class="text-xl md:text-2xl text-white max-w-3xl mb-10">
                Discover and explore research papers, projects, and innovations from BRAC University scholars
            </p>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl">
                <!-- Paper Statistics Card -->
                <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-6">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ \App\Models\Paper::count() }}</div>
                    <div class="text-lg font-semibold">Research Papers</div>
                </div>

                <!-- Researcher Statistics Card -->
                <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-6">
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ \App\Models\Researcher::count() }}</div>
                    <div class="text-lg font-semibold">Researchers</div>
                </div>

                <!-- Project Statistics Card -->
                <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-6">
                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ \App\Models\Project::count() }}</div>
                    <div class="text-lg font-semibold">Research Projects</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-12 space-x-4">
                <a
                    href="{{ route('papers.index') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300"
                >
                    Browse Papers
                </a>
                <a
                    href="{{ route('researchers.index') }}"
                    class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-lg transition duration-300"
                >
                    View Researchers
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
