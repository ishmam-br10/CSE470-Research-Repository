<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-6">About BRACU Research Portal</h1>
                
                <p class="mb-4">
                    BRACU Research Portal is a comprehensive digital repository of research papers, projects, and scholarly works 
                    produced by the BRAC University community.
                </p>
                
                <p class="mb-4">
                    Our mission is to showcase the intellectual output of the university, preserve scholarly work, 
                    and provide easy access to research materials for students, faculty, and researchers worldwide.
                </p>
                
                <h2 class="text-2xl font-bold mt-8 mb-4">Our Objectives</h2>
                <ul class="list-disc pl-5 mb-6 space-y-2">
                    <li>Preserve and showcase BRACU's research output</li>
                    <li>Facilitate knowledge sharing within and beyond the university</li>
                    <li>Provide a centralized repository for easy access to research papers</li>
                    <li>Promote collaboration between researchers and departments</li>
                    <li>Track research metrics and impact</li>
                </ul>
                
                <h2 class="text-2xl font-bold mt-8 mb-4">Contact Information</h2>
                <p class="mb-2"><strong>Email:</strong> research.portal@bracu.ac.bd</p>
                <p class="mb-2"><strong>Phone:</strong> +880 2-222-264051-4</p>
                <p><strong>Address:</strong> BRAC University, 66 Mohakhali, Dhaka-1212, Bangladesh</p>
            </div>
        </div>
    </div>
</x-app-layout>