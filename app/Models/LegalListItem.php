<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LegalListItem extends Model {
    protected $fillable = ['legal_section_id', 'item_text', 'order'];

    public function section() {
        return $this->belongsTo(LegalSection::class);
    }
}

