<?php

namespace App\Filament\Resources;

use App\Models\Topic;
use Spatie\FilamentMarkdownEditor\MarkdownEditor;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\TopicResource\Pages;

class TopicResource extends Resource
{
    protected static ?string $model = Topic::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('title')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Title')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('prompt')
                        ->rules([ 'string'])
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

	                MarkdownEditor::make('markdown')
		                ->rules(['string'])
		                ->required()
		                ->placeholder('Json')
		                ->columnSpan([
			                'default' => 12,
			                'md' => 12,
			                'lg' => 12,
		                ]),


                    RichEditor::make('html')
                        ->rules(['string'])
                        ->required()
                        ->placeholder('Html')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Toggle::make('complete')
                        ->rules(['boolean'])
                        ->required()
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
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('prompt')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('json')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('html')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('complete')
                    ->toggleable()
                    ->boolean(),
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
        return [TopicResource\RelationManagers\HistoriesRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTopics::route('/'),
            'create' => Pages\CreateTopic::route('/create'),
            'view' => Pages\ViewTopic::route('/{record}'),
            'edit' => Pages\EditTopic::route('/{record}/edit'),
        ];
    }
}
