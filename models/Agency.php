<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%agency_profile}}".
 *
 * @property integer $uid
 * @property string $agency_type
 * @property string $subdomain
 * @property string $company_name
 * @property string $company_address
 * @property string $company_email
 * @property string $company_phone
 * @property string $company_website
 * @property string $company_logo
 * @property string $company_logo_url
 * @property integer $doitforme_enable
 * @property string $doitforme_email
 * @property string $background_color
 * @property string $foreground_color
 * @property string $body_font
 * @property string $header_font
 * @property integer $header_enable
 * @property string $header_text
 * @property string $embed_report_type
 * @property integer $embed_enable_email
 * @property integer $embed_enable_phone
 * @property string $embed_form_type
 * @property string $embed_behaviour
 * @property string $embed_color_btn
 * @property string $embed_color_btn_text
 * @property string $embed_color_text
 * @property string $embed_color_field_borders
 * @property string $section_bgcolor
 * @property string $section_fgcolor
 * @property integer $webhook_status
 * @property string $webhook_url
 * @property string $checks
 * @property integer $show_details
 * @property User $user
 * @property int $show_title [smallint(1)] 0-hide, 1-show default, 2-show custom
 * @property int $show_intro [smallint(1)] 0-hide, 1-show default, 2-show custom
 * @property int $show_recommendations [smallint(1)]
 * @property string $custom_title [varchar(255)]
 * @property string $custom_intro
 * @property string $language
 * @property int $embed_enable_first_name [smallint(1)]
 * @property int $embed_enable_last_name [smallint(1)]
 * @property int $embed_enable_custom_field [smallint(1)]
 * @property int $embed_enable_button [smallint(1)]
 * @property string $embed_custom_field [varchar(255)]
 * @property string $embed_redirect_url [varchar(511)]
 * @property string $embed_intouch_message
 * @property string $embed_button_text [varchar(255)]
 * @property string $embed_button_url [varchar(511)]
 * @property int $embed_email_new_leads [smallint(1)]
 * @property string $embed_email_address [varchar(255)]
 * @property int $embed_email_customer [smallint(1)]
 * @property int $embed_email_pdf [smallint(1)]
 * @property string $embed_email_subject [varchar(255)]
 * @property string $embed_email_title [varchar(255)]
 * @property string $embed_email_header_font [varchar(255)]
 * @property string $embed_email_body_font [varchar(255)]
 * @property string $embed_email_content
 * @property string $embed_email_reply_to [varchar(255)]
 * @property int $embed_email_show_logo [smallint(1)]
 * @property string $embed_email_header_background [varchar(7)]
 * @property string $embed_email_header_color [varchar(7)]
 * @property string $embed_email_body_background [varchar(7)]
 * @property string $embed_email_body_color [varchar(7)]
 * @property int $embed_enable_consent [smallint(1)]
 * @property string $embed_consent [varchar(512)]
 * @property string $webhook_pdf [smallint(1)]
 * @property int $tour_step [smallint(1)]
 * @property int $scan_limit [smallint(6)]
 * @property int $scan_page_limit [smallint(6)]
 * @property int $scan_subscription [smallint(6)]
 * @property string $seo_location [varchar(255)]
 * @property int $keywords_limit [int(11)]
 * @property int $keywords_updated_at [int(11)]
 */
class Agency extends \yii\db\ActiveRecord
{
    const SCAN_SUBSCRIPTION_NEVER = 0;
    const SCAN_SUBSCRIPTION_MONTHLY = 1;
    const SCAN_SUBSCRIPTION_WEEKLY = 2;

    const SHOW_TITLE_HIDE = 0;
    const SHOW_TITLE_DEFAULT = 1;
    const SHOW_TITLE_CUSTOM = 2;

    const SHOW_INTRO_HIDE = 0;
    const SHOW_INTRO_DEFAULT = 1;
    const SHOW_INTRO_CUSTOM = 2;

    const DEFAULT_EMBED_EMAIL_HEADER_BACKGROUND = '#ffffff';
    const DEFAULT_EMBED_EMAIL_HEADER_COLOR = '#666666';
    const DEFAULT_EMBED_EMAIL_BODY_BACKGROUND = '#ffffff';
    const DEFAULT_EMBED_EMAIL_BODY_COLOR = '#666666';

