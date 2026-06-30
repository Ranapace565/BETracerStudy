<?php

namespace App\Providers;

use App\Contracts\Repositories\AlumniRepositoryInterface;
use App\Contracts\Repositories\AnswerRepositoryInterface;
use App\Contracts\Repositories\JobVacancyRepositoryInterface;
use App\Contracts\Repositories\NewsRepositoryInterface;
use App\Contracts\Repositories\OptionRepositoryInterface;
use App\Contracts\Repositories\QuestionnaireRepositoryInterface;
use App\Contracts\Repositories\QuestionRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\Eloquent\EloquentAlumniRepository;
use App\Repositories\Eloquent\EloquentAnswerRepository;
use App\Repositories\Eloquent\EloquentJobVacancyRepository;
use App\Repositories\Eloquent\EloquentNewsRepository;
use App\Repositories\Eloquent\EloquentOptionRepository;
use App\Repositories\Eloquent\EloquentQuestionnaireRepository;
use App\Repositories\Eloquent\EloquentQuestionRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(AlumniRepositoryInterface::class, EloquentAlumniRepository::class);
        $this->app->bind(QuestionnaireRepositoryInterface::class, EloquentQuestionnaireRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, EloquentQuestionRepository::class);
        $this->app->bind(AnswerRepositoryInterface::class, EloquentAnswerRepository::class);
        $this->app->bind(OptionRepositoryInterface::class, EloquentOptionRepository::class);
        $this->app->bind(JobVacancyRepositoryInterface::class, EloquentJobVacancyRepository::class);
        $this->app->bind(NewsRepositoryInterface::class, EloquentNewsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
