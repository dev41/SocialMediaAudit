<?php

use yii\db\Migration;

class m190326_112246_main__init extends Migration
{
    public function safeUp()
    {
        $this->execute('
       
        SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
        START TRANSACTION;
        SET time_zone = "+00:00";

        -- --------------------------------------------------------
       
        CREATE TABLE `ca_agency_audits` (
          `uid` int(10) UNSIGNED NOT NULL,
          `domain` varchar(90) NOT NULL,
          `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        -- --------------------------------------------------------

        CREATE TABLE `ca_agency_leads` (
          `id` int(10) UNSIGNED NOT NULL,
          `uid` int(10) UNSIGNED NOT NULL,
          `email` varchar(255) DEFAULT NULL,
          `phone` varchar(30) DEFAULT NULL,
          `domain` varchar(90) NOT NULL,
          `arrived` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `first_name` varchar(255) DEFAULT NULL,
          `last_name` varchar(255) DEFAULT NULL,
          `custom_field` varchar(255) DEFAULT NULL,
          `consent` smallint(1) DEFAULT \'0\',
          `ip` varchar(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        -- --------------------------------------------------------
        
        CREATE TABLE `ca_agency_profile` (
          `uid` int(10) UNSIGNED NOT NULL,
          `agency_type` varchar(64) DEFAULT NULL,
          `subdomain` varchar(255) DEFAULT NULL,
          `company_name` varchar(255) DEFAULT NULL,
          `company_address` varchar(255) DEFAULT NULL,
          `company_email` varchar(255) DEFAULT NULL,
          `company_phone` varchar(255) DEFAULT NULL,
          `company_website` varchar(255) DEFAULT NULL,
          `company_logo` varchar(255) DEFAULT NULL,
          `doitforme_enable` tinyint(1) NOT NULL DEFAULT \'0\',
          `doitforme_email` varchar(255) DEFAULT NULL,
          `background_color` varchar(7) DEFAULT NULL,
          `foreground_color` varchar(7) DEFAULT NULL,
          `body_font` varchar(255) DEFAULT NULL,
          `header_font` varchar(255) DEFAULT NULL,
          `header_enable` tinyint(1) NOT NULL DEFAULT \'0\',
          `header_text` varchar(255) DEFAULT NULL,
          `embed_report_type` enum(\'web\',\'pdf\') NOT NULL DEFAULT \'web\',
          `embed_enable_email` tinyint(1) NOT NULL DEFAULT \'1\',
          `embed_enable_phone` tinyint(1) NOT NULL DEFAULT \'0\',
          `embed_form_type` enum(\'row_large\',\'row_slim\',\'column_large\',\'column_slim\') NOT NULL DEFAULT \'row_large\',
          `embed_behaviour` enum(\'new_tab\',\'modal\',\'be_in_touch\',\'redirect\') DEFAULT NULL,
          `embed_color_btn` varchar(7) NOT NULL DEFAULT \'#25b36f\',
          `embed_color_btn_text` varchar(7) NOT NULL DEFAULT \'#ffffff\',
          `embed_color_text` varchar(7) NOT NULL DEFAULT \'#565656\',
          `embed_color_field_borders` varchar(7) NOT NULL DEFAULT \'#e3e3e3\',
          `section_bgcolor` varchar(7) DEFAULT NULL,
          `section_fgcolor` varchar(7) DEFAULT NULL,
          `webhook_status` tinyint(1) NOT NULL DEFAULT \'0\',
          `webhook_url` varchar(255) DEFAULT NULL,
          `show_details` int(1) UNSIGNED DEFAULT \'0\',
          `checks` text,
          `show_title` smallint(1) DEFAULT \'1\',
          `show_intro` smallint(1) DEFAULT \'1\',
          `show_recommendations` smallint(1) DEFAULT \'1\',
          `custom_title` varchar(255) DEFAULT NULL,
          `custom_intro` text,
          `language` varchar(255) NOT NULL DEFAULT \'en-US\',
          `embed_enable_first_name` smallint(1) NOT NULL DEFAULT \'0\',
          `embed_enable_last_name` smallint(1) NOT NULL DEFAULT \'0\',
          `embed_enable_custom_field` smallint(1) NOT NULL DEFAULT \'0\',
          `embed_enable_button` smallint(1) NOT NULL DEFAULT \'0\',
          `embed_custom_field` varchar(255) DEFAULT NULL,
          `embed_redirect_url` varchar(511) DEFAULT NULL,
          `embed_intouch_message` text,
          `embed_button_text` varchar(255) DEFAULT NULL,
          `embed_button_url` varchar(511) DEFAULT NULL,
          `embed_email_new_leads` smallint(1) NOT NULL DEFAULT \'1\',
          `embed_email_address` varchar(255) DEFAULT NULL,
          `embed_email_customer` smallint(1) NOT NULL DEFAULT \'0\',
          `embed_email_pdf` smallint(1) NOT NULL DEFAULT \'0\',
          `embed_email_subject` varchar(255) DEFAULT NULL,
          `embed_email_title` varchar(255) DEFAULT NULL,
          `embed_email_header_font` varchar(255) DEFAULT NULL,
          `embed_email_body_font` varchar(255) DEFAULT NULL,
          `embed_email_content` text,
          `embed_email_reply_to` varchar(255) DEFAULT NULL,
          `embed_email_show_logo` smallint(1) NOT NULL DEFAULT \'1\',
          `embed_email_header_background` varchar(7) DEFAULT NULL,
          `embed_email_header_color` varchar(7) DEFAULT NULL,
          `embed_email_body_background` varchar(7) DEFAULT NULL,
          `embed_email_body_color` varchar(7) DEFAULT NULL,
          `webhook_pdf` smallint(1) DEFAULT \'0\',
          `tour_step` smallint(1) DEFAULT \'1\',
          `embed_enable_consent` smallint(1) NOT NULL DEFAULT \'0\',
          `embed_consent` varchar(512) DEFAULT NULL,
          `scan_limit` smallint(6) NOT NULL DEFAULT \'4\',
          `scan_page_limit` smallint(6) NOT NULL DEFAULT \'100\',
          `scan_subscription` smallint(6) NOT NULL DEFAULT \'2\',
          `seo_location` varchar(255) DEFAULT NULL,
          `keywords_limit` int(11) DEFAULT \'20\',
          `keywords_updated_at` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
       
        INSERT INTO `ca_agency_profile` (`uid`, `agency_type`, `subdomain`, `company_name`, `company_address`, `company_email`, `company_phone`, `company_website`, `company_logo`, `doitforme_enable`, `doitforme_email`, `background_color`, `foreground_color`, `body_font`, `header_font`, `header_enable`, `header_text`, `embed_report_type`, `embed_enable_email`, `embed_enable_phone`, `embed_form_type`, `embed_behaviour`, `embed_color_btn`, `embed_color_btn_text`, `embed_color_text`, `embed_color_field_borders`, `section_bgcolor`, `section_fgcolor`, `webhook_status`, `webhook_url`, `show_details`, `checks`, `show_title`, `show_intro`, `show_recommendations`, `custom_title`, `custom_intro`, `language`, `embed_enable_first_name`, `embed_enable_last_name`, `embed_enable_custom_field`, `embed_enable_button`, `embed_custom_field`, `embed_redirect_url`, `embed_intouch_message`, `embed_button_text`, `embed_button_url`, `embed_email_new_leads`, `embed_email_address`, `embed_email_customer`, `embed_email_pdf`, `embed_email_subject`, `embed_email_title`, `embed_email_header_font`, `embed_email_body_font`, `embed_email_content`, `embed_email_reply_to`, `embed_email_show_logo`, `embed_email_header_background`, `embed_email_header_color`, `embed_email_body_background`, `embed_email_body_color`, `webhook_pdf`, `tour_step`, `embed_enable_consent`, `embed_consent`, `scan_limit`, `scan_page_limit`, `scan_subscription`, `seo_location`, `keywords_limit`, `keywords_updated_at`) VALUES
        (60, \'full\', \'seoptimer455\', \'TEST\', \'\', \'\', \'\', \'\', \'1543215817-promo-logo.png\', 0, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Noto Sans\', 0, \'Seoptimer Portal\', \'pdf\', 1, 1, \'row_large\', \'modal\', \'#4c876b\', \'#000000\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 1, \'http://note.ly/~sandbox/testcall.php\', 0, \'twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn,socialActivity,subpages\', 2, 1, 1, \'THIS IS MY TEXT\', \'This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!This is my custom text! This is my custom text! This is my custom text!\', \'en-US\', 0, 0, 0, 1, \'CUSTOM FIELD\', \'\', \'\', \'Improve Your Website\', \'http://cnn.com\', 1, \'info@seoptimer.com\', 1, 1, \'Welcome\', \'Thanks!\', \'Open Sans\', \'Open Sans\', \'Thanks for your \', \'\', 1, \'#d4d4d4\', \'#ffffff\', \'#fdfdfd\', \'#000000\', 1, 0, 1, \'I consent to being added to your mailing list\', 2000, 100, 2, \'United Kingdom;GB;en\', 20, 1537326418),
        (354, \'full\', \'dev\', \'test2\', \'test\', \'\', \'test\', \'test\', \'1542279730-SEOptimer - Bulk Loading Interface Mockup.png\', 0, NULL, \'#ffffff\', \'#5d9cec\', \'Montserrat\', \'Ubuntu\', 0, \'Seoptimer Portal\', \'web\', 1, 0, \'column_slim\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 1, \'\', 1, \'hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn,socialActivity,subpages\', 1, 1, 1, \'Website Report for [url]\', \'This report grades your website based on the strength of various SEO factors such as On Page Optimization, Off Page Links, Social and more. The overall Grade is on a A+ to F- scale, with most major, industry leading websites in the A range. Improving your grade will generally make your website perform better for users and rank better in search engines. There are recommendations for improving your website at the bottom of the report. Feel free to reach out to us if you’d like us to help with improving your website’s SEO!\', \'ru-RU\', 0, 0, 0, 0, \'мое поле\', \'https://nowhere.com/test\', \'my message\', \'кнопка\', \'http://test.com\', 1, \'rkoblev@gmail.com\', 1, 1, \'test subh\', \'email title\', \'Roboto\', \'Roboto\', \'Here is your pdf attached\', \'stryder123@bk.ru\', 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 1, 0, 0, \'I consent to being added to your mailing list\', 4, 100, 1, \'Bosnia and Herzegovina;BA;bs\', 20, 1538041890),
        (1680, \'basicPlan\', \'admin1680\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'web\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'title,description,keywords,hasHeaders,contentCount,hasSitemap,hasRobotsTxt,hasAnalytics,hasBrokenLinks,hasFriendlyUrl,backlinks,onPageLinks,hasImageWithoutAlt,hasDeprecated,hasInlineCss,hasGzip,hasW3c,hasMinified,hasOptimizedImages,numberOfResources,pageSize,serverResponseTime,javascriptErrors,hasFlash,hasIframe,hasFavicon,hasLegibleFontsizes,hasMobileViewports,hasTapTargetSizing,deviceRendering,socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn,hasHttpsRedirect,hasMalware,hasEmail,hasSsl,hasOutdatedApps,technologies,ip,dns,webServer,charset,subpages\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, 4, 100, 2, NULL, 20, NULL),
        (1934, \'basicPlan\', \'asdasd\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'asdasd@asdasd.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1935, \'basicPlan\', \'tfytytfy\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'yfytftyf@tfytytfy.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1936, \'DIYPlan\', \'bububu\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'bubuyb@bububu.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1937, \'advancedPlan\', \'jhbjhbjhbj\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'jhbjhbjh@jhbjhbjhbj.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1938, \'DIYPlan\', \'gfcgfcgf\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'gfcgfcgf@gfcgfcgf.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1939, \'basicPlan\', \'fcfgfcfytfy\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'ftyfyfyt@fcfgfcfytfy.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1940, \'DIYPlan\', \'dftrdtrdtr\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'dtdtdtrdt@dftrdtrdtr.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1941, \'basicPlan\', \'ststrstrst\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'rrydydytd@ststrstrst.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1942, \'DIYPlan\', \'ytftyfytf\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'tyfytfytf@Ytftyfytf.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1943, \'DIYPlan\', \'yrdyry\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'dedytrdyt@yrdyry.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1944, \'basicPlan\', \'hgvjhgv\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'utyfuytfyut@hgvjhgv.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1945, \'basicPlan\', \'hgbewre\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'uyguyg@hgbewre.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1946, \'basicPlan\', \'errewrwerewr\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'jhgjhgjhg@errewrwerewr.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1947, \'DIYPlan\', \'ereterret\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adfgag@ereterret.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1948, \'DIYPlan\', \'uyguyguy\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'uyguyg@uyguyguy.ru\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1949, \'basicPlan\', \'test\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'testcookie1@test.org\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1950, \'basicPlan\', \'test1950\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'konstantin@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1951, \'basicPlan\', \'test1951\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'testcookie6@test.org\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1952, \'basicPlan\', \'test1952\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'testcookie8@test.org\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1953, \'basicPlan\', \'test1953\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_test_1@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1954, \'basicPlan\', \'test2\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_test1@test2.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1955, \'advancedPlan\', \'test1955\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_test2@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1956, \'basicPlan\', \'test1956\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'testcookie18@test.org\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1957, \'basicPlan\', \'test1957\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'testcookie28@test.org\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1958, \'basicPlan\', \'test1958\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'19j19_adam@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1959, \'basicPlan\', \'test1959\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_test_smay3@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1960, \'basicPlan\', \'test1960\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_sma_u1@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1961, \'basicPlan\', \'test1961\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_sma2@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1962, \'basicPlan\', \'test1962\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_sma1@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1963, \'basicPlan\', \'test24\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'test@test24.org\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1964, \'basicPlan\', \'test1964\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_x1@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1965, \'basicPlan\', \'test1965\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'adam_retest_100@test.com\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL),
        (1966, \'advancedPlan\', \'tanya\', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, \'#ebeff2\', \'\', \'Noto Sans\', \'Source Sans Pro\', 1, \'Seoptimer Portal\', \'pdf\', 1, 0, \'row_large\', \'modal\', \'#25b36f\', \'#ffffff\', \'#565656\', \'#e3e3e3\', \'#4c5667\', \'#ffffff\', 0, \'\', 0, \'socialActivity,hasFacebook,facebookActivity,hasTwitter,twitterActivity,hasGooglePlus,googlePlusActivity,hasInstagram,instagramActivity,hasYoutube,youtubeActivity,hasLinkedIn\', 1, 1, 1, NULL, NULL, \'en-US\', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, \'tanya.v.nazarchuk@goldensoft.com.ua\', 0, 0, \'Your Website Audit Results\', \'Your Website Audit Results\', \'Source Sans Pro\', \'Noto Sans\', \'Thank you for submitting our Website Audit Form. We want to help you get the most from your website. A staff member will be in touch to discuss the results with you.\', NULL, 1, \'#66a1e9\', \'#ffffff\', \'#fdfdfd\', \'#737373\', 0, 1, 0, \'I consent to being added to your mailing list\', 4, 100, 2, \'United States;US;en\', 20, NULL);
        
        -- --------------------------------------------------------
        
        CREATE TABLE `ca_auth_assignment` (
          `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
          `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
          `created_at` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        
        INSERT INTO `ca_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
        (\'administrator\', \'1950\', 1545123982),
        (\'advancedPlan\', \'1934\', 1543326782),
        (\'advancedPlan\', \'1937\', 1544701420),
        (\'advancedPlan\', \'1950\', 1545123959),
        (\'advancedPlan\', \'1955\', 1545646432),
        (\'advancedPlan\', \'1966\', 1549006022),
        (\'basicPlan\', \'1934\', 1543326755),
        (\'basicPlan\', \'1935\', 1544699334),
        (\'basicPlan\', \'1939\', 1544703952),
        (\'basicPlan\', \'1941\', 1544706338),
        (\'basicPlan\', \'1944\', 1544787389),
        (\'basicPlan\', \'1945\', 1544792561),
        (\'basicPlan\', \'1946\', 1544793223),
        (\'basicPlan\', \'1949\', 1544798249),
        (\'basicPlan\', \'1951\', 1545241195),
        (\'basicPlan\', \'1952\', 1545400821),
        (\'basicPlan\', \'1953\', 1545645397),
        (\'basicPlan\', \'1954\', 1545646032),
        (\'basicPlan\', \'1956\', 1547028745),
        (\'basicPlan\', \'1957\', 1547035302),
        (\'basicPlan\', \'1958\', 1547445738),
        (\'basicPlan\', \'1959\', 1547606302),
        (\'basicPlan\', \'1960\', 1547606407),
        (\'basicPlan\', \'1961\', 1547606673),
        (\'basicPlan\', \'1962\', 1547606826),
        (\'basicPlan\', \'1963\', 1547625911),
        (\'basicPlan\', \'1964\', 1547628187),
        (\'basicPlan\', \'1965\', 1547792778),
        (\'superAdministrator\', \'1680\', 1528108322),
        (\'superAdministrator\', \'1966\', 1549006057),
        (\'superAdministrator\', \'354\', 1528108322),
        (\'superAdministrator\', \'60\', 1528108322);
        
        -- --------------------------------------------------------
        
        CREATE TABLE `ca_auth_item` (
          `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
          `type` smallint(6) NOT NULL,
          `description` text COLLATE utf8_unicode_ci,
          `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
          `data` blob,
          `created_at` int(11) DEFAULT NULL,
          `updated_at` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
       
        INSERT INTO `ca_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
        (\'administrator\', 1, \'Administrator\', NULL, NULL, 1507806830, 1528300928),
        (\'advancedPlan\', 1, \'PDF Whitelabel & Embedding Plan\', NULL, NULL, 1507806830, 1507806830),
        (\'basicPlan\', 1, \'PDF Whitelabel Plan\', NULL, NULL, 1507806830, 1507806830),
        (\'Reseller\', 1, \'Partner/Reseller\', NULL, NULL, 1535619956, 1535619956),
        (\'superAdministrator\', 1, \'Super Administrator\', NULL, NULL, 1528108322, 1528300928);
        
        -- --------------------------------------------------------
       
        CREATE TABLE `ca_auth_item_child` (
          `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
          `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
       
        INSERT INTO `ca_auth_item_child` (`parent`, `child`) VALUES
        (\'superAdministrator\', \'administrator\'),
        (\'administrator\', \'advancedPlan\'),
        (\'advancedPlan\', \'basicPlan\');
        
        -- --------------------------------------------------------
       
        CREATE TABLE `ca_auth_rule` (
          `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
          `data` blob,
          `created_at` int(11) DEFAULT NULL,
          `updated_at` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        
        -- --------------------------------------------------------
        
        CREATE TABLE `ca_check` (
          `id` int(11) NOT NULL,
          `name` varchar(255) NOT NULL,
          `wid` int(11) NOT NULL,
          `data` longtext,
          `value` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        -- --------------------------------------------------------
        
        CREATE TABLE `ca_queue` (
          `id` int(11) NOT NULL,
          `channel` varchar(255) NOT NULL,
          `job` blob NOT NULL,
          `pushed_at` int(11) NOT NULL,
          `ttr` int(11) NOT NULL,
          `delay` int(11) NOT NULL DEFAULT \'0\',
          `priority` int(11) UNSIGNED NOT NULL DEFAULT \'1024\',
          `reserved_at` int(11) DEFAULT NULL,
          `attempt` int(11) DEFAULT NULL,
          `done_at` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        -- --------------------------------------------------------
        
        CREATE TABLE `ca_user` (
          `id` int(11) NOT NULL,
          `username` varchar(128) NOT NULL,
          `password` varchar(128) NOT NULL,
          `email` varchar(128) NOT NULL,
          `profile` text,
          `website` varchar(128) NOT NULL,
          `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `date_delete` int(12) UNSIGNED DEFAULT NULL,
          `date_suspend` int(12) UNSIGNED DEFAULT NULL,
          `token` varchar(150) NOT NULL,
          `active` tinyint(1) NOT NULL DEFAULT \'1\',
          `note` text,
          `consent` smallint(1) DEFAULT \'0\',
          `consent_newsletter` smallint(1) DEFAULT \'0\',
          `reseller_id` int(11) DEFAULT NULL,
          `access_token` varchar(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        INSERT INTO `ca_user` (`id`, `username`, `password`, `email`, `profile`, `website`, `last_login`, `date_delete`, `date_suspend`, `token`, `active`, `note`, `consent`, `consent_newsletter`, `reseller_id`, `access_token`) VALUES
        (60, \'adam\', \'$2y$13$g8QuY/JjM8Iqburw3zQ/kOq5cUbpO3hIGTeOirFKVaEmiGSmfhKRu\', \'adam@seoptimer.com\', NULL, \'\', \'2019-02-01 07:26:22\', NULL, NULL, \'GhoDYl7G1dUe2lFQRowAy33Lot6v-YCn_1543326830\', 1, NULL, 0, 0, NULL, NULL),
        (354, \'Roman\', \'$2y$13$MEWzQ19s2F6QxJvP.ZGUiuFGL90OGUMn3heMHDX6Y9xN0FjBvQ20u\', \'rkoblev@gmail.com\', NULL, \'\', \'2018-11-26 18:29:02\', NULL, NULL, \'b7R5_O0RK1pKpBa2zOjN4OCZVeBcG15u_1543256942\', 1, NULL, 0, 0, NULL, NULL),
        (1680, \'Administrator\', \'$2y$13$0tz0SL2PuN7G.3US.Bsl2OK0uizKwCAaF3AMJe4hW9keZbs3Y5/g2\', \'admin@seoptimer.com\', NULL, \'\', \'2018-11-26 18:22:51\', NULL, NULL, \'\', 1, NULL, 0, 0, NULL, NULL),
        (1934, \'adasd\', \'$2y$13$L6Sucw/dqx7PVgTQqTulCuIQynBMylSHmL5yFP1Y7NLD8LTMpJgH2\', \'asdasd@asdasd.com\', NULL, \'\', \'2018-11-27 13:53:02\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, \'vitya\'),
        (1935, \'yfytftyf@tfytytfy.ru\', \'$2y$13$o9ETXnfoKmhZuqv6f44pzOR9m09zd4jqWDt6tv5Fq1Zk9G7Wdohqm\', \'yfytftyf@tfytytfy.ru\', NULL, \'\', \'2018-12-27 15:37:48\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1936, \'bubuyb@bububu.ru\', \'$2y$13$yfa0nrjv0QvhCFgjSzGobuAsIV8NiYUWrD3hwTOm07YJwcTs0FWeS\', \'bubuyb@bububu.ru\', NULL, \'\', \'2018-12-27 15:37:49\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1937, \'jhbjhbjh@jhbjhbjhbj.ru\', \'$2y$13$3k2U7difaTf6JbR07Qzj3urxP5VaQtdjq/YjAz1yiG.OiCqkiVUTa\', \'jhbjhbjh@jhbjhbjhbj.ru\', NULL, \'\', \'2018-12-27 15:37:49\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1938, \'gfcgfcgf@gfcgfcgf.ru\', \'$2y$13$6cffLx7fccPGZkQtO3fzuefJOgWZwd.14lgcufGRoR2Et8Wls/sGW\', \'gfcgfcgf@gfcgfcgf.ru\', NULL, \'\', \'2018-12-27 15:37:50\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1939, \'ftyfyfyt@fcfgfcfytfy.ru\', \'$2y$13$OM.pnuZSZ4kTKe0e7CssdOC4/AfKgemOWwESIa63E/hFhuZLoFxV6\', \'ftyfyfyt@fcfgfcfytfy.ru\', NULL, \'\', \'2018-12-27 15:37:50\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1940, \'dtdtdtrdt@dftrdtrdtr.ru\', \'$2y$13$mf7J1EWwl6lTaiaSLUSZ8.ztjne4eDUddqegsSbd5YWj7vLr2lc2i\', \'dtdtdtrdt@dftrdtrdtr.ru\', NULL, \'\', \'2018-12-27 15:37:51\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1941, \'rrydydytd@ststrstrst.ru\', \'$2y$13$Qcq0BuxbGcM5kneHV4CQteN9qvcwGegSm56frMwJFEPZ7bpDNRR32\', \'rrydydytd@ststrstrst.ru\', NULL, \'\', \'2018-12-27 15:37:52\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1942, \'tyfytfytf@Ytftyfytf.ru\', \'$2y$13$6WYzm8wAp9lWNhqjrxcLjOemIcjJKvUNt7/XuZQZhCvOmzi4osw6G\', \'tyfytfytf@Ytftyfytf.ru\', NULL, \'\', \'2018-12-27 15:37:52\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1943, \'dedytrdyt@yrdyry.ru\', \'$2y$13$MX2m4Ep/lOGOI/vILa4lUOrUMhXd9YzLWrcxNgUzZQGu5rp63uVJS\', \'dedytrdyt@yrdyry.ru\', NULL, \'\', \'2018-12-27 15:37:53\', NULL, 1545868800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1944, \'utyfuytfyut@hgvjhgv.ru\', \'$2y$13$NIkfbaKAg2eb04eSvFE4M.WlnwsjeXcWV.blv6OilJes5S6PJ1jna\', \'utyfuytfyut@hgvjhgv.ru\', NULL, \'\', \'2018-12-14 11:36:29\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1945, \'uyguyg@hgbewre.ru\', \'$2y$13$G1WnIZtOpWsbwIePfwczR.UkGurvt0lzQ.e.E2IjYiNmkg7Xz.Sni\', \'uyguyg@hgbewre.ru\', NULL, \'\', \'2018-12-14 13:02:41\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1946, \'jhgjhgjhg@errewrwerewr.ru\', \'$2y$13$tHZyrF/Ls8lRZ39lyf3VK.naw.xrviSXTdQ3FqJvezR7.80dXtQma\', \'jhgjhgjhg@errewrwerewr.ru\', NULL, \'\', \'2018-12-14 13:13:43\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1947, \'adfgag@ereterret.ru\', \'$2y$13$D1RidQlDqhVRILk6cHL6SeSAhJR4CNrH5rv0tn5dvlRssZDK1MDnK\', \'adfgag@ereterret.ru\', NULL, \'\', \'2018-12-14 13:24:33\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1948, \'uyguyg@uyguyguy.ru\', \'$2y$13$/q2L8uyukSusEq7ubp77COjDb8luKwRMudldYMwFIPgUDHvjR93Kq\', \'uyguyg@uyguyguy.ru\', NULL, \'\', \'2018-12-14 14:12:19\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1949, \'testcookie1@test.org\', \'$2y$13$/Xg1gUFrLzdUWochITb4uuaULmEfyErcnC059ovmjfGNykPU8MW2a\', \'testcookie1@test.org\', NULL, \'\', \'2018-12-19 12:05:23\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1950, \'Konstantin\', \'$2y$13$0VRByJ/yFWYZ5uETvsoQmuQwAHEhsDDYIBUnU.QDCXlCkyhlt0BwG\', \'konstantin@test.com\', NULL, \'\', \'2019-01-16 07:55:09\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1951, \'testcookie6@test.org\', \'$2y$13$ShrtfVkM6m1T12E7Hj8JpeAzhRuOuwJBLpL4dlIkedBsceVc5IK1C\', \'testcookie6@test.org\', NULL, \'\', \'2019-01-02 22:17:08\', NULL, 1546387200, \'\', 1, \'jjj\', 1, 0, NULL, NULL),
        (1952, \'testcookie8@test.org\', \'$2y$13$IoThcyV3tRhvWayxq4a8Ju8LG9WDe18uuRP68wgVXFq6XFiDWFwGW\', \'testcookie8@test.org\', NULL, \'\', \'2019-01-04 14:28:45\', NULL, 1546560000, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1953, \'adam_test_1@test.com\', \'$2y$13$AeZd1PJg5Ikq4aC5V6tdu.EM42tvrX62DfmbnDHGYE5tgtzrGiWo6\', \'adam_test_1@test.com\', NULL, \'\', \'2019-01-07 13:57:44\', NULL, 1546819200, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1954, \'adam_test1@test2.com\', \'$2y$13$crEa83B.VkqChmbDvPcT7uDx0BzDmHuDXNln1ucxRPIq5BG/Eth0G\', \'adam_test1@test2.com\', NULL, \'\', \'2018-12-24 10:10:51\', NULL, 1545609600, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1955, \'adam_test2@test.com\', \'$2y$13$PFXZ6/McW7kOJRDumlvWnOyYz3Fs.rd5TGGCEkXjy8h0CVOHqMKmC\', \'adam_test2@test.com\', NULL, \'\', \'2018-12-24 10:13:52\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1956, \'testcookie18@test.org\', \'$2y$13$HSiAmmE2kPHZckTTJH7Q/.G2Nr8rYTgMh90cjVoBywgMhUU0z0e3e\', \'testcookie18@test.org\', NULL, \'\', \'2019-01-23 10:13:19\', NULL, 1548201600, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1957, \'testcookie28@test.org\', \'$2y$13$UbZIc15YEaNlUibIaU4cleoQkCBZd8B1PJnkCcna1m/3MYxbNicvO\', \'testcookie28@test.org\', NULL, \'\', \'2019-01-09 12:01:42\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1958, \'19j19_adam@test.com\', \'$2y$13$fWQobvrKqBaprI7fNp/FlO.h7u.RxStnF90kA4NpbGx4ThNPQU/fa\', \'19j19_adam@test.com\', NULL, \'\', \'2019-01-14 06:05:54\', NULL, NULL, \'\', 1, \'\', 1, 0, NULL, NULL),
        (1959, \'adam_test_smay3@test.com\', \'$2y$13$.hB2/qNs1wlG4pzf89jtV.coXNt5Octhu6QZ7pCrzDQAen.3ryLei\', \'adam_test_smay3@test.com\', NULL, \'\', \'2019-01-30 07:43:41\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1960, \'adam_sma_u1@test.com\', \'$2y$13$mW2Nydk5TXXDFDMxxExF5O7CEv84PiHVRS9cuQ66KunNRWxMso4fm\', \'adam_sma_u1@test.com\', NULL, \'\', \'2019-01-30 07:43:45\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1961, \'adam_sma2@test.com\', \'$2y$13$Zb8nv.kA9QYJvsAnTF7Oa.QtfUQOmfy4kvTGQzIfyJAR2FgWN4eOS\', \'adam_sma2@test.com\', NULL, \'\', \'2019-01-30 07:43:48\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1962, \'adam_sma1@test.com\', \'$2y$13$s5QeJ8eyLSuCYaFOQ/Hrc.Gliu1mhccj2LS9lpLswA7iSgYefK.z.\', \'adam_sma1@test.com\', NULL, \'\', \'2019-01-29 19:40:45\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1963, \'test@test24.org\', \'$2y$13$QFqCZNOR3JrNH7zyUrkv5OyUuoHGlxqi4Cc13ZVef8Q0YMUE358Qe\', \'test@test24.org\', NULL, \'\', \'2019-01-16 08:06:30\', NULL, 1547596800, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1964, \'adam_x1@test.com\', \'$2y$13$T5q0t1NVtX6l2CSzeQ7yh.W9/4E8qyH6IR/K7tzF/SQL3/uby9pdG\', \'adam_x1@test.com\', NULL, \'\', \'2019-01-16 08:45:53\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL),
        (1965, \'adam_retest_100@test.com\', \'$2y$13$tctHir8XkoR8VOspLbrLEe2qsqtfatd.T5yzN1HB6twFUUGmDcTmu\', \'adam_retest_100@test.com\', NULL, \'\', \'2019-01-18 06:37:35\', NULL, NULL, \'\', 1, \'TEST\', 1, 0, NULL, NULL),
        (1966, \'Tanya\', \'$2y$13$tzZOnOzfajkeyJgGkgVxP.6BpT6acIgzkgwpCMuMLV5m/aWxXfDEW\', \'tanya.v.nazarchuk@goldensoft.com.ua\', NULL, \'\', \'2019-02-03 17:37:13\', NULL, NULL, \'\', 1, NULL, 1, 0, NULL, NULL);
        
        -- --------------------------------------------------------
        
        CREATE TABLE `ca_website` (
          `id` int(11) NOT NULL,
          `domain` text,
          `md5domain` varchar(32) DEFAULT NULL,
          `added` timestamp NULL DEFAULT NULL,
          `modified` timestamp NULL DEFAULT NULL,
          `ready` int(11) NOT NULL DEFAULT \'0\'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        ALTER TABLE `ca_agency_audits`
          ADD KEY `idx-agency_audits-uid` (`uid`);
        
        ALTER TABLE `ca_agency_leads`
          ADD PRIMARY KEY (`id`);
        
        ALTER TABLE `ca_agency_profile`
          ADD PRIMARY KEY (`uid`);
        
        ALTER TABLE `ca_auth_assignment`
          ADD PRIMARY KEY (`item_name`,`user_id`);
        
        ALTER TABLE `ca_auth_item`
          ADD PRIMARY KEY (`name`),
          ADD KEY `rule_name` (`rule_name`),
          ADD KEY `idx-auth_item-type` (`type`);
        
        ALTER TABLE `ca_auth_item_child`
          ADD PRIMARY KEY (`parent`,`child`),
          ADD KEY `child` (`child`);
       
        ALTER TABLE `ca_auth_rule`
          ADD PRIMARY KEY (`name`);
        
        ALTER TABLE `ca_check`
          ADD PRIMARY KEY (`id`),
          ADD KEY `idx-check-wid` (`wid`);
       
        ALTER TABLE `ca_queue`
          ADD PRIMARY KEY (`id`),
          ADD KEY `channel` (`channel`),
          ADD KEY `reserved_at` (`reserved_at`),
          ADD KEY `priority` (`priority`);
        
        ALTER TABLE `ca_user`
          ADD PRIMARY KEY (`id`),
          ADD UNIQUE KEY `idx-user-access_token` (`access_token`),
          ADD KEY `idx-user-reseller_id` (`reseller_id`);
       
        ALTER TABLE `ca_website`
          ADD PRIMARY KEY (`id`),
          ADD KEY `ix_md5domain` (`md5domain`);
        
        ALTER TABLE `ca_agency_leads`
          MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
       
        ALTER TABLE `ca_check`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
       
        ALTER TABLE `ca_queue`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        
        ALTER TABLE `ca_user`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1967;
        
        ALTER TABLE `ca_website`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
        
        ALTER TABLE `ca_auth_assignment`
          ADD CONSTRAINT `ca_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ca_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
        
        ALTER TABLE `ca_auth_item`
          ADD CONSTRAINT `ca_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ca_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;
        
        ALTER TABLE `ca_auth_item_child`
          ADD CONSTRAINT `ca_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ca_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `ca_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ca_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
        
        ALTER TABLE `ca_check`
          ADD CONSTRAINT `fk-check-wid` FOREIGN KEY (`wid`) REFERENCES `ca_website` (`id`) ON DELETE CASCADE;
        COMMIT;
        ');
    }

    public function safeDown()
    {

        $this->dropForeignKey('fk-check-wid', '{{%check}}');
        $this->dropForeignKey('ca_auth_item_child_ibfk_1', '{{%auth_item_child}}');
        $this->dropForeignKey('ca_auth_item_child_ibfk_2', '{{%auth_item_child}}');
        $this->dropForeignKey('ca_auth_assignment_ibfk_1', '{{%auth_assignment}}');
        $this->dropForeignKey('ca_auth_item_ibfk_1', '{{%auth_item}}');

        $this->dropTable('{{%check}}');
        $this->dropTable('{{%website}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%queue}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%agency_profile}}');
        $this->dropTable('{{%agency_leads}}');
        $this->dropTable('{{%agency_audits}}');

    }
}
