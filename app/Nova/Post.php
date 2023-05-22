<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Post extends Resource
{
    // public static $with = ['user'];

    public static $group = 'User Posts';

    public static $model = \App\Models\Post::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            TEXT::make('User ID')->sortable(),
            TEXT::make('User Post', 'post')->showOnPreview()->placeholder('Write your post here!'),
            Boolean::make('Published', 'is_published'),

            Select::make('Post Category', 'category')->options([
                'new_posts' => 'New Posts',
                'news' => 'News',
            ]),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}
