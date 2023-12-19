<?php

declare(strict_types=1);

namespace App\Models;

use App\Mail\WelcomeMail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Leeto\MoonShine\Models\MoonshineSocialite;
use Leeto\MoonShine\Models\MoonshineUserRole;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

/**
 * @method static int activate()
 */
class MoonshineUser extends Authenticatable
{
    use HasMoonShineChangeLog;
    use HasFactory;
    use Notifiable;

    public const IS_ACTIVE = 1;

    public const ROLE_ID_ADMIN = 1;

    public const ROLE_ID_INACTIVE = 2;
    public const ROLE_ID_PARTICIPANT = 3;
    public const ROLE_ID_APPLICANT = 4;
    public const ROLE_ID_EMPLOYEE = 5;

    public const STATUS_ID_NEW = 1;

    public const STATUS_ID_CONFIRMED = 2;
    public const STATUS_ID_REFUSED = 3;

    public const STATUS_ID_DEACTIVATE = 4;


    protected $fillable = [
        'email',
        'moonshine_user_role_id',
        'password',
        'name',
        'avatar',
        'second_name',
        'last_name',
        'data_processing_permission',
        'position',
        'verify_token',
        'active',
        'organization_id',
        'phone_additional',
        'phone',
        'description_rejection'
    ];

    protected $with = ['moonshineUserRole'];

    public function moonshineUserRole(): BelongsTo
    {
        return $this->belongsTo(MoonshineUserRole::class);
    }

    public function statements()
    {
        return $this->belongsToMany(
            Statement::class,
            'expert_statement',
            'expert_id',
            'statement_id'
        );
    }

    public function scopeActivate(Builder $query): int
    {
        return $query->update([
            'moonshine_user_role_id' => MoonshineUser::ROLE_ID_APPLICANT,
            'active'                 => true,
            'deactivation_date'      => null,
            'description_rejection'  => null,
        ]);
    }

    public function verifyUser(string $value, string $parameter = 'email'): bool
    {
        try {
            $user = $this::where($parameter, $value)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return false;
        }
        $user->moonshine_user_role_id = MoonshineUser::ROLE_ID_APPLICANT;
        $user->save();
        return true;
    }

    public function deactivateUser(string $value, string $parameter = 'email'): bool
    {
        try {
            $user = $this::where($parameter, $value)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return false;
        }
        $user->active = false;
        $user->deactivation_date = now();
        $user->description_rejection = null;
        $user->save();
        return true;
    }

    public function scopeRenew(Builder $query): int
    {
        return $query->update([
            'moonshine_user_role_id' => self::ROLE_ID_INACTIVE,
            'active'                 => false,
            'deactivation_date'      => null,
            'description_rejection'  => null,
        ]);
    }

    public function rejectUser(string $value, string $rejectText = '', string $parameter = 'email'): bool
    {
        try {
            $user = $this::where($parameter, $value)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return false;
        }
        $user->description_rejection = $rejectText;
        $user->deactivation_date = null;
        $user->active = false;
        $user->save();
        return true;
    }

    public function moonshineSocialites(): HasMany
    {
        return $this->hasMany(MoonshineSocialite::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->moonshineUserRole->code, $roles);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function getUsersWithRole(string $code)
    {
        return MoonshineUser::whereHas('moonshineUserRole', function ($query) use ($code) {
            $query->where('code', $code);
        })->get();
    }

    public function expertOpinions(): HasMany
    {
        return $this->hasMany(ExpertOpinion::class);
    }

}
