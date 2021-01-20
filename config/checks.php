<?php
/*
 * Checks configuration
 *
 * Please place checks by sections. see first item for example
 * Total section score calculates as relation of current score to max possible scores in this section
 */
return [
//########### EXAMPLE ############
    /*
        // HtmlChecks
        'title' => [ // Title tag: $value = title length, $data = title string
            'section' => 'seo', // must be equal to config/sections.php
            'what' => 'Description of this check', // Description of this check (informational text)
            'why' => 'Why is this check important?', // Why is this check important? (informational text)
            'how' => 'Basic tips for improvement', // Basic tips for improvement (informational text)
            'time' => '30 minutes', // Time to complete (informational text)
            'icon' => 'fa-tag', // Icon for Tasks (or future usages)
            'link1' => 'http://absolute.link', // Link to some articles (informational text)
            'link2' => 'http://absolute.link', // Link to some articles (informational text)
            'more-info' => 'http://absolute.link', // Link to some articles (informational text)
            'best-practices' => 'http://absolute.link', // Link to some articles (informational text)
            'how-wordpress' => 'http://absolute.link', // Link to some articles (informational text)
            'how-shopify' => 'http://absolute.link', // Link to some articles (informational text)
            'how-wix' => 'http://absolute.link', // Link to some articles (informational text)
            'append' => '<br/><br/>{$data}<br/><br/>Length : {$value}', // Additional text with variables DO NOT USE DOUBLE QUOTES
            'value' => 'getTitle', // Provider function for value DO NOT CHANGE
            'data' => null, // Provider function for data DO NOT CHANGE
            'scores' => [ // multiple equations for scoring (don't make intersections!)
                '$value == 0' => [ // Equation (Title is empty)
                    'passed' => false, // true, false or null (in case of informational check)
                    'score' => 0, // score, higher means more important in whole section
                    'answer' => Yii::t('report', 'Your page does not appear to have a title tag. Title tags are very important for search engines to correctly understand and categorize your content.'), // Text shown after check (below check's header)
                    'shortAnswer' => 'Missing Title', // Text shown in issues table
                    'recommendation' => Yii::t('report', 'Add a title tag (ideally between 10 and 70 characters)'), // (optional) in Recommendation block at the bottom of report page
                ],
                '$value > 0 and $value < 10' => [ // Title is short, but ok
                    'passed' => false, // mark as passed
                    'score' => 6,
                    'answer' => Yii::t('report', 'You have a title tag, but ideally it should be between 10 and 70 characters in length (including spaces).'),
                    'recommendation' => Yii::t('report', 'Increase length of title tag'),
                    'append' => '<br/><br/>{$data}<br/><br/>'.Yii::t('report', 'Length :').' {$value}', // Additional text with variables DO NOT USE DOUBLE QUOTES
                ],
                '$value >= 10 and $value <= 70' => [ // Title is good
                    'passed' => true,
                    'score' => 6,
                    'answer' => Yii::t('report', 'You have a title tag of optimal length (between 10 and 70 characters).'),
                    'append' => '<br/><br/>{$data}<br/><br/>'.Yii::t('report', 'Length :').' {$value}', // Additional text with variables DO NOT USE DOUBLE QUOTES
                    // Attention! We don't have recommendation here because all is optimal here
                ],
                '$value > 70' => [ // Title is too long, but ok
                    'passed' => false,
                    'score' => 6,
                    'answer' => Yii::t('report', 'You have a title tag, but ideally it should be shortened to between 10 and 70 characters (including spaces).'),
                    'recommendation' => Yii::t('report', 'Reduce length of title tag (to between 10 and 70 characters).'),
                    'append' => '<br/><br/>{$data}<br/><br/>'.Yii::t('report', 'Length :').' {$value}', // Additional text with variables DO NOT USE DOUBLE QUOTES
                ],
            ]
        ],
    */
//########### Profiles ############ (Hidden section)
    'hasFacebook' => [ // Facebook page : $value = facebook profile name
        'section' => 'profiles',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getFacebookProfile',
        'scores' => [
            '$value == false' => [ // No facebook page
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No associated Facebook Page found as a link on your page.'),
                'recommendation' => Yii::t('report', 'Create and link your Facebook Page'),
            ],
            '$value == true' => [ // Has facebook page
                'passed' => true,
                'score' => 0,
                'answer' => Yii::t('report', 'Your page has a link to a Facebook Page.'),
            ],
        ]
    ],
    'hasInstagram' => [ // Instagram page : $value = Instagram profile name
        'section' => 'profiles',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getInstagramProfile',
        'scores' => [
            '$value == false' => [ // No Instagram page
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No associated Instagram Page found as a link on your page.'),
                'recommendation' => Yii::t('report', 'Create and link your Instagram Page'),
            ],
            '$value == true' => [ // Has Instagram page
                'passed' => true,
                'score' => 0,
                'answer' => Yii::t('report', 'Your page has a link to a Instagram Page.'),
            ],
        ]
    ],
    'hasTwitter' => [ // Twitter page : $value = Twitter profile name
        'section' => 'profiles',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getTwitterProfile',
        'scores' => [
            '$value == false' => [ // No Twitter page
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No associated Twitter Page found as a link on your page.'),
                'recommendation' => Yii::t('report', 'Create and link your Twitter Page'),
            ],
            '$value == true' => [ // Has Twitter page
                'passed' => true,
                'score' => 0,
                'answer' => Yii::t('report', 'Your page has a link to a Twitter Page.'),
            ],
        ]
    ],
    'hasYoutube' => [ // Youtube page : $value = Youtube profile name
        'section' => 'profiles',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getYoutubeProfile',
        'scores' => [
            '$value == false' => [ // No Youtube page
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No associated Youtube Page found as a link on your page.'),
                'recommendation' => Yii::t('report', 'Create and link your Youtube Page'),
            ],
            '$value == true' => [ // Has Youtube page
                'passed' => true,
                'score' => 0,
                'answer' => Yii::t('report', 'Your page has a link to a Youtube Page.'),
            ],
        ]
    ],
//########### Facebook ############
    'facebookProfilePicture' => [ //  $value = profile picture url or false
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'hasProfilePicture',
        'scores' => [
            '$value == false' => [ // No profile picture
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No profile picture'),
                'recommendation' => Yii::t('report', 'Create profile picture'),
            ],
            '$value == true' => [ // Has profile picture
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has profile picture.'),
            ],
        ]
    ],
    'facebookCoverPhoto' => [ //  $value = cover is set ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getCoverPhoto',
        'scores' => [
            '$value == false' => [ // No cover photo
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No cover photo'),
                'recommendation' => Yii::t('report', 'Create cover photo'),
            ],
            '$value == true' => [ // Has cover photo
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has cover photo.'),
            ],
        ]
    ],
    'facebookUsername' => [ //  $value = facebook username
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getUsername',
        'append' => '{$value}',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
    'facebookVerified' => [ //  $value = has verified facebook account
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getIsVerified',
        'append' => '{$value}',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
    'facebookContactPhone' => [ //  $value = phone number or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getContactPhone',
        'scores' => [
            '$value == false' => [ // No phone
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No contact phone'),
                'recommendation' => Yii::t('report', 'Create contact phone'),
            ],
            '$value == true' => [ // Has phone
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has contact phone.'),
            ],
        ]
    ],
    'facebookContactWebsite' => [ //  $value = website or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getContactWebsite',
        'scores' => [
            '$value == false' => [ // No website
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No contact website'),
                'recommendation' => Yii::t('report', 'Create contact website'),
            ],
            '$value == true' => [ // Has website
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has contact website.'),
            ],
        ]
    ],
    'facebookContactEmail' => [ //  $value = email or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getContactEmail',
        'scores' => [
            '$value == false' => [ // No email
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No contact email'),
                'recommendation' => Yii::t('report', 'Create contact email'),
            ],
            '$value == true' => [ // Has email
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has contact email.'),
            ],
        ]
    ],
    'facebookAboutText' => [ //  $value = about text or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getAboutText',
        'scores' => [
            '$value == false' => [ // No about text
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No about text'),
                'recommendation' => Yii::t('report', 'Create about text'),
            ],
            '$value == true' => [ // Has about text
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has about text.'),
            ],
        ]
    ],
/* Removed by https://trello.com/c/2o9mIUqh/8-remove-checks
    'facebookCompanyOverviewText' => [ //  $value = company overview text or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getCompanyOverviewText',
        'scores' => [
            '$value == false' => [ // No company overview text
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No company overview text'),
                'recommendation' => Yii::t('report', 'Create company overview text'),
            ],
            '$value == true' => [ // Has company overview text
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has company overview text.'),
            ],
        ]
    ],
    'facebookProductsText' => [ //  $value = products text or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getProductsText',
        'scores' => [
            '$value == false' => [ // No products text
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No products text'),
                'recommendation' => Yii::t('report', 'Create products text'),
            ],
            '$value == true' => [ // Has products text
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has products text.'),
            ],
        ]
    ],
    'facebookMilestonesText' => [ //  $value = milestones text or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'hasMilestonesText',
        'scores' => [
            '$value == false' => [ // No milestones text
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No milestones text'),
                'recommendation' => Yii::t('report', 'Create milestones text'),
            ],
            '$value == true' => [ // Has milestones text
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has milestones text.'),
            ],
        ]
    ],
*/
    'facebookMissionText' => [ //  $value = mission text or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getMissionText',
        'scores' => [
            '$value == false' => [ // No mission text
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No mission text'),
                'recommendation' => Yii::t('report', 'Create mission text'),
            ],
            '$value == true' => [ // Has mission text
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has mission text.'),
            ],
        ]
    ],
    'facebookLocation' => [ //  $value = location or false ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getLocation',
        'scores' => [
            '$value == false' => [ // No location
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No location'),
                'recommendation' => Yii::t('report', 'Create location'),
            ],
            '$value == true' => [ // Has location
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has location.'),
            ],
        ]
    ],
    'facebookLikes' => [ //  $value = likes count ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getLikes',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No likes
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No likes'),
                'recommendation' => Yii::t('report', 'Increase likes'),
            ],
            '$value > 0' => [ // Has likes
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has likes.'),
            ],
        ]
    ],
    'facebookFollows' => [ //  $value = follows count ?
        'section' => 'facebook',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getFollows',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No follows
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No follows'),
                'recommendation' => Yii::t('report', 'Increase follows'),
            ],
            '$value > 0' => [ // Has follows
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has follows.'),
            ],
        ]
    ],
