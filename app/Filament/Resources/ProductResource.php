<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->reactive()
                ->afterStateUpdated(function ($state, $set){
                    $state = Str::slug($state);
                    $set('slug', $state);
                })
                    ->label('Nome Produto'),
                TextInput::make('description')->label('Descrição Produto'),
                TextInput::make('price')->label('Preço Produto'),
                TextInput::make('amount')->label('Quantidade Produto'),
                TextInput::make('slug')->disabled(),
                FileUpload::make('photo')->directory('products')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo'),
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('price')->sortable()
                ->money('BRL'),
                TextColumn::make('amount'),
                TextColumn::make('created_at')->date('d/m/Y H:i:s'),

            ])
            ->filters([
                Filter::make('amount')
                ->toggle()
                ->label('Qtd Maior que 9')
                ->query(fn (Builder $builder) => $builder->where('amount','>', 9)),

                Filter::make('amount_qm')
                ->toggle()
                ->label('Qtd menor que 9')
                ->query(fn (Builder $builder) => $builder->where('amount','<', 9)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('amount', 'DESC');
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}