<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\SiteTemplate
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string $cover
 * @property mixed $download_links
 * @property string|null $demo
 * @property string $original_link
 * @property bool|null $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereDemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereDownloadLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereOriginalLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperSiteTemplate {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

