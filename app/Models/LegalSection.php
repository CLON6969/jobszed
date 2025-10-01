<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LegalSection extends Model {
    protected $fillable = ['legal_document_id', 'heading', 'body', 'order'];

    public function document() {
        return $this->belongsTo(LegalDocument::class);
    }

    public function listItems() {
        return $this->hasMany(LegalListItem::class);
    }
}