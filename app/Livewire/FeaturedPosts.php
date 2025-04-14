<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class FeaturedPosts extends Component
{
    public $posts;

    public function mount()
    {
        $this->posts = Post::limit(3)->get(['id', 'title', 'images', 'link']);
    }

    public function render()
    {
        return view('livewire.featured-posts');
    }
}
