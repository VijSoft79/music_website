<?php

namespace App\Livewire\Curator;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Music;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cache;

class SubmissionsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortBy = 'default';
    public $songType = '';
    public $searchQuery = '';
    public $selectedGenres = [];
    public $genres;
    public $userGenreIds;
    public $perPage = 12;

    protected $queryString = [
        'sortBy' => ['except' => 'default'],
        'songType' => ['except' => ''],
        'searchQuery' => ['except' => '']
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->userGenreIds = $user->genres->pluck('id')->toArray();
        $this->selectedGenres = $this->userGenreIds;
        $this->genres = Genre::where('parent_id', null)->with('parentGenre')->get();
    }

    public function updateGenres($genreIds)
    {
        $curator = Auth::user();
        $curator->genres()->sync($genreIds);
        $this->selectedGenres = $genreIds;
    }

    public function getMusicsProperty()
    {
        $query = Music::query()
            ->where('created_at', '>=', Carbon::now()->subDays(90))
            ->where('status', 'approve')
            ->whereHas('artist');

        // Filter by user genres if any are selected
        if (!empty($this->selectedGenres)) {
            $query->whereHas('genres', function ($q) {
                $q->whereIn('genre_id', $this->selectedGenres);
            });
        }

        // Filter by song type
        if ($this->songType) {
            if ($this->songType === 'default') {
                $query->where('release_type', 'single');
            } else {
                $query->where('release_type', $this->songType);
            }
        }

        // Search by title and musician
        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->searchQuery . '%')
                  ->orWhereHas('artist', function ($q2) {
                      $q2->where('band_name', 'like', '%' . $this->searchQuery . '%');
                  });
            });
        }
        
        // Sort by remaining days
        if ($this->sortBy === 'sort_date') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Exclude invited music
        $invitedMusicIds = Auth::user()->offer->pluck('music_id')->toArray();
        $query->whereNotIn('id', $invitedMusicIds);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.curator.submissions-list', [
            'musics' => $this->musics,
            'genres' => $this->genres,
            'userGenreIds' => $this->userGenreIds
        ]);
    }
}
