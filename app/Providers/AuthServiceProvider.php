<?php

namespace App\Providers;

use App\Models\Document;
use App\Models\Division;
use App\Models\Category;
use App\Policies\DocumentPolicy;
use App\Policies\DivisionPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Document::class => DocumentPolicy::class,
        Division::class => DivisionPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
