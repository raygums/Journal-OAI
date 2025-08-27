<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $contact_name
 * @property string $contact_email
 * @property string $institution
 * @property string $faculty
 * @property string $original_title
 * @property string $display_title
 * @property string $doi
 * @property string $journal_type
 * @property string $issn
 * @property string $e_issn
 * @property string $publisher
 * @property string $publisher_country
 * @property string $journal_website_url
 * @property string $journal_contact_name
 * @property string $journal_official_email
 * @property string $journal_contact_phone
 * @property string $start_year
 * @property string $period_of_issue
 * @property string $editorial_team
 * @property string $editorial_address
 * @property string $description
 * @property bool $has_homepage
 * @property bool $is_using_ojs
 * @property string $ojs_link
 * @property string $open_access_example_url
 * @property string $editorial_board_url
 * @property string $contact_url
 * @property string $reviewer_url
 * @property string|null $google_scholar_url
 * @property string|null $sinta_link
 * @property string|null $sinta_accreditation
 * @property string|null $garuda_link
 * @property string|null $scopus_indexing
 * @property string $journal_cover_url
 * @property array<array-key, mixed> $subject_area_arjuna
 * @property array<array-key, mixed> $subject_area_garuda
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereContactUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereDisplayTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereDoi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereEIssn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereEditorialAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereEditorialBoardUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereEditorialTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereFaculty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereGarudaLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereGoogleScholarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereHasHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereInstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereIsUsingOjs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereIssn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereJournalContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereJournalContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereJournalCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereJournalOfficialEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereJournalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereJournalWebsiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereOjsLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereOpenAccessExampleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereOriginalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal wherePeriodOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal wherePublisherCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereReviewerUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereScopusIndexing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereSintaAccreditation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereSintaLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereStartYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereSubjectAreaArjuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereSubjectAreaGaruda($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereUserId($value)
 * @mixin \Eloquent
 */
class Journal extends Model
{
    use HasFactory;

    /**
     * Atribut yang diizinkan untuk diisi secara massal (mass assignable).
     * Ini adalah lapisan keamanan untuk mencegah pengisian data yang tidak diinginkan.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Kolom untuk menyimpan ID pengguna yang membuat jurnal
        'contact_name',
        'contact_email',
        'institution',
        'faculty',
        'original_title',
        'display_title',
        'doi',
        'journal_type',
        'issn',
        'e_issn',
        'publisher',
        'publisher_country',
        'journal_website_url',
        'journal_contact_name',
        'journal_official_email',
        'journal_contact_phone',
        'start_year',
        'period_of_issue',
        'editorial_address',
        'editorial_team',
        'description',
        'has_homepage',
        'is_using_ojs',
        'ojs_link',
        'open_access_example_url',
        'editorial_board_url',
        'contact_url',
        'reviewer_url',
        'google_scholar_url',
        'sinta_link',
        'sinta_accreditation',
        'garuda_link',
        'oai_link', // oai link
        'scopus_indexing', // Kolom untuk Indexing Scopus
        'journal_cover_url',
        'subject_area_arjuna',
        'subject_area_garuda',

        // Kolom untuk Fitur Review & Verifikasi
        'status',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Ini memastikan data yang disimpan dan diambil dari database memiliki format yang benar.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'has_homepage' => 'boolean',
        'is_using_ojs' => 'boolean',
        'subject_area_arjuna' => 'array', // Otomatis mengubah JSON ke array PHP dan sebaliknya
        'subject_area_garuda' => 'array', // Otomatis mengubah JSON ke array PHP dan sebaliknya
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}