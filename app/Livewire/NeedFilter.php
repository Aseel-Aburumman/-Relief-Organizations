<?php

namespace App\Livewire;

use App\Models\Need;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class NeedFilter extends Component
{
    use WithPagination;

    public $search = '';
    public $categories;
    public $urgencies;
    public $statuses;

    public $selectedCategory = '';
    public $selectedUrgency = '';
    public $selectedStatus = '';

    protected $queryString = ['search', 'selectedCategory', 'selectedUrgency', 'selectedStatus'];

    public function mount()
    {
        $this->categories = Category::all();
        $this->urgencies = Need::select('urgency')->distinct()->pluck('urgency');
        $this->statuses = Need::select('status')->distinct()->pluck('status');
    }

    public function updated($field)
    {
        if (in_array($field, ['selectedCategory', 'selectedUrgency', 'selectedStatus', 'search'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->selectedUrgency = '';
        $this->selectedStatus = '';
        $this->resetPage();
    }

    public function render()
    {
        $needs = Need::query()
            ->when($this->search, function ($query) {
                $query->whereHas('needDetail', function ($q) {
                    $q->where('item_name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
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
            ->paginate(3);

        return view('livewire.need-filter', [
            'needs' => $needs,
        ]);
    }
}