//### posts group
    'facebookRecentPostsFrequency' => [ //  $value = posts per day ?
        'section' => 'facebook',
        'group' => 'facebookPosts',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsPerDay',
        'append' => '{$value}',
        'scores' => [
            '$value < 0.2' => [ // Low frequency
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low frequency'),
                'recommendation' => Yii::t('report', 'Increase posts frequency'),
            ],
            '$value >= 0.2 && $value < 0.5' => [ // Medium frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has medium posts frequency.'),
            ],
            '$value >= 0.5' => [ // High frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has high posts frequency.'),
            ],
        ]
    ],
    'facebookRecentPostsLength' => [ //  $value = average text length ?
        'section' => 'facebook',
        'group' => 'facebookPosts',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageLength',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low text length
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts length'),
                'recommendation' => Yii::t('report', 'Increase posts length'),
            ],
            '$value >= 100' => [ // High text length
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts length.'),
            ],
        ]
    ],
    'facebookRecentPostsLikes' => [ //  $value = average posts likes ?
        'section' => 'facebook',
        'group' => 'facebookPosts',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageLikes',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low posts likes
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts likes'),
                'recommendation' => Yii::t('report', 'Increase posts likes'),
            ],
            '$value >= 100' => [ // High posts likes
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts likes.'),
            ],
        ]
    ],
    'facebookRecentPostsComments' => [ //  $value = average posts comments ?
        'section' => 'facebook',
        'group' => 'facebookPosts',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageComments',
        'append' => '{$value}',
        'scores' => [
            '$value < 10' => [ // Low posts comments
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts comments'),
                'recommendation' => Yii::t('report', 'Increase posts comments'),
            ],
            '$value >= 10' => [ // High posts comments
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts comments.'),
            ],
        ]
    ],
    'facebookRecentPostsCount' => [ //  $value = count of recent posts
        'section' => 'facebook',
        'group' => 'facebookPosts',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentPostsCount',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
                'append' => Yii::t('report', 'For performance reasons, this assessment was only performed on your {$value} most recent posts.'),
            ],
        ]
    ],
    'facebookRecentPostsVariety' => [ //  $value = recent posts variety
        'section' => 'facebook',
        'group' => 'facebookPosts',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentPostsTotalVariety',
        'data' => 'getRecentPostsVariety',
        'append' => '{$value}',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
//########### Instagram ############
    'instagramUsername' => [ //  $value = instagram username
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getUsername',
        'append' => '{$value}',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
    'instagramVerified' => [ //  $value = has verified instagram account
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getIsVerified',
        'append' => '{$value}',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
    'instagramPostsNumber' => [ //  $value = number of instagram posts
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsNumber',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No posts
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No posts'),
                'recommendation' => Yii::t('report', 'Increase posts number'),
            ],
            '$value > 0' => [ // Has posts
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of posts.'),
            ],
        ]
    ],
    'instagramFollowers' => [ //  $value = number of instagram followers
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getFollowers',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No followers
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No followers'),
                'recommendation' => Yii::t('report', 'Increase followers number'),
            ],
            '$value > 0' => [ // Has followers
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of followers.'),
            ],
        ]
    ],
    'instagramFollowings' => [ //  $value = number of instagram followings
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getFollowings',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No followings
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No followings'),
                'recommendation' => Yii::t('report', 'Increase followings number'),
            ],
            '$value > 0' => [ // Has followings
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of followings.'),
            ],
        ]
    ],
    'instagramProfilePicture' => [ //  $value = has instagram profile picture
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getProfilePicture',
        'scores' => [
            '$value == false' => [ // No profile picture
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No profile picture'),
                'recommendation' => Yii::t('report', 'Create profile picture'),
            ],
            '$value == true' => [ // Has profile picture
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has profile picture.'),
            ],
        ]
    ],
    'instagramTitle' => [ //  $value = has instagram description title
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getProfileTitle',
        'scores' => [
            '$value == false' => [ // No description title
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No description title'),
                'recommendation' => Yii::t('report', 'Create description title'),
            ],
            '$value == true' => [ // Has description title
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has description title.'),
            ],
        ]
    ],
    'instagramDescription' => [ //  $value = has instagram description
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getProfileDescription',
        'scores' => [
            '$value == false' => [ // No description
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No description'),
                'recommendation' => Yii::t('report', 'Create description'),
            ],
            '$value == true' => [ // Has description
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has description.'),
            ],
        ]
    ],
    'instagramExternalUrl' => [ //  $value = has instagram external url
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getExternalUrl',
        'scores' => [
            '$value == false' => [ // No external url
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No external url'),
                'recommendation' => Yii::t('report', 'Create external url'),
            ],
            '$value == true' => [ // Has external url
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has external url.'),
            ],
        ]
    ],
    'instagramRecentPostsFrequency' => [ //  $value = posts per day ?
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsPerDay',
        'append' => '{$value}',
        'scores' => [
            '$value < 0.2' => [ // Low frequency
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low frequency'),
                'recommendation' => Yii::t('report', 'Increase posts frequency'),
            ],
            '$value >= 0.2 && $value < 0.5' => [ // Medium frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has medium posts frequency.'),
            ],
            '$value >= 0.5' => [ // High frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has high posts frequency.'),
            ],
        ]
    ],
    'instagramRecentPostsLength' => [ //  $value = average text length ?
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageLength',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low text length
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts length'),
                'recommendation' => Yii::t('report', 'Increase posts length'),
            ],
            '$value >= 100' => [ // High text length
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts length.'),
            ],
        ]
    ],
    'instagramRecentPostsLikes' => [ //  $value = average posts likes ?
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageLikes',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low posts likes
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts likes'),
                'recommendation' => Yii::t('report', 'Increase posts likes'),
            ],
            '$value >= 100' => [ // High posts likes
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts likes.'),
            ],
        ]
    ],
    'instagramRecentPostsComments' => [ //  $value = average posts comments ?
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageComments',
        'append' => '{$value}',
        'scores' => [
            '$value < 10' => [ // Low posts comments
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts comments'),
                'recommendation' => Yii::t('report', 'Increase posts comments'),
            ],
            '$value >= 10' => [ // High posts comments
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts comments.'),
            ],
        ]
    ],
    'instagramRecentPostsCount' => [ //  $value = count of recent posts
        'section' => 'instagram',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentPostsCount',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
                'append' => Yii::t('report', 'For performance reasons, this assessment was only performed on your {$value} most recent posts.'),
            ],
        ]
    ],
