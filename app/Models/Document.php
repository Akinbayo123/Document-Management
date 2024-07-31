<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;


    // app/Models/User.php

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    // app/Models/Document.php

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
