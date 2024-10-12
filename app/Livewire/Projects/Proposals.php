<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Proposals extends Component
{
    public Project $project;
    public int $qtd = 5;
    private int $base_qtd = 5;

    #[Computed()]
    public function proposals() {
        return $this->project->proposals()
            ->orderBy('hours')
            ->paginate($this->qtd);
    }

    public function loadMore() {
        $this->qtd += $this->base_qtd;
    }

    #[Computed()]
    public function lastProposalTime() {
        return $this->project->proposals()
            ->latest('updated_at')->first()
            ->updated_at->diffForHumans();
    }

    #[On('proposal::created')]
    public function render()
    {
        return view('livewire.projects.proposals');
    }
}