//########### Twitter ############
    'twitterDescription' => [ //  $value = has twitter description
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getProfileDescription',
        'scores' => [
            '$value == false' => [ // No description
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No description'),
                'recommendation' => Yii::t('report', 'Create description'),
            ],
            '$value == true' => [ // Has description
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has description.'),
            ],
        ]
    ],
    'twitterExternalUrl' => [ //  $value = has twitter external url
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getExternalUrl',
        'append' => '{$value}',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
    'twitterProfilePicture' => [ //  $value = has twitter profile picture
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getProfilePicture',
        'scores' => [
            '$value == false' => [ // No profile picture
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No profile picture'),
                'recommendation' => Yii::t('report', 'Create profile picture'),
            ],
            '$value == true' => [ // Has profile picture
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has profile picture.'),
            ],
        ]
    ],
    'twitterHeaderPicture' => [ //  $value = has twitter Header picture
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getHeaderPicture',
        'scores' => [
            '$value == false' => [ // No Header picture
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No profile header picture'),
                'recommendation' => Yii::t('report', 'Create profile header picture'),
            ],
            '$value == true' => [ // Has Header picture
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has profile header picture.'),
            ],
        ]
    ],
    'twitterLocation' => [ //  $value = has twitter Location
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getLocation',
        'scores' => [
            '$value == false' => [ // No Location
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No Location'),
                'recommendation' => Yii::t('report', 'Create Location'),
            ],
            '$value == true' => [ // Has Location
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has Location.'),
            ],
        ]
    ],
    'twitterTweetsNumber' => [ //  $value = number of twitter tweets
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getTweetsNumber',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No tweets
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No tweets'),
                'recommendation' => Yii::t('report', 'Increase tweets number'),
            ],
            '$value > 0' => [ // Has tweets
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of tweets.'),
            ],
        ]
    ],
    'twitterFollowers' => [ //  $value = number of twitter followers
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getFollowers',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No followers
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No followers'),
                'recommendation' => Yii::t('report', 'Increase followers number'),
            ],
            '$value > 0' => [ // Has followers
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of followers.'),
            ],
        ]
    ],
    'twitterLikesNumber' => [ //  $value = number of twitter likes
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getLikesNumber',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No likes
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No likes'),
                'recommendation' => Yii::t('report', 'Increase likes number'),
            ],
            '$value > 0' => [ // Has likes
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of likes.'),
            ],
        ]
    ],
    'twitterRecentPostsFrequency' => [ //  $value = posts per day ?
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsPerDay',
        'append' => '{$value}',
        'scores' => [
            '$value < 0.2' => [ // Low frequency
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low frequency'),
                'recommendation' => Yii::t('report', 'Increase posts frequency'),
            ],
            '$value >= 0.2 && $value < 0.5' => [ // Medium frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has medium posts frequency.'),
            ],
            '$value >= 0.5' => [ // High frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has high posts frequency.'),
            ],
        ]
    ],
    'twitterRecentPostsLength' => [ //  $value = average text length ?
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageLength',
        'scores' => [
            '$value < 100' => [ // Low text length
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts length'),
                'recommendation' => Yii::t('report', 'Increase posts length'),
            ],
            '$value >= 100' => [ // High text length
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts length.'),
            ],
        ]
    ],
    'twitterRecentPostsLikes' => [ //  $value = average posts likes ?
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageLikes',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low posts likes
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts likes'),
                'recommendation' => Yii::t('report', 'Increase posts likes'),
            ],
            '$value >= 100' => [ // High posts likes
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts likes.'),
            ],
        ]
    ],
    'twitterRecentPostsRetweets' => [ //  $value = average posts retweets ?
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getPostsAverageRetweets',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low posts retweets
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low posts retweets'),
                'recommendation' => Yii::t('report', 'Increase posts retweets'),
            ],
            '$value >= 100' => [ // High posts retweets
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good posts retweets.'),
            ],
        ]
    ],
    'twitterRecentBestPosts' => [ //  $value = count posts
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentBestPostsCount',
        'data' => 'getRecentBestPosts',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
    'twitterRecentPostsCount' => [ //  $value = count of recent posts
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentPostsCount',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
                'append' => Yii::t('report', 'For performance reasons, this assessment was only performed on your {$value} most recent posts.'),
            ],
        ]
    ],
    'twitterRecentPostsVariety' => [ //  $value = recent posts variety
        'section' => 'twitter',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentPostsTotalVariety',
        'data' => 'getRecentPostsVariety',
        'append' => '{$value}',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
//########### Youtube ############
    'youtubeTitle' => [ //  $value = has youtube description title
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getProfileTitle',
        'append' => '{$value}',
        'scores' => [
            '$value == false' => [ // No description title
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No description title'),
                'recommendation' => Yii::t('report', 'Create description title'),
            ],
            '$value == true' => [ // Has description title
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has description title.'),
            ],
        ]
    ],
    'youtubeSubscribers' => [ //  $value = number of youtube subscribers
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getSubscribers',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No subscribers
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No followers'),
                'recommendation' => Yii::t('report', 'Increase followers number'),
            ],
            '$value > 0' => [ // Has subscribers
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of followers.'),
            ],
        ]
    ],
    'youtubeVideos' => [ //  $value = number of youtube videos
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getVideosNumber',
        'append' => '{$value}',
        'scores' => [
            '$value == 0' => [ // No videos
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No videos'),
                'recommendation' => Yii::t('report', 'Increase videos number'),
            ],
            '$value > 0' => [ // Has videos
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good number of videos.'),
            ],
        ]
    ],
    'youtubeDescription' => [ //  $value = has youtube description
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'hasProfileDescription',
        'data' => 'getProfileDescription',
        'scores' => [
            '$value == false' => [ // No description
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No description'),
                'recommendation' => Yii::t('report', 'Create description'),
            ],
            '$value == true' => [ // Has description
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has description.'),
            ],
        ]
    ],
    'youtubeCountry' => [ //  $value = has youtube country
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'hasProfileCountry',
        'data' => 'getProfileCountry',
        'append' => '{$value}',
        'scores' => [
            '$value == false' => [ // No country
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'No country'),
                'recommendation' => Yii::t('report', 'Create country'),
            ],
            '$value == true' => [ // Has country
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has country.'),
            ],
        ]
    ],
    'youtubeRecentVideosFrequency' => [ //  $value = videos per day
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getVideosPerDay',
        'append' => '{$value}',
        'scores' => [
            '$value < 0.2' => [ // Low frequency
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low frequency'),
                'recommendation' => Yii::t('report', 'Increase videos frequency'),
            ],
            '$value >= 0.2 && $value < 0.5' => [ // Medium frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has medium videos frequency.'),
            ],
            '$value >= 0.5' => [ // High frequency
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has high videos frequency.'),
            ],
        ]
    ],
    'youtubeRecentVideosViews' => [ //  $value = average videos views
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getVideosAverageViews',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low videos views
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low videos views'),
                'recommendation' => Yii::t('report', 'Increase videos views'),
            ],
            '$value >= 100' => [ // High videos views
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good videos views.'),
            ],
        ]
    ],
    'youtubeRecentVideosLikes' => [ //  $value = average videos likes
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getVideosAverageLikes',
        'append' => '{$value}',
        'scores' => [
            '$value < 100' => [ // Low videos likes
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low videos likes'),
                'recommendation' => Yii::t('report', 'Increase videos likes'),
            ],
            '$value >= 100' => [ // High videos likes
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good videos likes.'),
            ],
        ]
    ],
    'youtubeRecentVideosComments' => [ //  $value = average videos comments
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getVideosAverageComments',
        'append' => '{$value}',
        'scores' => [
            '$value < 10' => [ // Low videos comments
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Low videos comments'),
                'recommendation' => Yii::t('report', 'Increase videos comments'),
            ],
            '$value >= 10' => [ // High videos comments
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has good videos comments.'),
            ],
        ]
    ],
    'youtubeRecentVideosCount' => [ //  $value = count of recent posts
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentVideosCount',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
                'append' => Yii::t('report', 'For performance reasons, this assessment was only performed on your {$value} most recent posts.'),
            ],
        ]
    ],
    'youtubeRecentBestVideos' => [ //  $value = count videos
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'getRecentBestVideosCount',
        'data' => 'getRecentBestVideos',
        'scores' => [
            'true' => [ // informational
                'passed' => null,
                'score' => 0,
                'answer' => '',
            ],
        ]
    ],
    'youtubeRecentVideoCompletion' => [ //  $value = has all completed videos?
        'section' => 'youtube',
        'what' => 'Description of this check',
        'why' => 'Why is this check important?',
        'how' => 'Basic tips for improvement',
        'value' => 'hasRecentVideosCompleted',
        'data' => 'getRecentUncompletedVideos',
        'scores' => [
            '$value == false' => [ // Has one or more uncompleted videos
                'passed' => false,
                'score' => 0,
                'answer' => Yii::t('report', 'Has one or more uncompleted videos'),
                'recommendation' => Yii::t('report', 'Complete videos'),
            ],
            '$value == true' => [ // Has all completed videos
                'passed' => true,
                'score' => 1,
                'answer' => Yii::t('report', 'Your page has all completed videos.'),
            ],
        ]
    ],
];