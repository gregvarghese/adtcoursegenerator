<?php

namespace App\Filament\Resources\TopicResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TopicResource;
use App\Filament\Traits\HasDescendingOrder;

class ListTopics extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TopicResource::class;
}
