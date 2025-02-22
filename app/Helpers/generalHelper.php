<?php

use App\Models\material_stock;
use App\Models\products;
use App\Models\purchase_details;
use App\Models\rawMaterial;
use App\Models\ref;
use App\Models\sale_details;
use App\Models\stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function getRef(){
    $ref = ref::first();
    if($ref){
        $ref->ref = $ref->ref + 1;
    }
    else{
        $ref = new ref();
        $ref->ref = 1;
    }
    $ref->save();
    return $ref->ref;
}

function firstDayOfMonth()
{
    $startOfMonth = Carbon::now()->startOfMonth();

    return $startOfMonth->format('Y-m-d');
}
function lastDayOfMonth()
{

    $endOfMonth = Carbon::now()->endOfMonth();

    return $endOfMonth->format('Y-m-d');
}

function firstDayOfCurrentYear() {
    $startOfYear = Carbon::now()->startOfYear();
    return $startOfYear->format('Y-m-d');
}

function lastDayOfCurrentYear() {
    $endOfYear = Carbon::now()->endOfYear();
    return $endOfYear->format('Y-m-d');
}

function firstDayOfPreviousYear() {
    $startOfPreviousYear = Carbon::now()->subYear()->startOfYear();
    return $startOfPreviousYear->format('Y-m-d');
}

function lastDayOfPreviousYear() {
    $endOfPreviousYear = Carbon::now()->subYear()->endOfYear();
    return $endOfPreviousYear->format('Y-m-d');
}


function createStock($id, $cr, $db, $date, $notes, $ref)
{
    stock::create(
        [
            'rawID'          => $id,
            'cr'            => $cr,
            'db'            => $db,
            'date'          => $date,
            'notes'         => $notes,
            'refID'         => $ref
        ]
    );
}

function getStock($id){
    $stocks  = stock::where('rawID', $id)->get();
    $balance = 0;
    foreach($stocks as $stock)
    {
        $balance += $stock->cr;
        $balance -= $stock->db;
    }

    return $balance;
}


function avgPurchasePrice($from, $to, $id)
{
    $purchases = purchase_details::where('rawID', $id);
    if($from != 'all' && $to != 'all')
    {
        $purchases->whereBetween('date', [$from, $to]);
    }
    $purchase_amount = $purchases->sum('amount');
    $purchase_qty = $purchases->sum('qty');

    if($purchase_qty > 0)
    {
        $purchase_price = $purchase_amount / $purchase_qty;
    }
    else
    {
        $purchase_price = 0;
    }

    return $purchase_price;
}

function stockValue()
{
    $products = rawMaterial::all();

    $value = 0;
    foreach($products as $product)
    {
        $value += productStockValue($product->id);
    }

    return $value;
}

function productStockValue($id)
{
    $stock = getStock($id);
    $price = avgPurchasePrice('all', 'all', $id);
    dashboard();
    return $price * $stock;
}

function calculateGrowthPercentage($oldValue, $newValue) {
    if ($oldValue == 0) {
        return $newValue > 0 ? 100 : 0; // 100% growth if starting from 0 to any positive number
    }
    $growthPercentage = (($newValue - $oldValue) / $oldValue) * 100;
    return $growthPercentage;
}

function projectNameAuth()
{
    return "QUETTA BAITHAK RESTAURANT";
}

function projectNameHeader()
{
    return "Quetta Baithak Restaurant";
}
function projectNameShort()
{
    return "QBR";
}
