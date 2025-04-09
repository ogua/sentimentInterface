<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\SentimentAnalysis;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SentimentAnalysisResource\Pages;
use App\Filament\Resources\SentimentAnalysisResource\RelationManagers;

class SentimentAnalysisResource extends Resource
{
    protected static ?string $model = SentimentAnalysis::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('response_answer_id')
                    ->required()
                    ->maxLength(36),
                Forms\Components\TextInput::make('polarity_score')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('sentiment_label')
                    ->required(),
                Forms\Components\Textarea::make('emotions')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('aspect_terms')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nlp_model_id')
                    ->required()
                    ->maxLength(36),
                Forms\Components\TextInput::make('confidence_score')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('analyzed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('responseAnswer.surveyQuestion.question_text')
                    ->label('Question')
                    ->searchable(),
                Tables\Columns\TextColumn::make('responseAnswer.answer_text')
                    ->label('Answer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('polarity_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sentiment_label'),
                Tables\Columns\TextColumn::make('confidence_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('analyzed_at')
                    ->dateTime()
                    ->sortable(),
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
               // Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSentimentAnalyses::route('/'),
            'create' => Pages\CreateSentimentAnalysis::route('/create'),
            'edit' => Pages\EditSentimentAnalysis::route('/{record}/edit'),
        ];
    }
}
