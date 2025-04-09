<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\SurveyResource\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Filament\Resources\SurveyResource\Widgets\SurveyWidget;
use App\Filament\Resources\SurveyResource\Widgets\SurveyStatistics;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                        Forms\Components\Hidden::make('created_by')
                            ->default(auth()->user()->id),
                        Forms\Components\Toggle::make('is_active')
                            ->required(),

                        Forms\Components\Section::make('Survey Question')
                            ->description('')
                            ->schema([

                                Forms\Components\Repeater::make('questions')
                                ->relationship('questions')
                                ->schema([

                                    Forms\Components\Textarea::make('question_text')
                                        ->columnSpanFull()
                                        ->required(),
                                    
                                    Forms\Components\Select::make('question_type')
                                        ->options([
                                            'text' => 'Text',
                                            'rating' => 'Rating',
                                            'multiple_choice' => 'Multiple Choice',
                                            'single_choice' => 'Single Choice',
                                        ])
                                        ->searchable()
                                        ->live()
                                        ->required(),

                                        Forms\Components\TextInput::make('options')
                                        ->helperText('Comma separated values')
                                        ->visible(fn($get) => in_array($get('question_type'),['multiple_choice','single_choice']))
                                        ->required(),

                                        Forms\Components\TextInput::make('rating_scale')
                                        ->helperText('1-10, enter the maximum rating')
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(10)
                                        ->visible(fn($get) => $get('question_type') == 'rating')
                                        ->required(),
            
                                    Forms\Components\Toggle::make('is_required')
                                        ->required(),
                                ])
                                ->defaultItems(1)
                                ->columns(2)

                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Created By')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make("view")
                ->label('View Questions')
                ->icon('heroicon-o-eye')
                ->color('success')
                ->slideOver()
                ->visible(false)
                ->fillForm(function($record){
                    return [
                        'questions' => $record->questions,
                    ];
                })
                ->modalSubmitAction(false)
                ->infolist([
                    RepeatableEntry::make('questions')
                    ->label('Survey Questions')
                    ->schema([
                        TextEntry::make('question_text')
                        ->columnSpanFull(),
                        TextEntry::make('question_type'),
                        TextEntry::make('options')
                        ->visible(fn($record) => in_array($record->question_type,['multiple_choice','single_choice'])),
                        TextEntry::make('rating_scale')
                        ->visible(fn($record) => $record->question_type == 'rating'),
                        TextEntry::make('is_required')
                        ->color(fn (string $state): string => match ($state) {
                            1 => 'info',
                            0 => 'warning',
                            'published' => 'success',
                            default => 'gray',
                        }),
                    ])
                    ->columns(3)


                ]),
                Tables\Actions\Action::make("survey")
                ->label('Survey')
                ->icon('heroicon-o-chart-bar-square')
                ->color('danger')
                ->url(fn($record) => static::getUrl('survey-form',['record' => $record])),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            SurveyStatistics::class,
            SurveyWidget::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
            'view' => Pages\ViewSurvey::route('/{record}'),
            'survey-form' => Pages\SurveyForm::route('/{record}/survey-form'),
        ];
    }
}
