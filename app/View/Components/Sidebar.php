<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $icons;
    public string $active;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->icons = $this->filterIcons(app('icons'));
        $this->active = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }

    public function filterIcons($icons)
    {
        $admin = Auth::guard('admin')->user();
        foreach ($icons as $index => $icon) {
            if (isset($icon['ability']) && !$admin->can($icon['ability'])) {
                unset($icons[$index]);
            }
        }
        return $icons;
    }
}