    /*
     * empty means system font
     * 'google' means google font
     * 'filename' means font from server
     */
    const FONTS = [
        'Arial' => '',
        'Times New Roman' => '',
        'Verdana' => '',
        'Courier New' => '',

        'Noto Sans' => 'google',
        'Source Sans Pro' => 'google',
        'Roboto' => 'google',
        'Open Sans' => 'google',
        'Lato' => 'google',
        'Roboto Condensed' => 'google',
        'Oswald' => 'google',
        'Montserrat' => 'google',
        'Raleway' => 'google',
        'PT Sans' => 'google',
        'PT Serif' => 'google',
        'Merriweather' => 'google',
        'Roboto Slab' => 'google',
        'Lora' => 'google',
        'Droid Sans' => 'google',
        'Ubuntu' => 'google',
        'Droid Serif' => 'google',
        'Playfair Display' => 'google',
        'Noto Serif' => 'google',
        'Arimo' => 'google',
        'Titillium Web' => 'google',
        'Muli' => 'google',
        'Poppins' => 'google',
        'Indie Flower' => 'google',
        'Bitter' => 'google',
        'Dosis' => 'google',

        'Noto Sans Arabic' => 'notosansarabic.css',
        'Noto Sans Hebrew' => 'notosanshebrew.css',
        'Noto Sans Tagalog' => 'notosanstagalog.css',
        'Noto Sans CJK SC' => 'notosanscjksc.css',
    ]; // en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID vi-VN sk-SK cs-CZ sv-SE da-DK nb-NO el-GR pt-BR
    const LANGUAGES = [
        //'ar-SA' => 'Arabic',
        //'pt-BR' => 'Brazilian Portugese',
        //'cs-CZ' => 'Czech',
        'da-DK' => 'Danish',
        'nl-NL' => 'Dutch',
        //'tl-PH' => 'Filipino (Tagalog)',
        'fr-FR' => 'French',
        'de-DE' => 'German',
        //'el-GR' => 'Greek',
        //'he-IL' => 'Hebrew',
        //'id-ID' => 'Indonesian',
        'it-IT' => 'Italian',
        //'nb-NO' => 'Norwegian',
        'pl-PL' => 'Polish',
        'pt-PT' => 'Portugese',
        'ru-RU' => 'Russian',
        //'zh-CN' => 'Simplified Chinese',
        //'sk-SK' => 'Slovak',
        'es-ES' => 'Spanish',
        //'sv-SE' => 'Swedish',
        //'tr-TR' => 'Turkish',
        //'en-GB' => 'UK English',
        'en-US' => 'US English'
        //'vi-VN' => 'Vietnamese',
    ];

