<?php

namespace App\Livewire;

use App\Models\Need;
use App\Models\Category;
use Livewire\Component;

class NeedFilter extends Component
{
    public $categories;
    public $urgencies;
    public $statuses;

    public $selectedCategory = '';
    public $selectedUrgency = '';
    public $selectedStatus = '';

    public $needs;

    public function mount()
    {
        $this->categories = Category::all();
        $this->urgencies = Need::select('urgency')->distinct()->pluck('urgency');
        $this->statuses = Need::select('status')->distinct()->pluck('status');
        $this->filterNeeds();
    }

    public function updated($field)
    {
        if (in_array($field, ['selectedCategory', 'selectedUrgency', 'selectedStatus'])) {
            $this->filterNeeds();
        }
    }

    public function filterNeeds()
    {
        $this->needs = Need::query()
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->selectedUrgency, function ($query) {
                $query->where('urgency', $this->selectedUrgency);
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->with(['needDetail', 'image'])
            ->get();
    }

    public function render()
    {
        return view('livewire.need-filter', [
            'needs' => $this->needs,
        ]);
    }
}
