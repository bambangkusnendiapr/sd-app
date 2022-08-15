<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tahsin;
use App\Models\Student;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class TahsinUpload extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $foo;
    public $search = '';
    public $page = 1;

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $student = Student::where('nama', 'like', '%'.$this->search.'%')->get('id');

        return view('livewire.tahsin-upload', [
            'tahsin' => Tahsin::whereIn('student_id', $student)->where('is_deleted', false)->paginate($this->paginate),
        ]);
    }
}
