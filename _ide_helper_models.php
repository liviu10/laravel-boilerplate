<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class Appreciation
 *
 * @package App\Models
 * @property int $id
 * @property int $content_id
 * @property int|null $user_id
 * @property int|null $likes
 * @property int|null $dislikes
 * @property int|null $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Content $content
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereDislikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appreciation whereUserId($value)
 */
	class Appreciation extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Comment
 *
 * @package App\Models
 * @property int $id
 * @property int $comment_type_id
 * @property int $comment_statuses_id
 * @property int $content_id
 * @property string $full_name
 * @property string $email
 * @property string $message
 * @property bool $notify_new_comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property-read \App\Models\CommentStatus|null $comment_status
 * @property-read \App\Models\CommentType $comment_type
 * @property-read \App\Models\Content $content
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentStatusesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereNotifyNewComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CommentStatus
 *
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentStatus whereValue($value)
 */
	class CommentStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * Class CommentType
 *
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentType whereValue($value)
 */
	class CommentType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ContactMessage
 *
 * @package App\Models
 * @property int $id
 * @property int $contact_subject_id
 * @property string $full_name
 * @property string $email
 * @property string|null $phone
 * @property string $message
 * @property bool $privacy_policy
 * @property bool $terms_and_conditions
 * @property bool $data_protection
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContactResponse> $contact_responses
 * @property-read int|null $contact_responses_count
 * @property-read \App\Models\ContactSubject $contact_subject
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereContactSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereDataProtection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage wherePrivacyPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereTermsAndConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereUserId($value)
 */
	class ContactMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ContactResponse
 *
 * @package App\Models
 * @property int $id
 * @property int $contact_message_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\ContactMessage $contact_message
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse whereContactMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactResponse whereUserId($value)
 */
	class ContactResponse extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ContactSubject
 *
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContactMessage> $contact_messages
 * @property-read int|null $contact_messages_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactSubject whereValue($value)
 */
	class ContactSubject extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Content
 *
 * @package App\Models
 * @property int $id
 * @property int $content_visibility_id
 * @property \Illuminate\Support\Carbon|null $scheduled_on
 * @property string $content_url
 * @property string $title
 * @property int $content_type_id
 * @property int|null $content_category_id
 * @property string|null $description
 * @property string $content
 * @property bool $allow_comments
 * @property bool $allow_share
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appreciation> $appreciations
 * @property-read int|null $appreciations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\ContentCategory|null $content_category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContentSocialMedia> $content_social_media
 * @property-read int|null $content_social_media_count
 * @property-read \App\Models\ContentType $content_type
 * @property-read \App\Models\ContentVisibility $content_visibility
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereAllowComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereAllowShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereContentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereContentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereContentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereContentVisibilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereScheduledOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUserId($value)
 */
	class Content extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ContentCategory
 *
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $contents
 * @property-read int|null $contents_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentCategory whereValue($value)
 */
	class ContentCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Content
 *
 * @package App\Models
 * @property int $id
 * @property int $content_id
 * @property string $platform_name
 * @property string $full_share_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\Content $content
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia whereFullShareUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia wherePlatformName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentSocialMedia whereUserId($value)
 */
	class ContentSocialMedia extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ContentType
 *
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $contents
 * @property-read int|null $contents_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentType whereValue($value)
 */
	class ContentType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ContentVisibility
 *
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $contents
 * @property-read int|null $contents_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentVisibility whereValue($value)
 */
	class ContentVisibility extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Media
 *
 * @package App\Models
 * @property int $id
 * @property int $media_type_id
 * @property int $content_id
 * @property string|null $internal_path
 * @property string|null $external_path
 * @property string|null $title
 * @property string|null $caption
 * @property string|null $alt_text
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\Content $content
 * @property-read \App\Models\MediaType $media_type
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereAltText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereExternalPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereInternalPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMediaTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUserId($value)
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * Class MediaType
 *
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereValue($value)
 */
	class MediaType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class NewsletterCampaign
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon $valid_from
 * @property \Illuminate\Support\Carbon $valid_to
 * @property int $occur_times
 * @property int $occur_week
 * @property int $occur_day
 * @property \Illuminate\Support\Carbon $occur_hour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NewsletterSubscriber> $newsletter_subscribers
 * @property-read int|null $newsletter_subscribers_count
 * @property-read \App\Models\NewsletterTemplate|null $newsletter_templates
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereOccurDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereOccurHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereOccurTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereOccurWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterCampaign whereValidTo($value)
 */
	class NewsletterCampaign extends \Eloquent {}
}

namespace App\Models{
/**
 * Class NewsletterSubscriber
 *
 * @package App\Models
 * @property int $id
 * @property int $newsletter_campaign_id
 * @property string $full_name
 * @property string $email
 * @property bool $privacy_policy
 * @property bool $terms_and_conditions
 * @property bool $data_protection
 * @property bool $valid_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\NewsletterCampaign $newsletter_campaign
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereDataProtection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereNewsletterCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber wherePrivacyPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereTermsAndConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereValidEmail($value)
 */
	class NewsletterSubscriber extends \Eloquent {}
}

namespace App\Models{
/**
 * Class NewsletterTemplate
 *
 * @package App\Models
 * @property int $id
 * @property int $newsletter_campaign_id
 * @property string $template
 * @property bool $is_active
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\NewsletterCampaign $newsletter_campaign
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereNewsletterCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterTemplate whereUserId($value)
 */
	class NewsletterTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Review
 *
 * @package App\Models
 * @property int $id
 * @property string $full_name
 * @property int $rating
 * @property string|null $comment
 * @property bool $is_active
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Tag
 *
 * @package App\Models
 * @property int $id
 * @property int $content_id
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\Content $content
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUserId($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $full_name
 * @property string $first_name
 * @property string $last_name
 * @property string|null $nickname
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property string|null $profile_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContactSubject> $contact_subjects
 * @property-read int|null $contact_subjects_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

