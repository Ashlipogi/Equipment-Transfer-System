@extends('layouts.app')

@section('content')
<title>
    Dashboard
</title>
<style>
            .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 24px;
        color: #333;
    }
</style>
<div class="home-section min-h-screen bg-[#E4E9F7]">
    <div class="py-12">
        <div class="mx-auto px-6 lg:px-8 w-full">


            <div class="flex gap-4 w-full">

                <!-- Pending Transfers Card -->
                <div class="flex-1">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="p-4 bg-white">
                            <div class="flex items-center space-x-3">
                                <div class="text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-gray-900">{{ $transferCount }}</h3>
                                    <p class="text-gray-600 text-sm">Pending Transfers</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-500 p-2">
                            <a href="{{ route('transfer') }}" class="text-white/90 text-sm hover:text-white flex items-center justify-between">
                                <span>View Details</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Transferred Items Card -->
                <div class="flex-1">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="p-4 bg-white">
                            <div class="flex items-center space-x-3">
                                <div class="text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-gray-900">{{ $transferredCount }}</h3>
                                    <p class="text-gray-600 text-sm">Transferred Items</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-500 p-2">
                            <a href="{{ route('transferred') }}" class="text-white/90 text-sm hover:text-white flex items-center justify-between">
                                <span>View Details</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Activity History Card -->
                <div class="flex-1">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="p-4 bg-white">
                            <div class="flex items-center space-x-3">
                                <div class="text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-gray-900">Activity</h3>
                                    <p class="text-gray-600 text-sm">View History</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-yellow-500 p-2">
                            <a href="{{ route('activity.history') }}" class="text-white/90 text-sm hover:text-white flex items-center justify-between">
                                <span>View Details</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
