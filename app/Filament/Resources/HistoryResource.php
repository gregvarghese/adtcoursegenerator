<?php

namespace App\Filament\Resources;

use App\Models\History;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\HistoryResource\Pages;

class HistoryResource extends Resource
{
    protected static ?string $model = History::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    RichEditor::make('prompt')
                        ->rules(['string'])
                        ->required()
                        ->placeholder('Prompt')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('json')
                        ->rules(['string'])
                        ->required()
                        ->placeholder('Json')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('topic_id')
                        ->rules(['exists:topics,id'])
                        ->required()
                        ->relationship('topic', 'title')
                        ->searchable()
                        ->placeholder('Topic')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('section_id')
                        ->rules(['exists:sections,id'])
                        ->required()
                        ->relationship('section', 'name')
                        ->searchable()
                        ->placeholder('Section')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('course_id')
                        ->rules(['exists:courses,id'])
                        ->required()
                        ->relationship('course', 'name')
                        ->searchable()
                        ->placeholder('Course')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('user_id')
                        ->rules(['exists:users,id'])
                        ->required()
                        ->relationship('user', 'name')
                        ->searchable()
                        ->placeholder('User')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('prompt')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('json')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('topic.title')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('section.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('course.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('topic_id')
                    ->relationship('topic', 'title')
                    ->indicator('Topic')
                    ->multiple()
                    ->label('Topic'),

                SelectFilter::make('section_id')
                    ->relationship('section', 'name')
                    ->indicator('Section')
                    ->multiple()
                    ->label('Section'),

                SelectFilter::make('course_id')
                    ->relationship('course', 'name')
                    ->indicator('Course')
                    ->multiple()
                    ->label('Course'),

                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->indicator('User')
                    ->multiple()
                    ->label('User'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistories::route('/'),
            'create' => Pages\CreateHistory::route('/create'),
            'view' => Pages\ViewHistory::route('/{record}'),
            'edit' => Pages\EditHistory::route('/{record}/edit'),
        ];
    }
}