    const FONT_MAPPING = [
        'Arial' => '',
        'Times New Roman' => '',
        'Verdana' => '',
        'Courier New' => '',
        'Roboto' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID vi-VN sk-SK cs-CZ sv-SE da-DK nb-NO el-GR pt-BR',
        'Open Sans' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID vi-VN sk-SK cs-CZ sv-SE da-DK nb-NO el-GR pt-BR',
        'Lato' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL tr-TR id-ID sk-SK cs-CZ sv-SE da-DK nb-NO',
        'Roboto Condensed' => '',
        'Oswald' => '',
        'Source Sans Pro' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID vi-VN sk-SK cs-CZ sv-SE da-DK nb-NO el-GR pt-BR',
        'Montserrat' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID vi-VN sk-SK cs-CZ sv-SE da-DK nb-NO',
        'Raleway' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL tr-TR id-ID sk-SK cs-CZ sv-SE da-DK nb-NO',
        'PT Sans' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID sk-SK cs-CZ sv-SE da-DK nb-NO',
        'PT Serif' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID sk-SK cs-CZ sv-SE da-DK nb-NO',
        'Merriweather' => '',
        'Roboto Slab' => '',
        'Lora' => '',
        'Droid Sans' => '',
        'Ubuntu' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID sk-SK cs-CZ sv-SE da-DK nb-NO el-GR',
        'Droid Serif' => '',
        'Playfair Display' => '',
        'Noto Sans' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID vi-VN sk-SK cs-CZ sv-SE da-DK nb-NO el-GR pt-BR',
        'Noto Serif' => 'en-GB en-US es-ES fr-FR de-DE pt-PT it-IT nl-NL pl-PL ru-RU tr-TR id-ID vi-VN sk-SK cs-CZ sv-SE da-DK nb-NO el-GR pt-BR',
        'Arimo' => '',
        'Titillium Web' => '',
        'Muli' => '',
        'Poppins' => '',
        'Indie Flower' => '',
        'Bitter' => '',
        'Dosis' => '',
        'Noto Sans Arabic' => 'ar-SA',
        'Noto Sans Hebrew' => 'he-IL',
        'Noto Sans Tagalog' => 'tl-PH',
        'Noto Sans CJK SC' => 'zh-CN',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agency_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'doitforme_enable', 'header_enable', 'embed_enable_email', 'embed_enable_phone', 'webhook_status', 'show_details', 'show_title', 'show_intro', 'show_recommendations', 'embed_enable_first_name', 'embed_enable_last_name', 'embed_enable_custom_field', 'embed_enable_button', 'embed_email_new_leads', 'embed_email_customer', 'embed_email_pdf', 'embed_email_show_logo', 'webhook_pdf', 'tour_step', 'embed_enable_consent', 'scan_limit', 'scan_page_limit', 'scan_subscription', 'keywords_limit', 'keywords_updated_at'], 'integer'],
            [['agency_type', 'embed_report_type', 'embed_form_type', 'embed_behaviour', 'checks', 'custom_intro', 'language', 'embed_redirect_url', 'embed_button_url', 'embed_intouch_message', 'embed_email_content'], 'string'],
            [['subdomain', 'company_name', 'company_address', 'company_email', 'company_phone', 'company_website', 'company_logo', 'doitforme_email', 'body_font', 'header_font', 'header_text', 'webhook_url', 'custom_title', 'embed_custom_field', 'embed_button_text', 'embed_email_address', 'embed_email_subject', 'embed_email_title', 'embed_email_header_font', 'embed_email_body_font', 'embed_email_reply_to', 'seo_location'], 'string', 'max' => 255],
            [['embed_consent'], 'string', 'max' => 512],
            [['background_color', 'foreground_color', 'embed_color_btn', 'embed_color_btn_text', 'embed_color_text', 'embed_color_field_borders', 'section_bgcolor', 'section_fgcolor', 'embed_email_header_background', 'embed_email_header_color', 'embed_email_body_background', 'embed_email_body_color'], 'string', 'max' => 7],
            [['embed_redirect_url', 'embed_button_url', 'webhook_url'], 'url', 'message' => 'Please use a full valid URL (including HTTP)'],
            [['subdomain'], 'isValidSubdomain'],
            [['subdomain'], 'unique'],
            [['company_email', 'embed_email_address', 'embed_email_reply_to'], 'email'],
            [['webhook_url'], 'isValidUrl'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'agency_type' => 'Agency Type',
            'subdomain' => 'Subdomain',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'company_email' => 'Company Email',
            'company_phone' => 'Company Phone',
            'company_website' => 'Company Website',
            'company_logo' => 'Company Logo',
            'doitforme_enable' => 'Doitforme Enable',
            'doitforme_email' => 'Doitforme Email',
            'background_color' => 'Background Color',
            'foreground_color' => 'Foreground Color',
            'body_font' => 'Body Font',
            'header_enable' => 'Header Enable',
            'header_text' => 'Header Text',
            'embed_report_type' => 'Embed Report Type',
            'embed_enable_email' => 'Embed Enable Email',
            'embed_enable_phone' => 'Embed Enable Phone',
            'embed_form_type' => 'Embed Form Type',
            'embed_behaviour' => 'Embed Behaviour',
            'webhook_pdf' => 'Webhook PDF Link',
            'embed_color_btn' => 'Embed Color Btn',
            'embed_color_btn_text' => 'Embed Color Btn Text',
            'embed_color_text' => 'Embed Color Text',
            'embed_color_field_borders' => 'Embed Color Field Borders',
            'section_bgcolor' => 'Section Bgcolor',
            'section_fgcolor' => 'Section Fgcolor',
            'webhook_status' => 'Webhook Status',
            'webhook_url' => 'Webhook Url',
            'webhook_pdf' => 'Webhook PDF Link',
            'header_font' => 'Header Font',
            'show_details' => 'Show details',
            'show_title' => 'Report Title Text',
            'show_intro' => 'Introductory Paragraph',
            'show_recommendations' => 'Recommendations',
            'custom_title' => 'Custom Title',
            'custom_intro' => 'Custom Intro',
            'language' => 'Language',
        ];
    }

    public function init()
    {
        parent::init();
        $this->initDefaults();
    }

    public function initDefaults()
    {
        if (is_null($this->doitforme_enable)) $this->doitforme_enable = 1;
        if (is_null($this->background_color)) $this->background_color = "#ebeff2";
        if (is_null($this->foreground_color)) $this->foreground_color = "";
        if (is_null($this->section_bgcolor)) $this->section_bgcolor = "#4c5667";
        if (is_null($this->section_fgcolor)) $this->section_fgcolor = "";
        if (is_null($this->body_font)) $this->body_font = "Noto Sans";
        if (is_null($this->header_font)) $this->header_font = "Open Sans";
        if (is_null($this->header_enable)) $this->header_enable = 1;
        if (is_null($this->header_text)) $this->header_text = "SocialMediaAudit Portal";
        if (is_null($this->webhook_status)) $this->webhook_status = 0;
        if (is_null($this->show_details)) $this->show_details = 0;
        if (is_null($this->webhook_url)) $this->webhook_url = '';
        if (is_null($this->embed_behaviour)) $this->embed_behaviour = 'modal';
        if (is_null($this->embed_report_type)) $this->embed_report_type = 'pdf';
        if (is_null($this->checks)) {
            $checks = include Yii::$app->basePath . '/config/checks.php';
            $this->checks = implode(',', array_keys($checks));
        }
        if (is_null($this->language)) $this->language = 'en-US';
        if (empty($this->embed_email_subject)) $this->embed_email_subject = 'Your Website Audit Results';
        if (empty($this->embed_email_title)) $this->embed_email_title = 'Your Website Audit Results';
        if (empty($this->embed_email_content)) $this->embed_email_content = 'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.';
        if (empty($this->embed_consent)) $this->embed_consent = 'I consent to being added to your mailing list';

        $this->embed_email_header_background = $this->embed_email_header_background ?? self::DEFAULT_EMBED_EMAIL_HEADER_BACKGROUND;
        $this->embed_email_header_color = $this->embed_email_header_color ?? self::DEFAULT_EMBED_EMAIL_HEADER_COLOR;
        $this->embed_email_body_background = $this->embed_email_body_background ?? self::DEFAULT_EMBED_EMAIL_BODY_BACKGROUND;
        $this->embed_email_body_color = $this->embed_email_body_color ?? self::DEFAULT_EMBED_EMAIL_BODY_COLOR;

        if (is_null($this->embed_email_body_font)) $this->embed_email_body_font = "Noto Sans";
        if (is_null($this->embed_email_header_font)) $this->embed_email_header_font = "Source Sans Pro";
        if (is_null($this->seo_location)) $this->seo_location = "United States;US;en";

    }

    public function isValidSubdomain($attribute, $params)
    {
        $subDomain = $this->$attribute;
        if (!$subDomain) {
            return false;
        }
        if (preg_match("/[^A-Za-z0-9-]/", $subDomain)) {
            $this->addError($attribute, "Invalid subdomain (allowed characters: latin letters, numbers, dash)");
        }
        if (in_array($subDomain, array(
            "mail",
            "www",
            "ftp",
        ))) {
            $this->addError($attribute, "This subdomain name is reserved");
        }
    }

    public function isValidUrl($attribute, $params)
    {
        $url = $this->$attribute;
        if (!$url) {
            return false;
        }
        if (strpos($url, 'http') === false) {
            $url = 'http://' . $url;
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (curl_exec($ch) === false) {
            $this->addError($attribute, "Invalid url");
        }
        $this->$attribute = $url;
        curl_close($ch);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), [
            'id' => 'uid',
        ]);
    }

    /**
     * 20.09.2018 @merge_new_seospytool replace all
     *
     * @param $params
     * @return bool
     */
    public function generateLead($params)
    {
        if (!isset($params['domain']) || empty($params['domain'])) {
            return false;
        }
        //if ($email || $phone) {
        $model = new AgencyLead([
            'uid' => $this->uid,
            'email' => isset($params['email']) ? $params['email'] : '',
            'phone' => isset($params['phone']) ? $params['phone'] : '',
            'domain' => isset($params['domain']) ? $params['domain'] : '',
            'first_name' => isset($params['first_name']) ? $params['first_name'] : '',
            'last_name' => isset($params['last_name']) ? $params['last_name'] : '',
            'custom_field' => isset($params['custom_field']) ? $params['custom_field'] : '',
            'consent' => isset($params['consent']) ? $params['consent'] : 0,
            'ip' => isset($params['ip']) ? $params['ip'] : null,
        ]);
        $model->save();

        // send to agency
        $customerEmail = $this->embed_email_address;
        if (empty($customerEmail)) {
            $customerEmail = $this->company_email;
        }
        if ($this->embed_email_new_leads && $customerEmail) {
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'newLead-html'],
                    ['model' => $model, 'agency' => $this, 'title' => 'New Lead']
                )
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
                ->setTo($customerEmail)
                ->setSubject('New Lead')
                ->send();
        }

        return $model->id;
    }

    public function emailCustomer($leadEmail, $filename = null)
    {
        // send to lead
        if ($this->embed_email_customer && $leadEmail) {
            $mail = Yii::$app
                ->mailer
                ->compose(
                    [
                        'html' => 'custom-html',
                    ],
                    [
                        'model' => $this,
                        'title' => $this->embed_email_title,
                    ]
                )
                ->setFrom([
                    Yii::$app->params['auditResultEmailFrom'] => Yii::$app->params['auditResultFrom'],
                ])
                ->setTo($leadEmail)
                ->setSubject($this->embed_email_subject);
            if ($this->embed_email_pdf && null !== $filename) {
                $mail->attach($filename, [
                    'fileName' => 'report.pdf',
                    'contentType' => 'application/pdf',
                ]);
            }
            if (!empty($this->embed_email_reply_to)) {
                $mail->setReplyTo($this->embed_email_reply_to);
            }

            $mail->send();
        }
    }

    /**
     * @return string
     */
    public function getSubdomainUrl()
    {
        $parts = parse_url(Yii::$app->request->hostInfo);
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $parts['host'], $mainDomainMatches);

        return $parts['scheme'] . "://" . strtolower($this->subdomain) . '.' . $mainDomainMatches[0];
    }

    public function sendWebhook($leadId, $pdfLink = null)
    {
        if ($this->webhook_status && !empty($this->webhook_url)) {
            $model = AgencyLead::findOne($leadId);
            if (!empty($model)) {
                $postdata = "email={$model->email}&website={$model->domain}&key=" . md5($this->uid . 'jh5jgt54jgh'); //@hardcoded
                if (!empty($model->phone)) {
                    $postdata .= "&phone=" . $model->phone;
                }
                if (!empty($model->first_name)) {
                    $postdata .= "&first_name={$model->first_name}";
                }
                if (!empty($model->last_name)) {
                    $postdata .= "&last_name={$model->last_name}";
                }
                if (!empty($model->custom_field)) {
                    $postdata .= "&custom_field={$model->custom_field}";
                }
                if (!empty($pdfLink)) {
                    $postdata .= "&pdf={$pdfLink}";
                }
                return self::webhookCall($this->webhook_url, $postdata);
            }
        }
        return false;
    }

    private static function webhookCall($url, $postdata)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($curl, CURLOPT_USERAGENT, 'api');
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 20);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($curl);
        $result = curl_getinfo($curl);
        curl_close($curl);
        return $result;
    }

    public function getFontsUrls($selected = false)
    {
        $results = [];
        $googleFonts = [];
        foreach (self::FONTS as $font => $source) {
            // skip not selected fonts
            if ($selected && !in_array($font, [$this->header_font, $this->body_font])) {
                continue;
            }
            // skip system fonts
            if (empty($source)) {
                continue;
            } elseif ($source === 'google') {
                $googleFonts[] = $font;
            } else {
                $results[] = '/css/' . $source;
            }// collect google fonts
        }
        if (!empty($googleFonts)) {
            $results[] = '//fonts.googleapis.com/css?family=' . urlencode(implode('|', $googleFonts));
        }
        return $results;
    }


    /**
     * @return string
     */
    public function getCompany_logo_url()
    {
        return !empty($this->company_logo) ? ('/upload/' . $this->company_logo) : $this->company_logo;
    }

    /**
     * @return string
     */
    public static function generateHtmlFontList()
    {
        $fontList = '';
        foreach (self::FONTS as $font => $source) {
            $style = 'font-family: "' . $font . '"; ';
            $fontList .= "<li" . (isset(self::FONT_MAPPING[$font]) ? ' class="' . self::FONT_MAPPING[$font] . '"' : '') . "><a href='#' data-font='$font' style='$style' onclick='return false;'>$font</a></li>";
        }
        return $fontList;

    }

    /**
     * @return string
     */
    public function getBody_font_style()
    {
        if ($this->body_font) {
            return "font-family: '{$this->body_font}' !important;";
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getHeader_font_style()
    {
        if ($this->header_font) {
            return "font-family: '{$this->header_font}' !important;";
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getCustom_title_filtered()
    {
        if ($this->show_title == 2 && !empty($this->custom_title)) {
            $title = nl2br($this->custom_title);
        } else {
            $title = Yii::t('report', 'Website Report for [url]');
        }

        return $title;
    }

    /**
     * @return string
     */
    public function getCustom_intro_filtered()
    {
        if ($this->show_intro == 2 && !empty($this->custom_intro)) {
            $title = nl2br($this->custom_intro);
        } else {
            $title = Yii::t('report', 'This report grades your website on the strength of a range of important factors such as on-page SEO optimization, off-page backlinks, social, performance, security and more. The overall grade is on a A+ to F- scale, with most major industry leading websites in the A range. Improving a website\'s grade is recommended to ensure a better website experience for your users and improved ranking and visibility by search engines.');
        }

        return $title;
    }
}
