<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;

class HistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'histories';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                RichEditor::make('prompt')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Prompt')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                RichEditor::make('json')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Json')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('topic_id')
                    ->rules(['exists:topics,id'])
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
                    ->relationship('course', 'name')
                    ->searchable()
                    ->placeholder('Course')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prompt')->limit(50),
                Tables\Columns\TextColumn::make('json')->limit(50),
                Tables\Columns\TextColumn::make('topic.title')->limit(50),
                Tables\Columns\TextColumn::make('section.name')->limit(50),
                Tables\Columns\TextColumn::make('course.name')->limit(50),
                Tables\Columns\TextColumn::make('user.name')->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('topic_id')->relationship(
                    'topic',
                    'title'
                ),

                MultiSelectFilter::make('section_id')->relationship(
                    'section',
                    'name'
                ),

                MultiSelectFilter::make('course_id')->relationship(
                    'course',
                    'name'
                ),

                MultiSelectFilter::make('user_id')->relationship(
                    'user',
                    'name'
                ),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
