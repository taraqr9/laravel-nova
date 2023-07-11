<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Post extends Resource
{
    // public static $with = ['user'];

    public static $group = 'User Posts';

    public static $model = \App\Models\Post::class;

    public static $title = 'id';

    public static $search = [
        'id', 'post'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('User')->hideFromIndex(),
//            BelongsTo::make('User')->default($request->user()->getKey()),
            TEXT::make('User ID')->sortable(),
            TEXT::make('User Post', 'post')->showOnPreview()->placeholder('Write your post here!'),
            Boolean::make('Published', 'is_published'),
//            Image::make('Image')->maxWidth(100),
            MorphOne::make('Image', 'file', File::class),

            new Panel('User Information', $this->userFields()),

            Select::make('Post Category', 'category')->options([
                'new_posts' => 'New Posts',
                'news' => 'News',
            ]),
        ];
    }

    protected function userFields()
    {
        return [
            Text::make('Name', 'address_line_1')->hideFromIndex()->hideWhenCreating(),
            Text::make('Email')->hideFromIndex()->hideWhenCreating(),
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
