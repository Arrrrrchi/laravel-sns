<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function user () : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* 中間テーブルlikesの作成 */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    /* いいねされたかの判定 */
    public function isLikeBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id',$user->id)->count()
            : false;
    }

    /* いいね数のカウントするアクセサ */
    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    /* 中間テーブルarticle_tagの作成 */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
    
}
