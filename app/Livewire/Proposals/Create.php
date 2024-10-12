<?php

namespace App\Livewire\Proposals;

use App\Models\Project;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public Project $project;
    public bool $modal = false;
    public bool $agree = false;

    #[Rule(['required', 'email'])]
    public string $email = '';
    #[Rule(['required', 'numeric', 'gt:0'])]
    public int $hours = 0;

    public function save() {
        $this->validate();

        if (!$this->agree) {
            $this->addError('agree', 'Concorde com os termos de uso');
            return;
        }

        $this->project->proposals()->updateOrCreate(
            ['email' => $this->email],
            ['hours' => $this->hours]
        );

        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}
