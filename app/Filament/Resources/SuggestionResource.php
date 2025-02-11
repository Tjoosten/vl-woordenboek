<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\SuggestionResource\Pages;
use App\Filament\Resources\SuggestionResource\RelationManagers;
use App\Filament\Resources\SuggestionResource\Widgets\AdvancedStatsOverviewWidget;
use App\Models\Suggestion;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class SuggestionResource extends Resource
{
    protected static ?string $model = Suggestion::class;
    protected static ?string $pluralModelLabel = 'suggesties';
    protected static ?string $modelLabel = 'suggestie';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getWidgets(): array
    {
        return [AdvancedStatsOverviewWidget::class];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Suggestie informatie')
                ->description('Alle informatie die nodig is om aan de slag te kunnen met de ingezonden suggestie.')
                ->compact()
                ->icon(fn (Suggestion $suggestion): string => $suggestion->status->getIcon())
                ->iconSize(IconSize::Medium)
                ->iconColor(fn (Suggestion $suggestion): string => $suggestion->status->getColor())
                ->columns(12)
                ->schema([
                    TextEntry::make('status')
                        ->columnSpan(2)
                        ->badge()
                        ->label('Status v/d suggestie'),
                        TextEntry::make('assignee.name')
                            ->label('Behandelaar')
                            ->translateLabel()
                            ->placeholder('- onbekend')
                            ->columnSpan(2),
                    TextEntry::make('word')
                        ->label('Woord')
                        ->weight(FontWeight::Bold)
                        ->color('primary')
                        ->columnSpan(2),
                    TextEntry::make('characteristics')
                        ->label('Kenmerken')
                        ->columnSpan(3)
                        ->placeholder('- Geen kenmerken opgegeven'),
                    TextEntry::make('created_at')
                        ->label('Ingestuurd op')
                        ->date()
                        ->columnSpan(3),
                    TextEntry::make('description')
                        ->label('Beschrijving')
                        ->columnSpan(6),
                    TextEntry::make('example')
                        ->label('Voorbeeld')
                        ->columnSpan(6),
                    TextEntry::make('regions.name')
                        ->label("Regio's")
                        ->color('gray')
                        ->icon('heroicon-m-map')
                        ->badge()
                        ->columnSpan(12),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Ingezonden suggesties')
            ->description('Overzicht van alle ingezonden suggesties door gast gebruikers')
            ->emptyStateIcon(self::$navigationIcon)
            ->emptyStateHeading('Geen suggesties gevonden.')
            ->emptyStateDescription('Momenteel zijn er geen suggesties gevonden die matchen met die tabblad. Kom op een later tijdstip nog eens terug.')
            ->columns([
                TextColumn::make('word')
                    ->label('Woord')
                    ->translateLabel()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->color('primary')
                    ->searchable(),
                TextColumn::make("regions_count")
                    ->translateLabel()
                    ->label("Gekoppelde Regio's")
                    ->sortable()
                    ->counts('regions')
                    ->badge()
                    ->placeholder("- Geen regio's opgegegeven")
                    ->color('success'),
                TextColumn::make('characteristics')
                    ->label('Kenmerken')
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->color('gray'),
                TextColumn::make('description')
                    ->label('Beschrijving')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Ingestuurd op')
                    ->translateLabel()
                    ->date()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuggestions::route('/'),
            'view' => Pages\ViewSuggestion::route('/{record}'),
        ];
    }
}
