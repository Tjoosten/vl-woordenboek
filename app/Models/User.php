<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\WelcomeNotification;
use App\UserTypes;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;
use Overtrue\LaravelLike\Traits\Liker;
use Cog\Contracts\Ban\Bannable as BannableInterface;
use Cog\Laravel\Ban\Traits\Bannable;

/**
 * User represents an authenticated account in the 'Vlaams woordenboek application'.
 *
 * This model handles user authentication, authorization, and profile management.
 * It supports role-based access control through user types, welcome notifications for new users,
 * and interaction tracking thrpough the "likes" system.
 *
 * @property int          $id                 Unique identifier for the user
 * @property string       $firstname          User's first name
 * @property string       $lastname           User's last name
 * @property string       $email              User's email address for authentication
 * @property UserTypes    $user_type          The assigned role group
 * @property string       $password           Hashed password for authentication
 * @property Carbon|null  $last_seen_at       Timestamp of last activity
 * @property Carbon|null  $email_verified_at  Timestamp of email verification
 * @property string|null  $remember_token     Token for "remember me" functionality
 * @property Carbon|null  $banned_at          Timestamp from when the user account has been banned.
 * @property Carbon       $created_at         Timestamp of account creation
 * @property Carbon       $updated_at         Timestamp of last update
 *
 * @package App\Models
 */
final class User extends Authenticatable implements FilamentUser, BannableInterface
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use ReceivesWelcomeNotification;
    use Notifiable;
    use Liker;
    use Bannable;

    /**
     * Sepcifies which attributes can be mass assigned when creating or updating user records.
     * This provides a security layer against mass-assignment vulnerabilities by explicitly listing allowed fields.
     *
     * @var list<string>
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'user_type', 'password', 'last_seen_at'];

    /**
     * Defines default values for new user instances.
     * Every new user start with normal privileges unitl explicitly upgraded by an administrator.
     *
     * @var array<string, UserTypes>
     */
    protected $attributes = ['user_type' => UserTypes::Normal];

    /**
     * Specifies attributes that should be hidden when the model is serialized.
     * This prevents sensitive data like passwords form beind exposed in API responses of JSON serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Determines whether a user can access the admin panel interface.
     * Access is granted based on the 'access-backend' permission, which is typically assigned to editorial and administrative roles.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->can('access-backend');
    }

    /**
     * Sends the initial welcome notification to newly created users.
     * The notification includes a time-limited link for setting up their password and activating their account.
     *
     * @param  Carbon $validUntil Expriration timestamp for the welcome link.
     */
    public function sendWelcomeNotification(Carbon $validUntil): void
    {
        $this->notify(new WelcomeNotification($validUntil));
    }

    /**
     * Configures attribute casting for proper type handling.
     * This ensures that dates are properly handles as Casbon instances and that the user type cast to its own enum representation.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_type' => UserTypes::class,
            'last_seen_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
