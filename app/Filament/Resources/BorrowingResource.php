<?php

namespace App\Filament\Resources;

use App\Filament\Exports\BorrowingExporter;
use App\Filament\Resources\BorrowingResource\Pages;
use App\Filament\Resources\BorrowingResource\RelationManagers;
use App\Models\Book;
use App\Models\Borrowing;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

use function Livewire\before;

class BorrowingResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Library Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('member_id')
                    ->searchable()
                    ->label('Nama Anggota')
                    ->placeholder('Select member')
                    ->relationship('member', 'name')
                    ->required(),
                Select::make('book_id')
                    ->searchable()
                    ->label('Judul Buku')
                    ->placeholder('Select book')
                    ->relationship('book', 'title')
                    ->required(),
                Select::make('user_id')
                    ->default(auth('web')->user()?->id)
                    ->disabled()
                    ->label('Nama Petugas')
                    ->relationship('user', 'name')
                    ->required(),
                DatePicker::make('borrow_date')
                    ->label('Tanggal Peminjaman')
                    ->default(now())
                    ->required(),
                DatePicker::make('due_date')
                    ->label('Tanggal Jatuh Tempo')
                    ->minDate(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->label('Judul Buku')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('member.name')
                    ->label('Nama Anggota')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('borrow_date')
                    ->label('Tanggal Pinjam')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->sortable(),
                TextColumn::make('status')
                    ->color(fn(string $state): string => match ($state) {
                        'Dipinjam' => 'warning',
                        'Selesai' => 'success',
                        'Terlambat' => 'danger',
                    })
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Dipinjam' => 'heroicon-o-arrow-path',
                        'Selesai' => 'heroicon-o-check-circle',
                        'Terlambat' => 'heroicon-o-exclamation-triangle',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Dipinjam' => 'Dipinjam',
                        'Selesai' => 'Selesai',
                        'Terlambat' => 'Terlambat',
                    ])
            ])
            ->actions([
                Tables\Actions\Action::make('makeAsReturned')
                    ->label('Tandai Selesai')
                    ->icon('heroicon-o-bookmark')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'Dipinjam')
                    ->action(function ($record) {
                        $record->update([
                            'stock' => Book::find($record->book_id)->increment('stock'),
                            'status' => 'Selesai',
                            'return_at' => now()
                        ]);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => $record->status === "Selesai")
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
            'index' => Pages\ListBorrowings::route('/'),
            'create' => Pages\CreateBorrowing::route('/create'),
            'edit' => Pages\EditBorrowing::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();

        if ($locale == 'id') {
            return "Peminjaman";
        }
        return "Borrowings";
    }
}
