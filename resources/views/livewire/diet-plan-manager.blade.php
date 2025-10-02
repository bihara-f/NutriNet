<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showForm: @entangle('showForm') }">
    <!-- Header Section -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Diet Plan Manager</h1>
                <p class="text-gray-600 mt-2">Create and manage your personalized diet plans</p>
            </div>
            <button 
                wire:click="toggleForm"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ $showForm ? 'Cancel' : 'Create New Plan' }}
            </button>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>{{ session('message') }}</div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <div class="font-bold">Please fix the following errors:</div>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Create/Edit Form -->
    <div x-show="showForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">
            {{ $editingPlan ? 'Edit Diet Plan' : 'Create New Diet Plan' }}
        </h2>
        
        <form wire:submit="{{ $editingPlan ? 'updatePlan' : 'createPlan' }}" class="space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Plan Name *</label>
                    <input 
                        type="text" 
                        id="name"
                        wire:model.live="name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Enter plan name"
                        maxlength="255"
                    >
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-2">Duration (Days) *</label>
                    <input 
                        type="number" 
                        id="duration_days"
                        wire:model.live="duration_days"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('duration_days') border-red-500 @enderror"
                        min="1"
                        max="365"
                    >
                    @error('duration_days') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea 
                    id="description"
                    wire:model.live="description"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                    placeholder="Enter plan description"
                    maxlength="1000"
                ></textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Nutrition Targets -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Nutrition Targets</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="calories_target" class="block text-sm font-medium text-gray-700 mb-2">Calories *</label>
                        <input 
                            type="number" 
                            id="calories_target"
                            wire:model.live="calories_target"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('calories_target') border-red-500 @enderror"
                            min="1200"
                            max="5000"
                        >
                        @error('calories_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="protein_target" class="block text-sm font-medium text-gray-700 mb-2">Protein (g) *</label>
                        <input 
                            type="number" 
                            id="protein_target"
                            wire:model.live="protein_target"
                            step="0.1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('protein_target') border-red-500 @enderror"
                            min="0"
                            max="500"
                        >
                        @error('protein_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="carbs_target" class="block text-sm font-medium text-gray-700 mb-2">Carbs (g) *</label>
                        <input 
                            type="number" 
                            id="carbs_target"
                            wire:model.live="carbs_target"
                            step="0.1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('carbs_target') border-red-500 @enderror"
                            min="0"
                            max="800"
                        >
                        @error('carbs_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="fat_target" class="block text-sm font-medium text-gray-700 mb-2">Fat (g) *</label>
                        <input 
                            type="number" 
                            id="fat_target"
                            wire:model.live="fat_target"
                            step="0.1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('fat_target') border-red-500 @enderror"
                            min="0"
                            max="300"
                        >
                        @error('fat_target') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <button 
                    type="button"
                    wire:click="cancelEdit"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>{{ $editingPlan ? 'Update Plan' : 'Create Plan' }}</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Diet Plans List -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Your Diet Plans</h2>
        </div>
        
        @if($plans->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($plans as $plan)
                    <div class="p-6 hover:bg-gray-50 transition duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $plan->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($plan->status === 'active') bg-green-100 text-green-800
                                        @elseif($plan->status === 'completed') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($plan->status) }}
                                    </span>
                                </div>
                                
                                @if($plan->description)
                                    <p class="text-gray-600 mb-3">{{ $plan->description }}</p>
                                @endif
                                
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                                    <div class="bg-blue-50 p-3 rounded-lg">
                                        <div class="text-blue-600 font-medium">Duration</div>
                                        <div class="text-gray-900">{{ $plan->duration_days }} days</div>
                                    </div>
                                    <div class="bg-red-50 p-3 rounded-lg">
                                        <div class="text-red-600 font-medium">Calories</div>
                                        <div class="text-gray-900">{{ number_format($plan->calories_target) }}</div>
                                    </div>
                                    <div class="bg-green-50 p-3 rounded-lg">
                                        <div class="text-green-600 font-medium">Protein</div>
                                        <div class="text-gray-900">{{ $plan->protein_target }}g</div>
                                    </div>
                                    <div class="bg-yellow-50 p-3 rounded-lg">
                                        <div class="text-yellow-600 font-medium">Carbs</div>
                                        <div class="text-gray-900">{{ $plan->carbs_target }}g</div>
                                    </div>
                                    <div class="bg-purple-50 p-3 rounded-lg">
                                        <div class="text-purple-600 font-medium">Fat</div>
                                        <div class="text-gray-900">{{ $plan->fat_target }}g</div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Created {{ $plan->created_at->diffForHumans() }}
                                    @if($plan->meals_count > 0)
                                        <span class="ml-4">{{ $plan->meals_count }} meals</span>
                                    @endif
                                    @if($plan->nutrition_logs_count > 0)
                                        <span class="ml-4">{{ $plan->nutrition_logs_count }} logs</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="ml-6 flex space-x-2">
                                <button 
                                    wire:click="editPlan({{ $plan->id }})"
                                    class="text-blue-600 hover:text-blue-800 p-2 rounded-md hover:bg-blue-50 transition duration-200"
                                    title="Edit Plan"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="deletePlan({{ $plan->id }})"
                                    onclick="return confirm('Are you sure you want to delete this diet plan?')"
                                    class="text-red-600 hover:text-red-800 p-2 rounded-md hover:bg-red-50 transition duration-200"
                                    title="Delete Plan"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $plans->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No diet plans yet</h3>
                <p class="mt-2 text-gray-500">Get started by creating your first diet plan.</p>
                <button 
                    wire:click="toggleForm"
                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Create Your First Plan
                </button>
            </div>
        @endif
    </div>
</div>