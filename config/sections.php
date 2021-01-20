<?php
/*
 * Sections configuration
 *
 * Grades config you can find in config/params.php
 * Total section score calculates as relation of current score to max possible scores in this section
 */
return [
    "website" => array(
        // minimal score => messages
        80 => array("title" => Yii::t('report', 'Your page is very good!')),
        65 => array("title" => Yii::t('report', 'Your page is good')),
        30 => array("title" => Yii::t('report', 'Your page could be better')),
        0 => array("title" => Yii::t('report', 'Your page needs improvement')),
    ),
    "social" => array(
        80 => array(
            "title" => Yii::t('report', 'Your social is very good!'),
            "description" => Yii::t('report', 'Congratulations, your social presence is strong and active. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend continued use of social campaigns to grow this further.'),
        ),
        65 => array(
            "title" => Yii::t('report', 'Your social is good'),
            "description" => Yii::t('report', 'You have a reasonably good social presence. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page, and work to build a larger following on those networks.'),
        ),
        30 => array(
            "title" => Yii::t('report', 'Your social could be better'),
            "description" => Yii::t('report', 'You do not appear to have a strong social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page for visibility, and work to build a following on those networks.'),
        ),
        0 => array(
            "title" => Yii::t('report', 'Your social needs improvement'),
            "description" => Yii::t('report', 'You appear to have a weak social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring visitors to your website. We recommend that you list all of your profiles on your page for visibility, and begin to build a following on those networks.'),
        ),
    ),
    "facebook" => array(
        80 => array(
            "title" => Yii::t('report', 'Your social is very good!'),
            "description" => Yii::t('report', 'Congratulations, your social presence is strong and active. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend continued use of social campaigns to grow this further.'),
        ),
        65 => array(
            "title" => Yii::t('report', 'Your social is good'),
            "description" => Yii::t('report', 'You have a reasonably good social presence. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page, and work to build a larger following on those networks.'),
        ),
        30 => array(
            "title" => Yii::t('report', 'Your social could be better'),
            "description" => Yii::t('report', 'You do not appear to have a strong social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page for visibility, and work to build a following on those networks.'),
        ),
        0 => array(
            "title" => Yii::t('report', 'Your social needs improvement'),
            "description" => Yii::t('report', 'You appear to have a weak social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring visitors to your website. We recommend that you list all of your profiles on your page for visibility, and begin to build a following on those networks.'),
        ),
    ),
    "twitter" => array(
        80 => array(
            "title" => Yii::t('report', 'Your social is very good!'),
            "description" => Yii::t('report', 'Congratulations, your social presence is strong and active. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend continued use of social campaigns to grow this further.'),
        ),
        65 => array(
            "title" => Yii::t('report', 'Your social is good'),
            "description" => Yii::t('report', 'You have a reasonably good social presence. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page, and work to build a larger following on those networks.'),
        ),
        30 => array(
            "title" => Yii::t('report', 'Your social could be better'),
            "description" => Yii::t('report', 'You do not appear to have a strong social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page for visibility, and work to build a following on those networks.'),
        ),
        0 => array(
            "title" => Yii::t('report', 'Your social needs improvement'),
            "description" => Yii::t('report', 'You appear to have a weak social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring visitors to your website. We recommend that you list all of your profiles on your page for visibility, and begin to build a following on those networks.'),
        ),
    ),
    "instagram" => array(
        80 => array(
            "title" => Yii::t('report', 'Your social is very good!'),
            "description" => Yii::t('report', 'Congratulations, your social presence is strong and active. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend continued use of social campaigns to grow this further.'),
        ),
        65 => array(
            "title" => Yii::t('report', 'Your social is good'),
            "description" => Yii::t('report', 'You have a reasonably good social presence. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page, and work to build a larger following on those networks.'),
        ),
        30 => array(
            "title" => Yii::t('report', 'Your social could be better'),
            "description" => Yii::t('report', 'You do not appear to have a strong social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page for visibility, and work to build a following on those networks.'),
        ),
        0 => array(
            "title" => Yii::t('report', 'Your social needs improvement'),
            "description" => Yii::t('report', 'You appear to have a weak social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring visitors to your website. We recommend that you list all of your profiles on your page for visibility, and begin to build a following on those networks.'),
        ),
    ),
    "youtube" => array(
        80 => array(
            "title" => Yii::t('report', 'Your social is very good!'),
            "description" => Yii::t('report', 'Congratulations, your social presence is strong and active. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend continued use of social campaigns to grow this further.'),
        ),
        65 => array(
            "title" => Yii::t('report', 'Your social is good'),
            "description" => Yii::t('report', 'You have a reasonably good social presence. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page, and work to build a larger following on those networks.'),
        ),
        30 => array(
            "title" => Yii::t('report', 'Your social could be better'),
            "description" => Yii::t('report', 'You do not appear to have a strong social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page for visibility, and work to build a following on those networks.'),
        ),
        0 => array(
            "title" => Yii::t('report', 'Your social needs improvement'),
            "description" => Yii::t('report', 'You appear to have a weak social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring visitors to your website. We recommend that you list all of your profiles on your page for visibility, and begin to build a following on those networks.'),
        ),
    ),
    "linkedIn" => array(
        80 => array(
            "title" => Yii::t('report', 'Your social is very good!'),
            "description" => Yii::t('report', 'Congratulations, your social presence is strong and active. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend continued use of social campaigns to grow this further.'),
        ),
        65 => array(
            "title" => Yii::t('report', 'Your social is good'),
            "description" => Yii::t('report', 'You have a reasonably good social presence. Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page, and work to build a larger following on those networks.'),
        ),
        30 => array(
            "title" => Yii::t('report', 'Your social could be better'),
            "description" => Yii::t('report', 'You do not appear to have a strong social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring more visitors to your website. We recommend that you have all of your profiles listed on your page for visibility, and work to build a following on those networks.'),
        ),
        0 => array(
            "title" => Yii::t('report', 'Your social needs improvement'),
            "description" => Yii::t('report', 'You appear to have a weak social presence or level of social activity (or we may just not be able to see your profiles!). Social activity is important for customer communication, brand awareness and as a marketing channel to bring visitors to your website. We recommend that you list all of your profiles on your page for visibility, and begin to build a following on those networks.'),
        ),
    ),
];