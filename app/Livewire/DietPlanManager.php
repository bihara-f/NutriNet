<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Rule;
use App\Models\DietPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class DietPlanManager extends Component
{
    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:1000')]
    public string $description = '';

    #[Validate('required|integer|min:1200|max:5000')]
    public int $calories_target = 2000;

    #[Validate('required|numeric|min:0|max:500')]
    public float $protein_target = 150.0;

    #[Validate('required|numeric|min:0|max:800')]
    public float $carbs_target = 250.0;

    #[Validate('required|numeric|min:0|max:300')]
    public float $fat_target = 70.0;

    #[Validate('required|integer|min:1|max:365')]
    public int $duration_days = 30;

    public ?DietPlan $editingPlan = null;
    public bool $showForm = false;

    protected $listeners = [
        'refreshPlans' => '$refresh',
        'planDeleted' => 'handlePlanDeleted'
    ];

    public function mount()
    {
        // Security: Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        $plans = Auth::user()->dietPlans()
            ->with(['meals:id,diet_plan_id,name,calories', 'nutritionLogs:id,diet_plan_id,calories_consumed'])
            ->latest()
            ->paginate(10);

        return view('livewire.diet-plan-manager', [
            'plans' => $plans,
        ]);
    }

    public function createPlan()
    {
        // Rate limiting for security
        $key = 'create-plan:' . Auth::id();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('rate_limit', 'Too many attempts. Please try again later.');
            return;
        }

        RateLimiter::hit($key, 300); // 5 minutes

        // Authorization check
        Gate::authorize('create', DietPlan::class);

        $this->validate();

        try {
            $plan = Auth::user()->dietPlans()->create([
                'name' => $this->name,
                'description' => $this->description,
                'calories_target' => $this->calories_target,
                'protein_target' => $this->protein_target,
                'carbs_target' => $this->carbs_target,
                'fat_target' => $this->fat_target,
                'duration_days' => $this->duration_days,
                'status' => 'active'
            ]);

            // Security logging
            Log::info('Diet plan created', [
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'ip_address' => request()->ip()
            ]);

            $this->reset();
            $this->showForm = false;
            
            session()->flash('message', 'Diet plan created successfully!');
            $this->dispatch('refreshPlans');

        } catch (\Exception $e) {
            Log::error('Diet plan creation failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            $this->addError('creation', 'Failed to create diet plan. Please try again.');
        }
    }

    public function editPlan(DietPlan $plan)
    {
        // Authorization check
        Gate::authorize('update', $plan);

        $this->editingPlan = $plan;
        $this->name = $plan->name;
        $this->description = $plan->description ?? '';
        $this->calories_target = $plan->calories_target;
        $this->protein_target = $plan->protein_target;
        $this->carbs_target = $plan->carbs_target;
        $this->fat_target = $plan->fat_target;
        $this->duration_days = $plan->duration_days;
        $this->showForm = true;
    }

    public function updatePlan()
    {
        // Rate limiting
        $key = 'update-plan:' . Auth::id();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $this->addError('rate_limit', 'Too many attempts. Please try again later.');
            return;
        }

        RateLimiter::hit($key, 300);

        Gate::authorize('update', $this->editingPlan);

        $this->validate();

        try {
            $this->editingPlan->update([
                'name' => $this->name,
                'description' => $this->description,
                'calories_target' => $this->calories_target,
                'protein_target' => $this->protein_target,
                'carbs_target' => $this->carbs_target,
                'fat_target' => $this->fat_target,
                'duration_days' => $this->duration_days,
            ]);

            Log::info('Diet plan updated', [
                'user_id' => Auth::id(),
                'plan_id' => $this->editingPlan->id,
                'ip_address' => request()->ip()
            ]);

            $this->reset();
            $this->showForm = false;
            
            session()->flash('message', 'Diet plan updated successfully!');
            $this->dispatch('refreshPlans');

        } catch (\Exception $e) {
            Log::error('Diet plan update failed', [
                'user_id' => Auth::id(),
                'plan_id' => $this->editingPlan->id,
                'error' => $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            $this->addError('update', 'Failed to update diet plan. Please try again.');
        }
    }

    public function deletePlan(DietPlan $plan)
    {
        Gate::authorize('delete', $plan);

        try {
            $planId = $plan->id;
            $plan->delete();

            Log::warning('Diet plan deleted', [
                'user_id' => Auth::id(),
                'plan_id' => $planId,
                'ip_address' => request()->ip()
            ]);

            session()->flash('message', 'Diet plan deleted successfully!');
            $this->dispatch('planDeleted', $planId);

        } catch (\Exception $e) {
            Log::error('Diet plan deletion failed', [
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            $this->addError('deletion', 'Failed to delete diet plan. Please try again.');
        }
    }

    public function cancelEdit()
    {
        $this->reset();
        $this->showForm = false;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->reset();
        }
    }

    public function handlePlanDeleted($planId)
    {
        // Handle any cleanup after plan deletion
        $this->dispatch('refreshPlans');
    }

    // Security: Input sanitization
    public function updatedName($value)
    {
        $this->name = strip_tags(trim($value));
    }

    public function updatedDescription($value)
    {
        $this->description = strip_tags(trim($value));
    }
}