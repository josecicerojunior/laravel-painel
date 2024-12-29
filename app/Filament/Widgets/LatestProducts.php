<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Closure;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;


class LatestProducts extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Product::query(4)->orderBy('id', 'DESC');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('name'),
        ];
    }
}
