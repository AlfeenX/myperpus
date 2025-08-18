<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Library Management';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()->schema([
                    Group::make()->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Nomor Ponsel')
                            ->minLength(10)
                            ->maxLength(15)
                            ->required(),
                    ])->columns(2),
                    TextInput::make('email')
                        ->label('Alamat Email')
                        ->email()
                        ->required(),
                    Textarea::make('address')
                        ->label('Alamat')
                        ->columnSpanFull()
                        ->rows(8)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Alamat Email')
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('phone')
                    ->label('Nomor Ponsel')
                    ->icon('heroicon-o-phone'),
                TextColumn::make('address')
                    ->label('Alamat'),
                TextColumn::make('classroom.name')
                    ->label('Kelas'),
                IconColumn::make('status')
                ->boolean()
                ->getStateUsing(function ($record){
                    return $record->visitorLogs()->whereDate('visit_at', today())->exists();
                })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('markAsVisited')
                    ->label('Tandai Berkunjung')
                    ->icon('heroicon-o-bookmark')
                    ->requiresConfirmation()
                    ->modalHeading('Konfimasi Kunjungan')
                    ->modalDescription('Apakah anda yakin ingin menandai member ini sebagai telah berkunjung?')
                    ->action(function ($record) {
                        $visited = $record->visitorLogs()->whereDate('visit_at', today())->exists();
                        if (!$visited) {
                            $record->visitorLogs()->create([]);
                        }
                    })
                    ->disabled(fn($record) => $record->visitorLogs()->whereDate('visit_at', today())->exists()),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();

        if ($locale == 'id') {
            return "Anggota";
        }
        return "Members";
    }
}
